<script type="ts">
	import type { Response, WP_Request } from "./Validator";
	import Collapsible from "./Collapsible.svelte";
	import { createEventDispatcher } from "svelte";

	export let id: number;
	export let date: string;
	export let url: string;
	export let duration: number;
	export let request: WP_Request;
	export let response: Response;

	const isError = !response || response.response.code !== 200;

	function stringify(data) {
		return JSON.stringify(data, null, 4);
	}

	const dispatch = createEventDispatcher();

	function selectRequest() {
		dispatch("select", { url, request });
	}
</script>

<Collapsible>
	<p slot="summary" class="summary" class:error={isError}>
		<b>{date} </b> ({duration}ms)
		<br />
		{request.method}
		{url}
		<button on:click={selectRequest}>Use this request</button>
	</p>

	<div>
		{#if isError}
			<h3>API Error:</h3>
			<pre>{stringify(response.response)}</pre>
		{:else}
			<h3>API Response:</h3>
			<pre>{stringify(response.body)}</pre>
		{/if}

		<h3>Headers</h3>
		<pre>{stringify(response.headers)}</pre>

		<h3>Cookies</h3>
		<pre>{stringify(response.cookies)}</pre>
	</div>

	<h2>Request Details</h2>
	<div class="request">
		<h3>Response Data</h3>
		<pre>
				{stringify(response)}
			</pre>
		<h3>API Request Call</h3>
		<pre>
				{stringify(request)}
		</pre>
	</div>
</Collapsible>

<style>
	pre {
		background-color: #f3f3f3;
		padding: 1rem;
		max-width: 50vw;
		overflow-x: scroll;
	}

	.summary {
		padding: 0.5rem 1rem;
		border-left: 4px solid green;
	}

	.error {
		border-color: #ff4136;
	}

	h2 {
		border-bottom: 1px solid #eaeaea;
		padding-bottom: 0.6em;
		margin-top: 10vh;
		margin-bottom: 3vh;
		font-size: 2rem;
	}
</style>
