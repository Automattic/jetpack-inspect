<script type="ts">
	import Form from "@src/Dashboard/Form.svelte";
	import API from "@src/utils/API";

	import type { LogEntry } from "@src/utils/Validator";
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();

	export let item: LogEntry;
	export let isOpen = false;

	const { date, url } = item;

	function toggleOpen() {
		isOpen = !isOpen;
	}

	async function retryRequest() {
		if (!item.outbound_request) {
			return;
		}
		const data = item.outbound_request;
		const api = new API();
		await api.sendRequest({
			url: item.url,
			method: data.args.method,
			body: data.args.body,
			headers: data.args.headers,
			transport: "wp",
		});
		dispatch("retry", item);
	}

	let edit = false;
	let responseCode = item.outbound_request?.response.code || "";
	const isError = "wp_error" in item;
</script>

<div class="summary">
	<div class="response-indicator">
		<div class="bubble" class:red={isError} class:green={!isError} />
	</div>

	<div class="header" on:click={toggleOpen}>
		<div class="date">
			{responseCode}
			{#if item.outbound_request}
				{item.outbound_request.args.method} {item.outbound_request.duration}ms
			{/if}

			- {date}
		</div>
		<div class="url">{url}</div>
	</div>

	<div class="actions">
		{#if item.outbound_request}
			<button class="ji-button--altii" on:click={retryRequest}>Retry</button>

			<button class="ji-button--altii" on:click={() => (edit = !edit)}
				>Edit</button
			>
		{/if}
		<button class="ji-button--alt" on:click|preventDefault={toggleOpen}>
			{isOpen ? "Hide" : "View"}
		</button>
	</div>
</div>

{#if edit}
	<Form logEntry={item} on:submit={() => (edit = false)} on:submit />
{/if}

<style lang="scss">
	.response-indicator {
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 20px;
	}
	.bubble {
		width: 5px;
		height: 5px;
		border-radius: 3px;
		background-color: var(--gray_30);

		&.red {
			background-color: hsl(28deg 94% 70%);
			box-shadow: 0 0 1px 1px hsl(28deg 94% 55%), 0 0 3px 3px hsl(28deg 98% 94%);
		}
		&.green {
			background-color: hsl(121 93% 36%);
			box-shadow: 0 0 0px 1px hsl(121 77% 31%), 0 0 3px 3px hsl(121 70% 80%);
		}
	}
	.actions {
		min-width: 300px;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 5px;
	}
	.summary {
		width: 100%;
		padding: 20px;
		gap: 10px;
		display: flex;
		justify-content: space-between;
	}

	.header {
		cursor: pointer;
		margin-right: auto;
	}

	.url {
		font-weight: 500;
		-webkit-font-smoothing: antialiased;
		word-wrap: break-word;
		word-break: break-all;
		color: var(--gray_80);
	}

	.date {
		font-size: 0.8em;
		color: #999;
	}
</style>
