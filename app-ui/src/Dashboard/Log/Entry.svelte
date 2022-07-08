<script type="ts">
	import { sineInOut } from "svelte/easing";
	import LogSummary from "@src/Dashboard/Log/Summary.svelte";
	import LogDetails from "@src/Dashboard/Log/Details.svelte";
	import type { LogEntry } from "@src/utils/Validator";

	export let item: LogEntry;
	let isOpen = false;

	function fade(node, { duration, delay }) {
		return {
			duration,
			delay,
			css: (t) => {
				const lightness = 94 + sineInOut(t) * 6;
				return `background-color: hsl(110deg 21% ${lightness}%);`;
			},
		};
	}
</script>

<div class="log-entry" in:fade|local={{ delay: 1000, duration: 560 }}>
	<LogSummary {item} bind:isOpen on:select on:retry />
	{#if isOpen}
		<LogDetails {item} />
	{/if}
</div>

<style>
	.log-entry {
		border-bottom: 1px solid rgb(215, 215, 215);
		min-height: 78px;
		padding: 20px;
		background-color: #fff;
	}
</style>
