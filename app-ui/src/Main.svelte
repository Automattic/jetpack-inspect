<script type="ts">
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
</script>

<main>
	<Form bind:logEntry on:submit={List.refresh} />

	<div class="logs">
		<h2>Actions</h2>
		<hr />
		<LogActions />

		<h2>Logs</h2>
		<hr />
		<LogList bind:this={List} on:select={onLogSelect} />
	</div>

</main>

<style>
	main {
		display: grid;
		gap: 20px;
		margin-left: -20px;
	}

	.logs {
		padding: 40px;
	}
</style>
