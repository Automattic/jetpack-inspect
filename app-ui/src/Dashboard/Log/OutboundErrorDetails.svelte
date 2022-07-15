<script type="ts">
	import type { OutboundRequestError } from "@src/utils/Validator";
	import PrettyJson from "./PrettyJSON.svelte";

	export let details: OutboundRequestError;
</script>

<div>
	{#each Object.entries(details.error.errors) as [error, name]}
		<h4>{name}</h4>
		<p>{error}</p>
	{/each}
	{#if details.error.error_data}
		<PrettyJson data={details.error.error_data} />
	{/if}
</div>
