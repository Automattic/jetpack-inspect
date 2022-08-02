<script type="ts">
	import type { Monitor } from "@src/global";

	import { API } from "@src/utils/Async_Options";
	import { onMount } from "svelte";

	export let name: Monitor;
	let filter = "";

	let timeout: ReturnType<typeof setTimeout>;
	function updateFilter(value: string) {
		if (timeout) {
			clearTimeout(timeout);
		}

		timeout = setTimeout(() => {
			API.updateFilter(name, value);
		}, 1000);
	}

	let mounted = false;
	onMount(async () => {
		const existingValue = await API.getFilter(name);

		if (typeof existingValue === "string" && existingValue !== filter) {
			filter = existingValue;
		}
		mounted = true;
	});

	$: mounted && updateFilter(filter);
</script>

<input
	placeholder="for example: http://jetpack*"
	type="text"
	bind:value={filter}
/>
<style>
	input {
		flex: 1;
	}
</style>
