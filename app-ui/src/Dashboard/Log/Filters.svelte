<script type="ts">
	import REST_API from "@src/utils/REST_API";

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

	$:filter && updateFilter();
</script>

<input placeholder="*jetpack.com*" type="text" bind:value={filter} />
