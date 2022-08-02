import { z } from 'zod';
import API from './API';
import { Options } from './AsyncOptions/Options';



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

export const {
	pending: isMonitorUpdating,
	store: isMonitoring
} = options.createStore("monitor_status", async ({ value, nonce }) => {
	const api = new API();
	return await api.setMonitorStatus(value);
});
