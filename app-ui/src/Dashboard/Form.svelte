<script type="ts">
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();
	import storageStore from "@src/utils/localStorageStore";
	import type { LogEntry } from "@src/utils/Validator";

	export let logEntry: LogEntry | false = false;

	const data = storageStore("jetpack_devtools_form", {
		url: "",
		body: "",
		headers: "",
		method: "POST",
	});

	function stringify(obj: any) {
		if( ! obj ) {
			return "";
		}

		return JSON.stringify(obj, null, 2);
	}

	$: if (logEntry) {
		$data = {
			url: logEntry.url,
			method: logEntry.request.method,
			body: stringify(logEntry.request.body),
			headers: stringify(logEntry.request.headers),
		};
	}

	async function performRequest(method, url, body, headers) {
		const result = await fetch("/wp-json/jetpack-inspect/submit", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				// type: "simple",
				headers,
				method,
				url,
				body,
			}),
		});

		let data = "";
		try {
			data = await result.text();
		} catch (e) {
			console.log(e);
		}
	}

	async function run() {
		await performRequest($data.method, $data.url, $data.body, $data.headers);
		dispatch("submit");
	}
</script>

<form on:submit|preventDefault={run}>
	<fieldset>
		<!-- Form Name -->
		<legend>Jetpack REST API Tester</legend>
		<hr />

		<select bind:value={$data.method}>
			<option value="POST" selected>POST</option>
			<option value="GET">GET</option>
			<option value="PUT">PUT</option>
			<option value="DELETE">DELETE</option>
			<option value="PATCH">PATCH</option>
		</select>

		<!-- Text input-->
		<section>
			<label class="control-label" for="apiurl">URL</label>
			<div>
				<input bind:value={$data.url} id="apiurl" name="apiurl" type="text" />
			</div>
		</section>

		<!-- Body -->
		<section>
			<label for="body">Body</label>
			<div>
				<textarea
					bind:value={$data.body}
					class="form-control"
					id="body"
					name="body"
				/>
			</div>
		</section>

		<!-- Headers -->
		<section>
			<label for="body">Headers</label>
			<div>
				<textarea
					bind:value={$data.headers}
					class="form-control"
					id="body"
					name="body"
				/>
			</div>
		</section>

		<button class="button button-primary">Run</button>
	</fieldset>
</form>

<style type="scss">
	form {
		padding: 20px;
		background-color: #fff;
	}
	fieldset section {
		margin-bottom: 2rem;
	}

	legend {
		font-weight: 600;
	}

	textarea {
		padding: 1rem;
		min-height: 100px;
	}

	input {
		padding: 0.25rem 1rem;
	}

	textarea,
	input,
	select {
		width: 100%;
		margin-bottom: 0.5rem;
	}
</style>
