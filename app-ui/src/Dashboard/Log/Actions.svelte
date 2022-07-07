<script lang="ts">
	import Filters from './Filters.svelte';
	import { onMount } from "svelte";

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

	let captureStatus;
	onMount(async () => {
		captureStatus = await api.getCaptureStatus();
	});

	let captureButtonLabel;
	$: captureButtonLabel = captureStatus ? "Capturing..." : "Capture";
</script>

<div class="actions">
	<Filters />
	<button class="button button-primary" on:click|preventDefault={capture}>
		{captureButtonLabel}
	</button>

	<button id="clear" class="pclear button button-primary" on:click|preventDefault={clear}>
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
