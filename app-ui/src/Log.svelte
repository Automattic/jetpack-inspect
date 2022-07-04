<script type="ts">
	import LogEntry from "./LogEntry.svelte";

	import REST_API from "./REST_API";
</script>

<section>
	{#await new REST_API().latest()}
		Loading....
	{:then items}
		{#each items as item (item.id)}
			<LogEntry
				id={item.id}
				url={item.data.url}
				date={item.date}
				request={item.data.request}
				response={item.data.response}
				duration={item.data.duration}
			/>
		{/each}
	{/await}
</section>
