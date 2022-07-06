<script type="ts">
	import type { LogEntry } from "@src/utils/Validator";
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();

	export let item: LogEntry;
	export let isOpen = false;

	const { date, url, duration, request } = item;

	function selectRequest() {
		dispatch("select", { url, request });
	}

	function toggleOpen() {
		isOpen = !isOpen;
	}
</script>

<div class="summary">
	<div class="header">
		<div class="date">{request.method} {duration}ms - {date}</div>
		<div class="url"><a href="#" on:click={toggleOpen}>{url}</a></div>
	</div>

	<div class="row">
		<button class="button button-secondary" on:click={selectRequest}
			>Use as template</button
		>
		<button
			class="button button-secondary"
			on:click|preventDefault={toggleOpen}
		>
			{isOpen ? "Hide" : "Show"}
		</button>
	</div>
</div>

<style lang="scss">
	.summary {
		display: grid;
		gap: 10px;
		width: 100%;
		background-color: #fff;
		padding: 20px;
	}

	.duration {
		grid-area: duration;
	}

	.url {
		grid-area: url;
		a {
			text-decoration: none;

			&:focus,
			&:active {
				outline: 0;
				box-shadow: none;
			}
		}
	}

	.date {
		font-size: 0.8em;
		color: #999;
	}
</style>
