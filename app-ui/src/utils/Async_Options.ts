import { z } from 'zod';
import API from './API';
import { getOptionsFromGlobal } from './AsyncOptions/Global';
import { Options } from './AsyncOptions/Options';

const Jetpack_Inspect_Options = z.object({
	"rest_api": z.object({
		"value": z.string().url(),
		"nonce": z.string()
	}),
	"monitor_status": z.object({
		"value": z.boolean(),
		"nonce": z.string()
	}),
});


const opts = getOptionsFromGlobal("jetpack_inspect", Jetpack_Inspect_Options);
const options = new Options(opts);

const endpoint = options.get("rest_api");
const api = new API(endpoint.nonce, endpoint.value);


const monitorStatus = options.createStore(
	"monitor_status",
	async ({ value, nonce }) => await api.setMonitorStatus(value)
)



export const {
	pending: isMonitorUpdating,
	store: isMonitoring
} = monitorStatus;
