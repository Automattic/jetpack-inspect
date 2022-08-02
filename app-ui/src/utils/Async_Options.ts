import { z } from 'zod';
import API from './API';
import { Options } from './AsyncOptions/Options';



function getValidatedOptions<T extends z.ZodTypeAny>(key: string, parser: T): z.infer<T> {
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
		return false;
	}

	return result.data;
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


const validatedOptions = getValidatedOptions("jetpack_inspect", OptionValidator);
if (!validatedOptions) {
	throw new Error("Invalid options");
}


const options = new Options(validatedOptions);

export const {
	pending: isMonitorUpdating,
	store: isMonitoring
} = options.createStore("monitor_status", async ({ value, nonce }) => {
	const api = new API();
	return await api.setMonitorStatus(value);
});
