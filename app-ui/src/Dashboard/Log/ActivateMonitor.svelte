<script type="ts">
	import API from "@src/utils/API";
	import type { Monitor } from "@src/global";
	import { onMount } from "svelte";
	import Filters from "./Filters.svelte";

	export let label: string;
	export let status: boolean = false;
	export let name: Monitor;

	const api = new API();

	function getButtonLabel(monitoringActive: boolean) {
		return monitoringActive ? `Monitoring ${label} ...` : `Monitor ${label}`;
	}

	async function toggleMonitoring() {
		status = !status;
		const request = await api.toggleMonitorStatus(name);
		status = request;
	}

	let buttonText: string;
	$: buttonText = getButtonLabel(status);

	onMount(async () => {
		status = await api.getMonitorStatus(name);
	});
</script>

<Filters {name} />
<button class="ji-button" on:click|preventDefault={toggleMonitoring}>
	{buttonText}
</button>
