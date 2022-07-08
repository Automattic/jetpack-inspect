import type { EntryData, LogEntry } from '@src/utils/Validator';
import { LogEntries } from '@src/utils/Validator';
import { maybeStringify } from '@src/utils/maybeStringify';

export default class API {

	private async request(
		endpoint: string,
		method = "GET",
		body?: unknown
	): Promise<unknown> {

		const result = await fetch(`/wp-json/jetpack-inspect/${endpoint}`, {
			method,
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify(body),
		});

		if (!result.ok) {
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

	public async latest(): Promise<LogEntry[]> {
		const entries = await this.request("latest");
		if (!entries) {
			[];
		}
		return LogEntries.parse(entries);
	}

	public async clear() {
		return await this.request("clear", "DELETE");
	}

	public async getCaptureStatus(): Promise<boolean> {
		return !! await this.request("capture-status");
	}

	public async toggleCaptureStatus(): Promise<boolean> {
		return !! await this.request("capture-status", "POST");
	}

	public async updateFilter(filter: string) {
		return await this.request("filter", "POST", { filter });
	}

	public async getFilter() {
		return await this.request("filter");
	}

	public async submit(data: EntryData) {
		data.body = maybeStringify(data.body);
		data.headers = maybeStringify(data.headers);
		return await this.request("submit", "POST", data);
	}

}
