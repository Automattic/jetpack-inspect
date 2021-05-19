<script>
	import Log from "./Log.svelte";
	import storageStore from './storageStore.js'

	let isLoading = false;
	let logs = storageStore('jetpack_devtools_logs', []);

	let form = storageStore('jetpack_devtools_form', {
		url: '',
		body: '',
		headers: '',
		method: 'POST',
	});

	function saveToLog(data) {
		try {
			data = JSON.parse(data)
		} catch (e) {
			// do nothing
		}

		$logs = [{
			time: new Date().toLocaleString(),
			request: $form,
			result: data,
		}, ...$logs].slice(0, 20)
	}

	async function performRequest() {
		isLoading = true;
		const result = await fetch('/wp-json/jetpack-devtools/wpcom', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({
				method: $form.method,
				url: $form.url,
				body: $form.body,
			})
		});
		console.log(result)
		let data = '';
		try {
			data = await result.text();
		} catch (e) {
			console.log(e);
		}

		saveToLog(data.message || data)
		isLoading = false
	}
</script>

<main>
	<form class="form-horizontal">
		<fieldset>

			<!-- Form Name -->
			<legend>Jetpack REST API Tester</legend>
			<hr>

			<select bind:value={$form.method}>
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
					<input bind:value={$form.url} id="apiurl" name="apiurl" type="text">
				</div>
			</section>

			<!-- Body -->
			<section>
				<label for="body">Body</label>
				<div>
					<textarea bind:value={$form.body} class="form-control" id="body" name="body"></textarea>
				</div>
			</section>

			<!-- Headers -->
			<section>
				<label for="body">Headers</label>
				<div>
					<textarea bind:value={$form.headers} class="form-control" id="body" name="body"></textarea>
				</div>
			</section>

			<button class="button button-primary" on:click|preventDefault={performRequest}>Run</button>

		</fieldset>
	</form>
	<div>
		{#if isLoading}
			Loading...
		{/if}
		<Log items={$logs}/>
	</div>
</main>

<style>
	main {
		width: 95%;
		max-width: 90vw;
		padding: 3rem;
		display: grid;
		grid-template-columns: 440px 1fr;
		grid-column-gap: 2rem;
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
		padding: .25rem 1rem;
	}

	textarea, input, select {
		width: 100%;
		margin-bottom: .5rem;
	}
</style>
