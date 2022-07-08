<script type="ts">
	import API from "@src/utils/API";
	import { onMount } from "svelte";

	const api = new API();
	let filter = "";

	let timeout: ReturnType<typeof setTimeout>;
	function updateFilter(value: string) {
		if (timeout) {
			clearTimeout(timeout);
		}

		timeout = setTimeout(() => {
			api.updateFilter(value);
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

	$: mounted && updateFilter(filter);
</script>

<input placeholder="*" type="text" bind:value={filter} />
