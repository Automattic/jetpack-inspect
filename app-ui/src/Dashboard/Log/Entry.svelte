<script type="ts">
	import LogSummary from '@src/Dashboard/Log/Summary.svelte';
	import type { Response, WP_Request } from "@src/utils/Validator";

	export let id: number;
	export let date: string;
	export let url: string;
	export let duration: number;
	export let request: WP_Request;
	export let response: Response;


	let isOpen;

	function stringify(data) {
		return JSON.stringify(data, null, 4);
	}

</script>

<div class="log-entry">
	<LogSummary {date} {url} {duration} {request} {response} bind:isOpen on:select />

	{#if isOpen}
		<div>
			{#if !response || response.response.code !== 200}
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
	{/if}
</div>

<style>
	.log-entry {
		border-bottom: 1px solid rgb(215, 215, 215);
	}

	pre {
		background-color: #f3f3f3;
		padding: 1rem;
		max-width: 50vw;
		overflow-x: scroll;
	}

	h2 {
		border-bottom: 1px solid #eaeaea;
		padding-bottom: 0.6em;
		margin-top: 10vh;
		margin-bottom: 3vh;
		font-size: 2rem;
	}
</style>
