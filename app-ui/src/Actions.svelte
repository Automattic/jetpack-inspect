<script lang="ts">
	import REST_API from "./REST_API";
	let message = "";
	function watch() {
		console.log("watch");
	}

	async function clear() {
		const api = new REST_API();

		if (await api.clear()) {
			message = "Cleared all data!";
		}
	}
</script>

<div class="actions">
	{#if message}
		<div class="message">
			<strong> {message} </strong>
		</div>
	{/if}
	<h2>Actions</h2>
	<hr />
	<button class="button button-primary" on:click|preventDefault={watch}>
		Watch
	</button>

	<button class="button button-primary" on:click|preventDefault={clear}>
		Clear
	</button>
</div>

<style>
	.message {
		margin-top: 1em;
		margin-bottom: 1em;
		padding: 1em;
		border: 1px solid #ccc;
		background-color: #fafafa;
	}
</style>
