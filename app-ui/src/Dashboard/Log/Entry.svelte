<script type="ts">
	import { slide } from 'svelte/transition';
	import { cubicInOut } from 'svelte/easing';
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
	<div transition:slide={{easing: cubicInOut, duration: 200}}>
		<h3>Response</h3>
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

		<button class="button button-secondary" on:click={() => (showRaw = !showRaw)}>
			{showRaw ? "Hide" : "Show"} raw data
		</button>


	</div>


	{#if showRaw}
		<div class="raw" transition:slide={{easing: cubicInOut, duration: 200}}>
			<h3>Raw</h3>
			<div class="request">
				<h3>Response Data</h3>
				<PrettyJSON data={response} />
				<h4>Args</h4>
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


	h3 {
		border-bottom: 1px solid #eaeaea;
		padding-bottom: 0.6em;
	}
</style>
