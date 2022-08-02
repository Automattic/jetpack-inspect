import { z } from 'zod';
import API from './API';
import { getOptionsFromGlobal } from './AsyncOptions/Global';
import { Options } from './AsyncOptions/Options';

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


const validatedOptions = getOptionsFromGlobal("jetpack_inspect", OptionValidator);
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
