// @TODO: need feedback on this: 👇
import type { AsyncOptions as AO } from "./types";
import { writable } from 'svelte/store';

function createPendingStore(): AO.PendingStore {
	const { set, subscribe } = writable(false);
	return {
		subscribe,
		stop: () => set(false),
		start: () => set(true),
	}
}

export class Options<T extends AO.Options> {
	private options: T;

	constructor(options: T) {
		this.options = options;
	}

	value<K extends keyof T>(key: K): T[K]["value"] {
		return this.options[key].value;
	}

	createStore<K extends keyof T>(key: K, updateCallback: (value: T[K]) => Promise<T[K]["value"]>): AO.OptionStore<T[K]["value"]> {

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
