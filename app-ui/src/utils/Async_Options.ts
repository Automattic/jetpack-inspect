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


const opts = getOptionsFromGlobal("jetpack_inspect", Jetpack_Inspect_Options);
const options = new Options(opts);

const endpoint = options.get("rest_api");
const api = new AsyncAPI(endpoint.value, endpoint.nonce);


const monitorStatus = options.createStore(
	"monitor_status",
	async ({ value, nonce }) => await api.POST<typeof value>("monitor-status", nonce, value.toString())
)

const observerIncoming = options.createStore(
	"observer_incoming",
	async ({ value, nonce }) => await api.POST<typeof value>("observer-incoming", nonce, value)
)

const observerOutgoing = options.createStore(
	"observer_outgoing",
	async ({ value, nonce }) => await api.POST<typeof value>("observer-outgoing", nonce, value)
)

export const asyncOptions = {
	observerIncoming,
	observerOutgoing,
	monitorStatus,
}

export const {
	pending: isObserverUpdating,
	store: outgoingObserverSettings,
} = observerOutgoing

export { api as API };
