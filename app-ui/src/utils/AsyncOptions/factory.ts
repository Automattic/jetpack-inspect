import type { AsyncOptions as AO } from "./types";
import AsyncAPI from './AsyncAPI';
import { Options } from './Options';
import type { z } from 'zod';
import { options } from "../API";


export function getOptionsFromGlobal<T extends z.ZodTypeAny>(key: string, parser: T): z.infer<T> {
	if (!(key in window)) {
		console.error(`Could not locate global variable ${key}`);
		return false;
	}

	// @TODO: Mark? Any Ideas to avoid @ts-ignore?
	// Ignore TypeScript complaints just this once.
	// @ts-ignore
	const obj = window[key];
	const result = parser.safeParse(obj);

	if (!result.success) {
		console.error("Error parsing options for", key, result.error);

		// @TODO: Maybe no options are found, return everything as false?
		// That way at least it's not a fatal?
		return false;
	}

	return result.data;
}

function asyncOptionFactory<T extends AO.Options>(options: Options<T>, api: AsyncAPI) {
	return function <K extends keyof T & string>(name: K) {
		const endpoint = name.replace("_", "-");
		return options.createStore(name, async ({ value, nonce }) => {
			return await api.POST<typeof value>(endpoint, nonce, value);
		});
	}
}

export function createAsyncFactory<T extends z.ZodTypeAny>(name: string, validator: T) {

	const globals = getOptionsFromGlobal(name, validator);
	const options = new Options(globals);
	const endpoint = options.get("rest_api");
	const api = new AsyncAPI(endpoint.value, endpoint.nonce);

	return {
		createStore: asyncOptionFactory(options, api),
		api,
		options,
	};
}
