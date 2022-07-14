<script lang="ts">
	import Filters from './Filters.svelte';
	import { onMount } from "svelte";

	export let monitorStatus = false;
	import REST_API from "@src/utils/API";

	let message;
	let inboundActive = false;
	let outboundActive = false;

	const api = new REST_API();

	async function monitorOutbound() {
		outboundActive = !outboundActive;
		const request = await api.toggleMonitorStatus('outbound_request');

		outboundActive = request
	}

	async function monitorInbound() {
		inboundActive = !inboundActive;
		const request = await api.toggleMonitorStatus('inbound_rest_request');

		inboundActive = request
	}

	async function clear() {
		message = "";
		if (await api.clear()) {
			message = "Cleared all data!";
		}
	}


	onMount(async () => {
		inboundActive = await api.getMonitorStatus('inbound_rest_request');
		outboundActive = await api.getMonitorStatus('outbound_request');
	});

	let inboundLabel: string;
	let outboundLabel: string;
	$: inboundLabel = inboundActive ? "Inbound Monitoring..." : "Monitor Inbound";
	$: outboundLabel = outboundActive ? "Outbound Monitoring..." : "Monitor Outbound";
	$: monitorStatus = inboundActive || outboundActive
</script>

<div class="actions">
	<Filters name="inbound_rest_request" />
	<button class="ji-button" on:click|preventDefault={monitorInbound}>
		{inboundLabel}
	</button>

	<br>

	<Filters name="outbound_request" />
	<button class="ji-button" on:click|preventDefault={monitorOutbound}>
		{outboundLabel}
	</button>

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
