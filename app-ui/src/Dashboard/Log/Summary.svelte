<script type="ts">
	import type { LogEntry } from "@src/utils/Validator";
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();

	export let item: LogEntry;
	export let isOpen = false;

	const { date, url, duration, args } = item;

	function selectRequest() {
		dispatch("select", item);
	}

	function toggleOpen() {
		isOpen = !isOpen;
	}

	const isError = 'errors' in item.response || item.response?.response?.code >= 400;
</script>

<div class="summary">
	<div class="response-indicator">
		<div class="bubble" class:red={isError} class:green={!isError} />
	</div>

	<div class="header" on:click={toggleOpen}>
		<div class="date">{args.method} {duration}ms - {date}</div>
		<div class="url">{url}</div>
	</div>

	<div class="actions">
		<button class="button button-secondary" on:click={selectRequest}
			>Use as template</button
		>
		<button
			class="button button-secondary"
			on:click|preventDefault={toggleOpen}
		>
			{isOpen ? "Hide" : "View"}
		</button>
	</div>
</div>

<style lang="scss">
	.response-indicator {
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 20px;
	}
	.bubble {
		width: 6px;
		height: 6px;
		border-radius: 50%;
		background-color: var(--gray_30);

		&.red {
			background-color: var(--color_warning);
		}
		&.green {
			background-color: var(--jetpack-green);
		}
	}
	.summary {
		width: 100%;
		display: flex;
		justify-content: space-between;
	}

	.header {
		cursor: pointer;
		margin-right: auto;
	}

	.url {
		font-weight: 500;
		-webkit-font-smoothing: antialiased;
		color: var(--gray_80);
	}

	.date {
		font-size: 0.8em;
		color: #999;
	}
</style>
