import { writable } from 'svelte/store';
import type { Writable } from "svelte/store";
import { z } from 'zod';
import API from './API';

interface PendingStore {
	subscribe: Writable<boolean>["subscribe"];
	stop: () => void;
	start: () => void;
}



function createPendingStore(): PendingStore {
	const { set, subscribe } = writable(false);
	return {
		subscribe,
		stop: () => set(false),
		start: () => set(true),
	}
}

function getValidatedOptions<T extends z.ZodTypeAny>(parser: T, key: string): z.infer<T> {
	let options = {};
	if (key in window) {
		// Ignore TypeScript complaints just this once.
		// @ts-ignore
		options = window[key];
		console.log("Setting options to", options);
	} else {
		console.error("No options found for", key);
	}

	const parsed = parser.safeParse(options);
	if (!parsed.success) {
		console.error("Error parsing options for", key, parsed.error);
		return false;
	}

	return parsed.data;
}


type OptionShape = {
	[key: string]: {
		value: any,
		nonce: string,
	}
}

interface AsyncStore<T> {
	store: Writable<T>
	pending: PendingStore;
}

class Options<T extends OptionShape> {
	private options: T;

	constructor(namespace: string, options: T) {
		this.options = options;
	}

	value<K extends keyof T>(key: K): T[K]["value"] {
		return this.options[key].value;
	}

	createStore<K extends keyof T>(key: K, updateCallback: (value: T[K]) => Promise<T[K]["value"]>): AsyncStore<T[K]["value"]> {

		const store = writable(this.value(key));
		const pending = createPendingStore();

		let requestLock = false;
		let debounce = 0;

		// Sync the value to the API
		// And make sure that the value
		// hasn't changed since it was last submitted.
		const send = async (value: T[K]["value"]) => {

			// Prevent multiple requests from being sent at once.
			if (requestLock) {
				return;
			}

			// If UI Changes rapidly, wait for it to settle before issuing the request.
			if (debounce) {
				clearTimeout(debounce);
			}

			// Sync the setting to the server
			debounce = setTimeout(async () => {
				requestLock = true;
				let result = await updateCallback({
					...this.options[key],
					value,
				});
				requestLock = false;

				// Ensure that the value returned is reflected in the UI.
				if (result !== value) {
					store.update(() => result);
				}
				pending.stop();
			}, 200);
		}

		// Send the store value to the API
		store.set = (value: T[K]["value"]) => {
			pending.start();
			store.update(() => value);
			send(value);
		}

		return {
			store: store,
			pending: pending,
		};
	}
}



const OptionValidator = z.object({
	"rest_api": z.object({
		"value": z.string().url(),
		"nonce": z.string()
	}),
	"monitor_status": z.object({
		"value": z.boolean(),
		"nonce": z.string()
	}),
});


type OptionType = z.infer<typeof OptionValidator>


const validatedOptions = getValidatedOptions(OptionValidator, "jetpack_inspect");
if (!validatedOptions) {
	throw new Error("Invalid options");
}


const options = new Options<OptionType>("jetpack_inspect", validatedOptions);
const monitorStore = options.createStore("monitor_status", async ({ value, nonce }) => {
	console.log("Value updated!", value, nonce);
	const api = new API();
	return await api.setMonitorStatus(value);
});

export const monitorStatus = monitorStore;
