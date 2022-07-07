<script type="ts">
	import type { ZodFormattedError } from "zod";
	import FormError from "./FormError.svelte";
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();
	import storageStore from "@src/utils/localStorageStore";
	import { EntryData, type LogEntry } from "@src/utils/Validator";
	import API from "@src/utils/API";

	export let logEntry: LogEntry | false = false;

	const data = storageStore("jetpack_devtools_form", {
		url: "",
		body: "",
		headers: "",
		method: "POST",
	});

	const api = new API();

	function stringify(obj: any) {
		if (!obj) {
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

	let errors: ZodFormattedError<EntryData>;
	async function submit(formData) {
		const data = EntryData.safeParse(formData);

		if (!data.success && "error" in data) {
			const formatted = data.error.format();
			errors = formatted;
			return;
		}

		await api.submit(formData);
		dispatch("submit");
	}
</script>

<form on:submit|preventDefault={() => submit($data)}>
	<fieldset>
		<label>Method</label>
		<div>
			<FormError error={errors?.method} />
			<select bind:value={$data.method}>
				<option value="POST">POST</option>
				<option value="GET">GET</option>
				<option value="PUT">PUT</option>
				<option value="DELETE">DELETE</option>
				<option value="PATCH">PATCH</option>
			</select>
		</div>

		<!-- Text input-->
		<section>
			<label class="control-label" for="apiurl">URL</label>
			<div>
				<FormError error={errors?.url} />
				<input bind:value={$data.url} id="apiurl" name="apiurl" type="text" />
			</div>
		</section>

		<!-- Body -->
		<section>
			<label for="body">Body</label>
			<div>
				<FormError error={errors?.body} />
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
				<FormError error={errors?.headers} />
				<textarea
					bind:value={$data.headers}
					class="form-control"
					id="body"
					name="body"
				/>
			</div>
		</section>

		<button class="button button-primary">Send</button>
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
