<script type="ts">
	import storageStore from "@src/utils/localStorageStore";
	import Logo from "./Dashboard/Logo.svelte";

	import LogList from "@src/Dashboard/Log/List.svelte";
	import LogActions from "@src/Dashboard/Log/Actions.svelte";
	import Form from "@src/Dashboard/Form.svelte";
	import type { LogEntry } from "@src/utils/Validator";
	import type { SvelteComponentTyped } from "svelte";

	let logEntry: LogEntry | false = false;
	function onLogSelect(e) {
		logEntry = e.detail;
	}

	let List: SvelteComponentTyped<LogList> | any;
	let isFormOpen = storageStore("jetpack_devtools_form_open", false);
	let poll: boolean = false;

	/**
	 * Polling
	 */
	let pollTimeout: ReturnType<typeof setTimeout>;
	async function infinitePoll() {
		if (!poll && pollTimeout) {
			clearTimeout(pollTimeout);
			return;
		}
		await refresh();
		pollTimeout = setTimeout(infinitePoll, 1000);
	}

	async function startInfinitePoll() {
		infinitePoll();
	}

	function refresh() {
		if (!List || !List.refresh) {
			return;
		}
		List.refresh();
	}

	$: if (poll) {
		startInfinitePoll();
	}
</script>

<main>
	<div class="top">
		<Logo />
		<div class="controls">
			<button
				class="ji-button"
				on:click|preventDefault={() => ($isFormOpen = !$isFormOpen)}
			>
				New Request
			</button>
		</div>
	</div>
	{#if $isFormOpen}
		<Form bind:logEntry on:submit={refresh} />
	{/if}

	<div class="logs">
		<h4>Capture Requests</h4>
		<div class="info">
			Filters allow capturing only specific requests. Wildcards are supported,
			for example <code>https://jetpack.com/*</code>
		</div>
		<LogActions bind:captureStatus={poll} />

		<LogList bind:this={List} on:select={onLogSelect} />
	</div>
</main>

<style>
	.top {
		padding: 30px 40px;
		background-color: var(--gray_0);
	}

	.controls {
		display: flex;
	}

	main {
		margin-left: -20px;
	}

	.logs {
		padding: 10px 40px;
	}

	h4 {
		margin-bottom: 0;
	}

	.info {
		font-size: 0.8rem;
	}
</style>
