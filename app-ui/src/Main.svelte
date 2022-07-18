<script type="ts">
	import { createPersistentStore } from "@src/utils/peristentStore";
	import Logo from "./Dashboard/Logo.svelte";

	import LogList from "@src/Dashboard/Log/List.svelte";
	import LogActions from "@src/Dashboard/Log/Actions.svelte";
	import Form from "@src/Dashboard/Form.svelte";
	import type { LogEntry } from "@src/utils/Validator";

	let logEntry: LogEntry | false = false;
	function onLogSelect(e) {
		logEntry = e.detail;
	}

	let isFormOpen = createPersistentStore("jetpack_devtools_form_open", false);
	let refreshList = true;
	let isMonitoring = false;
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
		<Form bind:logEntry on:submit={() => (refreshList = true)} />
	{/if}

	<div class="logs">
		<h4>Monitor Requests</h4>
		<div class="info">
			Filters allow capturing only specific requests. Wildcards are supported,
			for example <code>https://jetpack.com/*</code>
		</div>
		<LogActions bind:isMonitoring />

		<LogList bind:refresh={refreshList} isPolling={isMonitoring} on:select={onLogSelect} />
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
