import type { AsyncOptions as AO } from "./types";
import type AsyncAPI from './AsyncAPI';
import type { Options } from './Options';

export function asyncOptionFactory<T extends AO.Options>(options: Options<T>, api: AsyncAPI) {
	return function <K extends keyof T>(name: K) {
		const endpoint = name.replace("_", "-");
		return options.createStore(name, async ({ value, nonce }) => {
			return await api.POST<typeof value>(endpoint, nonce, value);
		});
	}
}
