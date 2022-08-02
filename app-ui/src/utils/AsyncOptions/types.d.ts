import type { Writable } from "svelte/store";

export namespace AsyncOptions {

	interface Options {
		[key: string]: {
			value: any,
			nonce: string,
		}
	}

	interface PendingStore {
		subscribe: Writable<boolean>["subscribe"];
		stop: () => void;
		start: () => void;
	}

	interface OptionStore<T> {
		store: Writable<T>
		pending: PendingStore;
	}

}
