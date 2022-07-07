<script type="ts">
	import Logo from "./Dashboard/Logo.svelte";

	import LogList from "@src/Dashboard/Log/List.svelte";
	import LogActions from "@src/Dashboard/Log/Actions.svelte";
	import Form from "@src/Dashboard/Form.svelte";
	import type { LogEntry } from "@src/utils/Validator";

	let logEntry: LogEntry | false = false;
	function onLogSelect(e) {
		logEntry = e.detail;
	}

	let List;
	let isFormOpen = false;
	let poll: boolean = false;

	let pollTimeout;
	async function infinitePoll() {
		if (!poll && pollTimeout) {
			clearTimeout(pollTimeout);
			return;
		}
		await List.refresh();
		pollTimeout = setTimeout(infinitePoll, 1000);
	}

	async function startInfinitePoll() {
		if( ! List ) {
			return;
		}
		infinitePoll();
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
				on:click|preventDefault={() => (isFormOpen = !isFormOpen)}
			>
				New Request
			</button>
		</div>
	</div>
	<Form bind:isOpen={isFormOpen} bind:logEntry on:submit={List.refresh} />

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
