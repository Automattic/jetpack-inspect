<script type="ts">
	import Toggle from "@src/Components/Toggle.svelte";
	import API from "@src/utils/API";
	import type { Monitor } from "@src/global";
	import { onMount, tick } from "svelte";
	import Filters from "./Filters.svelte";

	export let label: string;
	export let isActive: boolean = false;
	export let name: Monitor;

	const api = new API();

	async function toggleMonitoring() {
		const request = await api.toggleMonitorStatus(name);
		isActive = request;
	}

	onMount(async () => {
		const status = await api.getMonitorStatus(name);
		isActive = status;
	});
</script>

<div class="monitor-control">
	<strong>{label}</strong>
	<div class="inline">
		<Toggle id={label} on:click={toggleMonitoring} bind:checked={isActive} />
		<Filters {name} />
	</div>
</div>

<style>
	strong {
		flex: 2;
		font-size: .85rem;
	}
	.inline {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 10px;
		flex: 5;
	}
	.monitor-control {
		display: flex;
		align-items: center;
		justify-content: space-around;
		gap: 10px;
	}
</style>
