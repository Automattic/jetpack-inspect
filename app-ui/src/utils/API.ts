import { z } from 'zod';
import AsyncAPI from './AsyncOptions/AsyncAPI';
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
	"observer_incoming": z.object({
		"value": z.object({
			"enabled": z.boolean(),
			"filter": z.string(),
		}),
		"nonce": z.string()
	}),
	"observer_outgoing": z.object({
		"value": z.object({
			"enabled": z.boolean(),
			"filter": z.string(),
		}),
		"nonce": z.string()
	}),
});


const globals = getOptionsFromGlobal("jetpack_inspect", Jetpack_Inspect_Options);
const asyncOptions = new Options(globals);

const endpoint = asyncOptions.get("rest_api");
const api = new AsyncAPI(endpoint.value, endpoint.nonce);


const monitorStatus = asyncOptions.createStore(
	"monitor_status",
	async ({ value, nonce }) => await api.POST<typeof value>("monitor-status", nonce, value.toString())
)

const observerIncoming = asyncOptions.createStore(
	"observer_incoming",
	async ({ value, nonce }) => await api.POST<typeof value>("observer-incoming", nonce, value)
)

const observerOutgoing = asyncOptions.createStore(
	"observer_outgoing",
	async ({ value, nonce }) => await api.POST<typeof value>("observer-outgoing", nonce, value)
)

export const options = {
	observerIncoming,
	observerOutgoing,
	monitorStatus,
};

export { api as API };
