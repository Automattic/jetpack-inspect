<script type="ts">
	import { fade } from "svelte/transition";

	import LogList from "@src/Dashboard/Log/List.svelte";
	import LogActions from "@src/Dashboard/Log/Actions.svelte";
	import Form from "@src/Dashboard/Form.svelte";
	import type { LogEntry } from "@src/utils/Validator";

	let isLoading = false;

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
	:global(#jetpack-inspect *) {
		box-sizing: border-box;
	}
	main {
		display: grid;
		gap: 20px;
		padding: 35px 30px 20px 10px;
	}
</style>
