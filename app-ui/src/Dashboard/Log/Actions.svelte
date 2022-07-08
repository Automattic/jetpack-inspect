<script lang="ts">
	import Filters from './Filters.svelte';
	import { onMount } from "svelte";

	export let monitorStatus = false;
	import REST_API from "@src/utils/API";
	let message;

	const api = new REST_API();

	async function monitor() {
		monitorStatus = !monitorStatus;
		const request = await api.toggleMonitorStatus();

		monitorStatus = request
	}

	async function clear() {
		message = "";
		if (await api.clear()) {
			message = "Cleared all data!";
		}
	}


	onMount(async () => {
		monitorStatus = await api.getMonitorStatus();
	});

	let monitorLabel: string;
	$: monitorLabel = monitorStatus ? "Monitoring..." : "Start monitoring";
</script>

<div class="actions">
	<Filters />
	<button class="ji-button" on:click|preventDefault={monitor}>
		{monitorLabel}
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
