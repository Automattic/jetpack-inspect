<script type="ts">
	import type { LogEntry as TypeLogEntry } from "@src/utils/Validator";
	import LogEntry from "@src/Dashboard/Log/Entry.svelte";
	import API from "@src/utils/API";

	const api = new API();

	let entries: Promise<TypeLogEntry[]> | TypeLogEntry[] = api.latest();

	export async function refresh() {
		let newEntries = await api.latest();
		entries = newEntries;
	}
</script>

<section>
	{#await entries}
		<div class="log-entry">Loading....</div>
		<div class="log-entry">Loading....</div>
		<div class="log-entry">Loading....</div>
	{:then items}
		{#each items as item (item.id)}
			<div class="log-entry">
				<LogEntry {item} on:select />
			</div>
		{/each}
	{/await}
</section>

<style>
	.log-entry {
		border-bottom: 1px solid rgb(215, 215, 215);
		background-color: #fff;
		min-height: 140px;
		padding: 20px;
	}
</style>
