import type { EntryData, LogEntry } from '@src/utils/Validator';
import { LogEntries } from '@src/utils/Validator';
import { maybeStringify } from '@src/utils/maybeStringify';
import type { Monitor } from '@src/global';

export default class API {

	private async request(
		endpoint: string,
		method = "GET",
		params?: string | Record<string, string>
	): Promise<unknown> {

		let url = `${window.wpApiSettings.root}/jetpack-inspect/${endpoint}`;

		if (method === "GET" && params) {
			url += "?" + new URLSearchParams(params).toString();
		}

		const result = await fetch(url, {
			method,
			headers: {
				"Content-Type": "application/json",
				// @ts-ignore
				'X-WP-Nonce': window.wpApiSettings.nonce
			},
			credentials: 'same-origin',
			body: method === "POST" && params ? maybeStringify(params) : undefined,
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

	public async getMonitorStatus(name: Monitor): Promise<boolean> {
		return !! await this.request("monitor-status", "GET", { name });
	}

	public async toggleMonitorStatus(name: Monitor): Promise<boolean> {
		return !! await this.request("monitor-status", "POST", { name });
	}

	public async updateFilter(name: Monitor, filter: string) {
		return await this.request("filter", "POST", { name, filter });
	}

	public async getFilter(name: Monitor) {
		return await this.request("filter", "GET", { name });
	}

	public async sendRequest(data: EntryData) {
		// data.body = maybeStringify(data.body);
		// data.headers = maybeStringify(data.headers);
		return await this.request("send-request", "POST", maybeStringify( data ) );
	}

}
