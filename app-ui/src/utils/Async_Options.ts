import { writable } from 'svelte/store';
import type { Writable } from "svelte/store";
import { z } from 'zod';
import API from './API';

const Jetpack_Inspect = z.object({
	"rest_api": z.object({
		"base": z.string().url(),
		"nonce": z.string()
	}),
});

function parseOptions<T extends z.ZodTypeAny>(parser: T, key: string) {
	let options = {};
	if (key in window) {
		// Ignore TypeScript complaints just this once.
		// @ts-ignore
		options = window[key];
	}

	return parser.safeParse(options);
}

const options = parseOptions(Jetpack_Inspect, "jetpack_inspect");
console.log(options)

function createPendingStore() {
	const { set, subscribe } = writable(false);
	return {
		subscribe,
		stop: () => set(false),
		start: () => set(true),
	}
}

function asyncOption(initialValue) {
	const store = writable(initialValue);
	const pending = createPendingStore();

	const api = new API();

	let requestLock = false;
	let debounce = 0;


	// Sync the value to the API
	// And make sure that the value
	// hasn't changed since it was last submitted.
	const send = async (value) => {

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
			let result = await api.setMonitorStatus(value);
			requestLock = false;

			// Ensure that the value returned is reflected in the UI.
			if (result !== value) {
				value.update(() => result);
			}
			pending.stop();
		}, 200);
	}

	// Send the store value to the API
	store.set = (value) => {
		pending.start();
		store.update(() => value);
		send(value);
	}


	return {
		value: store,
		state: pending,
	};
}



const monitorStatus = asyncOption(window.jetpack_inspect["monitor_status"].value);

export {
	monitorStatus
};
