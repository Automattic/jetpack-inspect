<script lang="ts">
	import Filters from './Filters.svelte';
	import { onMount } from "svelte";

	export let captureStatus = false;
	import REST_API from "@src/utils/API";
	let message;

	const api = new REST_API();

	async function capture() {
		captureStatus = !captureStatus;
		const request = await api.toggleCaptureStatus();

		captureStatus = request
	}

	async function clear() {
		message = "";
		if (await api.clear()) {
			message = "Cleared all data!";
		}
	}


	onMount(async () => {
		captureStatus = await api.getCaptureStatus();
	});

	let captureButtonLabel;
	$: captureButtonLabel = captureStatus ? "Capturing..." : "Capture";
</script>

<div class="actions">
	<Filters />
	<button class="ji-button" on:click|preventDefault={capture}>
		{captureButtonLabel}
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
