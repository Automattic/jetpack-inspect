<script type="ts">
	import type { WP_Request, Response } from "./Validator";
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();
	export let date: string;
	export let url: string;
	export let duration: number;
	export let request: WP_Request;
	export let response: Response;
	export let isOpen = false;

	const isError = !response || response.response.code !== 200;

	function selectRequest() {
		dispatch("select", { url, request });
	}
</script>

<div class="summary" class:error={isError}>
	<div class="header">
		<div class="date">{date}</div>
		<div class="url">
			<strong>{request.method}</strong> ({duration}ms)
			{url}
		</div>
	</div>

	<div class="row">
		<button class="button button-secondary" on:click={selectRequest}
			>Use this request</button
		>
		<button
			class="button button-secondary"
			on:click|preventDefault={() => (isOpen = !isOpen)}
		>
			{isOpen ? "Hide" : "Show"}
		</button>
	</div>
</div>

<style lang="scss">
	.summary {
		display: grid;
		width: 100%;
	}

	.date {
		font-size: 0.8em;
		color: #999;
		margin-right: 1em;
	}
	.header {
		display: grid;
		align-items: center;
	}
</style>
