<script>
	import Collapsible from './Collapsible.svelte';

	export let items;


	setTimeout(() => {
		console.log(items);
	}, 100)

	function isError(item) {
		return !item.result
				|| !item.result.response
				|| !item.result.response.response
				|| item.result.response.response.code !== 200
	}

	function stringify(data) {
		return JSON.stringify(data, null, 4);
	}
</script>

<section>
	{#each items as item, key}
		<Collapsible class="log-item" isOpen={key === 0}>
			<p slot="summary" class="summary" class:error={isError(item)}>
				<b>
					<time>{item.time}</time>
				</b>
				<br>
				{item.request.method} {item.request.url}
			</p>

			<div>
				{#if isError(item)}
					<h3>API Error:</h3>
					<pre>{stringify(item.result.response)}</pre>
				{:else}
					<h3>API Response:</h3>
					<pre>{stringify(item.result.body)}</pre>
				{/if}

				<h3>Headers</h3>
				<pre>{stringify(item.result.headers)}</pre>

				<h3>Cookies</h3>
				<pre>{stringify(item.result.cookies)}</pre>
			</div>

			<h2>Request Details</h2>
			<div class="request">
				<h3>Request Data</h3>
				<pre>
						{stringify(item.request)}
					</pre>
				<h3>API Request Call</h3>
				<pre>
						{stringify(item.result.request)}
					</pre>
			</div>

		</Collapsible>
	{/each}
</section>


<style>
	pre {
		background-color: #f3f3f3;
		padding: 1rem;
		max-width: 50vw;
		overflow-x: scroll;
	}

	.summary {
		padding: .5rem 1rem;
		border-left: 4px solid green;
	}

	.error {
		border-color: #FF4136;

	}

	h2 {
		border-bottom: 1px solid #eaeaea;
		padding-bottom: 0.6em;
		margin-top: 10vh;
		margin-bottom: 3vh;
		font-size: 2rem;
	}
</style>
