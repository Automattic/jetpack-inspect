<script type="ts">
	import Logo from './Dashboard/Logo.svelte';
	import { fade } from "svelte/transition";

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
</script>

<main>
	<div class="top">
		<Logo />
		<div class="controls">
			<button
				class="button button-primary"
				on:click|preventDefault={() => (isFormOpen = !isFormOpen)}
			>
				New Request
			</button>
			<LogActions />
		</div>
	</div>
	<Form bind:isOpen={isFormOpen} bind:logEntry on:submit={List.refresh} />

	<div class="logs">
		<h4>Captured Requests</h4>
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
</style>
