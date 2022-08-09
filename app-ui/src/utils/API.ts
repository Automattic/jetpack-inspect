import { z } from 'zod';
import AsyncAPI from './AsyncOptions/AsyncAPI';
import { getOptionsFromGlobal } from './AsyncOptions/Global';
import { Options } from './AsyncOptions/Options';
import { asyncOptionFactory } from './AsyncOptions/factory';

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
const opts = new Options(globals);
const endpoint = opts.get("rest_api");
const api = new AsyncAPI(endpoint.value, endpoint.nonce);
const asyncStore = asyncOptionFactory(opts, api);

export const options = {
	monitorStatus: asyncStore("monitor_status"),
	observerIncoming: asyncStore("observer_incoming"),
	observerOutgoing: asyncStore("observer_outgoing")
};

export { api as API };
