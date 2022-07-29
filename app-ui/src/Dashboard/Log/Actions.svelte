<script lang="ts">
	import { createEventDispatcher, onMount } from "svelte";
	import Toggle from "@src/Components/Toggle.svelte";
	import ActivateMonitor from "./ActivateMonitor.svelte";
	import { slide } from "svelte/transition";
	import { cubicOut } from "svelte/easing";

	const dispatch = createEventDispatcher();

	export let isMonitoring = false;
	import REST_API from "@src/utils/API";
	import { monitorStatus } from "@src/utils/Async_Options";

	const api = new REST_API();

	async function clear() {
		if (await api.clear()) {
			dispatch("clear");
		}
	}


	let monitorInbound = true;
	let monitorOutbound = true;
	let expanded = false;

	$: console.log("Status is", $monitorStatus)
</script>

<div class="actions">
	<div class="advanced">
		<div class="toggle-monitor">
			<label for="monitor">
				<Toggle
					id="monitor"
					bind:checked={$monitorStatus}
				/>
				<strong>Monitor Requests</strong>
			</label>
		</div>
		<button
			class:active={expanded}
			class="button-effects advanced__button"
			on:click={() => (expanded = !expanded)}
			>{@html expanded ? "&uarr;" : "&darr;"} Monitor Settings</button
		>
		{#if expanded}
			<div
				class="advanced__expanded"
				transition:slide={{ easing: cubicOut, duration: 300 }}
			>
				<div class="info">
					<h4>Filter monitored requests</h4>
					<p>
						By default, incoming and outgoing requests are monitored by default.
						Use the settings below to control which requests are monitored.
					</p>
					<p>
						Requests can be filterd by URL. Partial queries and wildcards are
						supported.
					</p>
				</div>

				<ActivateMonitor
					label="Monitor Incoming"
					name="outbound_request"
					bind:isActive={monitorOutbound}
				/>

				<ActivateMonitor
					label="Monitor Outgoing"
					name="inbound_rest_request"
					bind:isActive={monitorInbound}
				/>
			</div>
		{/if}
	</div>

	<button id="clear" class="ji-button" on:click|preventDefault={clear}>
		Clear All
	</button>
</div>

<style lang="scss">
	.actions {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 10px;
		padding-top: 20px;
		padding-bottom: 20px;
	}

	.toggle-monitor {
		margin-bottom: 10px;
		display: flex;
		flex-direction: column;
		gap: 20px;
		label {
			display: flex;
			gap: 10px;
			align-items: center;
		}
	}

	.advanced {
		position: relative;
	}

	.advanced__expanded {
		display: flex;
		flex-direction: column;
		gap: 10px;
		padding: 20px 30px;
		background-color: var(--primary-white);
		border-radius: 10px;
		width: min(540px, 85vw);
		position: absolute;
		top: calc(100% + 10px);
		left: -10px;
		z-index: 100;
		--shadow-color: 0deg 0% 56%;
		box-shadow: 0px 0.2px 0.2px hsl(var(--shadow-color) / 0.29),
			0px 0.9px 1.1px -0.6px hsl(var(--shadow-color) / 0.36),
			0px 2.1px 2.6px -1.1px hsl(var(--shadow-color) / 0.43),
			0px 4.8px 6px -1.7px hsl(var(--shadow-color) / 0.5);
	}

	.advanced__button {
		display: block;
		background-color: var(--primary-white);
		position: relative;
		padding: 4px 10px;
		border-radius: 20px;
		width: 160px;
		cursor: pointer;
		border: 0;
		transition: all 0.2s ease-in-out;
		&.active {
			background-color: var(--alt_white);
		}
	}

	.info {
		h4 {
			margin-top: 10px;
			margin-bottom: 5px;
		}
		p {
			margin: 0.5em 0;
		}
	}

	#clear {
		margin-left: auto;
	}
</style>
