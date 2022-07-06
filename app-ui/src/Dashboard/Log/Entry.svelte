<script type="ts">
	import LogSummary from "@src/Dashboard/Log/Summary.svelte";
	import type { LogEntry } from "@src/utils/Validator";

	export let item: LogEntry;
	const { request, response } = item;

	let isOpen;

	function stringify(data) {
		return JSON.stringify(data, null, 4);
	}
</script>


	<LogSummary {item} bind:isOpen on:select />

	{#if isOpen}
		<div>
			{#if "body" in response && response.response === 200}
				<h3>API Response:</h3>
				<pre>{stringify(response.body)}</pre>
			{:else}
				<h3>API Error:</h3>
				<pre>{stringify(response)}</pre>
			{/if}

			{#if "headers" in response}
				<h3>Headers</h3>
				<pre>{stringify(response.headers)}</pre>
			{/if}

			{#if "cookies" in response}}
				<h3>Cookies</h3>
				<pre>{stringify(response.cookies)}</pre>
			{/if}
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

<style>

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
