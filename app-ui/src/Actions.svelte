<script lang="ts">
	function watch() {
		console.log("watch");
	}

	function clear() {
		console.log("clear");
	}
</script>

<div class="actions">
	<h2>Actions</h2>
	<hr />
	<button class="button button-primary" on:click|preventDefault={watch}>
		Watch
	</button>

	<button class="button button-primary" on:click|preventDefault={clear}>
		Clear
	</button>
</div>
