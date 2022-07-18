<script type="ts">
	import type { Monitor } from "@src/global";

	import API from "@src/utils/API";
	import { onMount } from "svelte";

	export let name: Monitor;
	const api = new API();
	let filter = "";

	let timeout: ReturnType<typeof setTimeout>;
	function updateFilter(value: string) {
		if (timeout) {
			clearTimeout(timeout);
		}

		timeout = setTimeout(() => {
			api.updateFilter(name, value);
		}, 1000);
	}

	let mounted = false;
	onMount(async () => {
		const existingValue = await api.getFilter(name);

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
