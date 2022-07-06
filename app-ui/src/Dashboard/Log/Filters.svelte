<script type="ts">
	import REST_API from "@src/utils/REST_API";
	import { onMount } from "svelte";

	const api = new REST_API();
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
