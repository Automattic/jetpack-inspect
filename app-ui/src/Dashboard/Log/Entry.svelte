<script type="ts">
	import InboundDetails from "@src/Dashboard/Log/InboundDetails.svelte";
	import OutboundDetails from "@src/Dashboard/Log/OutboundDetails.svelte";
	import OutboundErrorDetails from "@src/Dashboard/Log/OutboundErrorDetails.svelte";
	import { sineInOut } from "svelte/easing";
	import LogSummary from "@src/Dashboard/Log/Summary.svelte";

	import type { LogEntry } from "@src/utils/Validator";

	export let item: LogEntry;
	let isOpen = false;

	function fade(_, { duration, delay }: { duration: number; delay: number }) {
		return {
			duration,
			delay,
			css: (t: number) => {
				const lightness = 94 + sineInOut(t) * 6;
				return `background-color: hsl(110deg 21% ${lightness}%);`;
			},
		};
	}

	function getLogType() {
		if (item.outbound_request) {
			return "outbound_request";
		}
		if (item.inbound_rest_request) {
			return "inbound_rest_request";
		}
		if (item.wp_error) {
			return "wp_error";
		}
	}

	type EntryComponent = {
		component:
			| typeof InboundDetails
			| typeof OutboundDetails
			| typeof OutboundErrorDetails;
		props: { details: any };
		icon: "in" | "out" | "bug";
	};

	function getComponent(): EntryComponent | false {
		const type = getLogType();
		switch (type) {
			case "inbound_rest_request":
				return {
					component: InboundDetails,
					props: { details: item.inbound_rest_request },
					icon: "in",
				};
			case "outbound_request":
				return {
					component: OutboundDetails,
					props: { details: item.outbound_request },
					icon: "out",
				};
			case "wp_error":
				return {
					component: OutboundErrorDetails,
					props: { details: item.wp_error },
					icon: "out",
				};
			default:
				return false;
		}
	}

	let component = getComponent();
	const icon = component ? component.icon : "bug";
</script>

<div class="log-entry" in:fade|local={{ delay: 1000, duration: 560 }}>
	<LogSummary {item} {icon} bind:isOpen on:select on:submit on:retry />
	{#if isOpen && component}
		<svelte:component this={component.component} {...component.props} />
	{/if}
</div>

<style>
	.log-entry {
		border-bottom: 1px solid rgb(215, 215, 215);
		min-height: 78px;
		background-color: #fff;
	}
</style>
