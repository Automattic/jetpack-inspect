<script type="ts">
	import { maybeStringify } from "@src/utils/maybeStringify";
	import type { JSONSchema } from "@src/utils/Validator";

	export let data: JSONSchema | string;
</script>

<div>
	<pre>{maybeStringify(data)}</pre>
</div>

<style>
	pre {
		background-color: #f3f3f3;
		padding: 20px;
		overflow: auto;
	}
</style>
