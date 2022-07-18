<script lang="ts">
	import { createEventDispatcher } from "svelte";
	import ActivateMonitor from "./ActivateMonitor.svelte";

	const dispatch = createEventDispatcher();

	export let isMonitoring = false;
	import REST_API from "@src/utils/API";

	const api = new REST_API();

	async function clear() {
		if (await api.clear()) {
			dispatch("clear");
		}
	}

	let isMonitoringInbound = false;
	let isMonitoringOutbound = false;
	$: isMonitoring = isMonitoringInbound || isMonitoringOutbound;
</script>

<div class="actions">
	<ActivateMonitor
		label="Inbound"
		name="inbound_rest_request"
		bind:isActive={isMonitoringInbound}
	/>
	<br />
	<ActivateMonitor
		label="Outbound"
		name="outbound_request"
		bind:isActive={isMonitoringOutbound}
	/>

	<button id="clear" class="ji-button" on:click|preventDefault={clear}>
		Clear All
	</button>
</div>

<style>
	.actions {
		padding: 20px 0;
		display: flex;
		gap: 10px;
	}

	#clear {
		margin-left: auto;
	}
</style>
