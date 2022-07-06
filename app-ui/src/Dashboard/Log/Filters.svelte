<script type="ts">
	import API from "@src/utils/API";
	import { onMount } from "svelte";

	const api = new API();
	let filter = "";

	let timeout;
	function updateFilter() {
		if (timeout) {
			clearTimeout(timeout);
		}

		timeout = setTimeout(() => {
			api.updateFilter(filter);
		}, 1000);
	}

	let mounted = false;
	onMount(async () => {
		const existingValue = await api.getFilter();

		if (typeof existingValue === "string" && existingValue !== filter) {
			filter = existingValue;
		}
		mounted = true;
	});

	$: mounted && filter && updateFilter();
</script>

<input placeholder="*jetpack.com*" type="text" bind:value={filter} />
