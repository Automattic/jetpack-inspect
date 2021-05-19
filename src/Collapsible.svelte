<script>
	export let isOpen = false;
</script>
<div>
	<slot name="summary"></slot>
	<button on:click|preventDefault={() => isOpen = !isOpen}>
		{isOpen ? 'Close' : 'Open'}
	</button>
	{#if isOpen}
		<slot></slot>
	{/if}
</div>

<style>
	div {
		background-color: #fff;
		border-radius: 6px;
		padding: 2rem;
		margin-bottom: 2rem;
	}
</style>
