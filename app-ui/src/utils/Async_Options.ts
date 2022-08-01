import { writable } from 'svelte/store';
import type { Writable, Readable } from "svelte/store";
import { z } from 'zod';
import API from './API';

interface PendingStore {
	subscribe: Writable<boolean>["subscribe"];
	stop: () => void;
	start: () => void;
}

interface AsyncStore<T> {
	value: Writable<T>;
	state: PendingStore;
}


function parseOptions<T extends z.ZodTypeAny>(parser: T, key: string) {
	let options = {};
	if (key in window) {
		// Ignore TypeScript complaints just this once.
		// @ts-ignore
		options = window[key];
	}

	return parser.safeParse(options);
}

function createPendingStore(): PendingStore {
	const { set, subscribe } = writable(false);
	return {
		subscribe,
		stop: () => set(false),
		start: () => set(true),
	}
}



function asyncOption<T>(initialValue: T, updateCb: (value: T) => Promise<T>): AsyncStore<T> {
	const store = writable(initialValue);
	const pending = createPendingStore();

	let requestLock = false;
	let debounce = 0;


	// Sync the value to the API
	// And make sure that the value
	// hasn't changed since it was last submitted.
	const send = async (value: T) => {

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
			let result = await updateCb(value);
			requestLock = false;

			// Ensure that the value returned is reflected in the UI.
			if (result !== value) {
				store.update(() => result);
			}
			pending.stop();
		}, 200);
	}

	// Send the store value to the API
	store.set = (value: T) => {
		pending.start();
		store.update(() => value);
		send(value);
	}


	return {
		value: store,
		state: pending,
	};
}

const Jetpack_Inspect = z.object({
	"rest_api": z.object({
		"base": z.string().url(),
		"nonce": z.string()
	}),
	"monitor_status": z.object({
		"value": z.boolean(),
		"nonce": z.string()
	}),
});
const options = parseOptions(Jetpack_Inspect, "jetpack_inspect");


const monitorStatusOption: boolean = options["monitor_status"].value

const monitorStatus = asyncOption(monitorStatusOption, async (value) => {
	const api = new API();
	return api.setMonitorStatus(value);
});

export {
	monitorStatus
};
