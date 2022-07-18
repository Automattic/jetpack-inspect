<script type="ts">
	import API from "@src/utils/API";
	import type { Monitor } from "@src/global";
	import { onMount } from "svelte";
	import Filters from "./Filters.svelte";

	export let label: string;
	export let isActive: boolean = false;
	export let name: Monitor;

	const api = new API();

	function getButtonLabel(monitoringActive: boolean) {
		return monitoringActive ? `Monitoring ${label} ...` : `Monitor ${label}`;
	}

	async function toggleMonitoring() {
		isActive = !isActive;
		const request = await api.toggleMonitorStatus(name);
		isActive = request;
	}

	let buttonText: string;
	$: buttonText = getButtonLabel(isActive);

	onMount(async () => {
		isActive = await api.getMonitorStatus(name);
	});
</script>

<Filters {name} />
<button class="ji-button" on:click|preventDefault={toggleMonitoring}>
	{buttonText}
</button>
