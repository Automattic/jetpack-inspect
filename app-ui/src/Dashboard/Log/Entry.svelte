<script type="ts">
	import PrettyJSON from "@src/Dashboard/Log/PrettyJSON.svelte";
	import LogSummary from "@src/Dashboard/Log/Summary.svelte";
	import type { LogEntry } from "@src/utils/Validator";

	export let item: LogEntry;
	const { args, response } = item;

	let isOpen;
	let showRaw = false;
</script>

<LogSummary {item} bind:isOpen on:select />

{#if isOpen}
	<div>
		<h2>Response</h2>
		{#if "body" in response}
			<PrettyJSON data={JSON.parse(response.body)} />
		{:else}
			<div class="error">Whoops! An error!</div>
			<PrettyJSON data={response} />
		{/if}

		{#if "headers" in response}
			<h3>Headers</h3>
			<PrettyJSON data={response.headers} />
		{/if}

		{#if "cookies" in response}}
			<h3>Cookies</h3>
			<PrettyJSON data={response.cookies} />
		{/if}
	</div>

	<button class="button button-secondary" on:click={() => (showRaw = !showRaw)}>
		{showRaw ? "Hide" : "Show"} raw data
	</button>

	{#if showRaw}
		<div class="raw">
			<h2>Raw</h2>
			<div class="request">
				<h3>Response Data</h3>
				<PrettyJSON data={response} />
				<h3>Args</h3>
				<div class="note">
					These are the arguments passed to <code>wp_remote_*</code> function.
				</div>
				<PrettyJSON data={args} />
			</div>
		</div>
	{/if}
{/if}

<style>
	.raw {
		display: block;
		width: 100%;
		padding: 1rem;
	}


	h2 {
		border-bottom: 1px solid #eaeaea;
		padding-bottom: 0.6em;
		margin-top: 10vh;
		margin-bottom: 3vh;
		font-size: 2rem;
	}
</style>
