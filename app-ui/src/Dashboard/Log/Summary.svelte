<script type="ts">
	import type { WP_Request, Response } from "@src/utils/Validator";
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();
	export let date: string;
	export let url: string;
	export let duration: number;
	export let request: WP_Request;
	export let response: Response;
	export let isOpen = false;

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
