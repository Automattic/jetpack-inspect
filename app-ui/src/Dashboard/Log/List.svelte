<script type="ts">
	import LogEntry from "@src/Dashboard/Log/Entry.svelte";
	import REST_API from "@src/utils/REST_API";
</script>

<section>
	{#await new REST_API().latest()}
		Loading....
	{:then items}
		{#each items as item (item.id)}
			<LogEntry {item} on:select />
		{/each}
	{/await}
</section>
