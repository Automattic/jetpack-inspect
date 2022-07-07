<script type="ts">
	export let data;
	function stringify(data) {
		if (!data) {
			return;
		}
		return JSON.stringify(data, null, 4);
	}
</script>

<div>
	<pre>{stringify(data)}</pre>
</div>

<style>
	pre {
		background-color: #f3f3f3;
		padding: 20px;
		overflow: auto;
		max-width: 75vw;
	}
</style>
