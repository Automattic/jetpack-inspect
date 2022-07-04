export default class REST_API {

	private lastResult: any;

	private async request(
		endpoint: string,
		method = "GET",
		body?: any
	): Promise<any> {

		const result = await fetch(`/wp-json/jetpack-inspect/${endpoint}`, {
			method,
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify(body),
		});

		if( ! result.ok ) {
			console.error("Failed to fetch", result);
			return;
		}

		let data = "";

		try {
			data = JSON.parse(await result.text());
		} catch (e) {
			console.error("Failed to parse JSON", e);
		}

		return data;
	}

	public async latest() {
		return await this.request("latest");
	}

	public async clear() {
		return await this.request("clear", "DELETE");
	}

	public async getCaptureStatus() {
		return await this.request("capture-status");
	}

	public async toggleCaptureStatus() {
		return await this.request("capture-status", "POST");
	}

}
