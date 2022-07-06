<script lang="ts">
	import Filters from './Filters.svelte';
	import { onMount } from "svelte";

	import API from "@src/utils/API";
	let message = "";

	const api = new API();

	async function capture() {
		const request = await api.toggleCaptureStatus();

		captureStatus = request
		message = "Capture status changed";

	}

	async function clear() {
		if (await api.clear()) {
			message = "Cleared all data!";
		}
	}

	let captureStatus;
	onMount(async () => {
		captureStatus = await api.getCaptureStatus();
	});
</script>

<div class="actions">
	Filters: <Filters />
	{#if undefined !== captureStatus}
		Is Capturing: {captureStatus ? "Yes" : "No"}
	{/if}
	{#if message}
		<div class="message">
			<strong> {message} </strong>
		</div>
	{/if}
	<button class="button button-primary" on:click|preventDefault={capture}>
		Toggle Capture
	</button>

	<button class="button button-primary" on:click|preventDefault={clear}>
		Clear
	</button>
</div>

<style>
	.message {
		margin-top: 1em;
		margin-bottom: 1em;
		padding: 1em;
		border: 1px solid #ccc;
		background-color: #fafafa;
	}
</style>
