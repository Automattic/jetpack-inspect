import type { EntryData, LogEntry } from '@src/utils/Validator';
import { LogEntries } from '@src/utils/Validator';
import { maybeStringify } from '@src/utils/maybeStringify';
import type { Monitor } from '@src/global';

type RequestParams = string | { [key: string]: any };

export default class AsyncAPI {

	constructor(private baseUrl: string, private restNonce: string) { }

	private async request(
		endpoint: string,
		nonce: string,
		method: 'GET' | 'POST' | 'PUT' | 'DELETE' | 'PATCH',
		params?: RequestParams,
	): Promise<unknown> {

		let url = `${this.baseUrl}/${endpoint}`;

		if (method === "GET" && params) {
			url += "?" + new URLSearchParams(params).toString();
		}

		const result = await fetch(url, {
			method,
			headers: {
				"Content-Type": "application/json",
				'X-WP-Nonce': this.restNonce,
				'X-Async-Options-Nonce': nonce
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

	private async GET(endpoint: string, nonce: string, params?: RequestParams) {
		return await this.request(endpoint, nonce, "GET", params);
	}

	private async POST(endpoint: string, nonce: string, params?: RequestParams) {
		return await this.request(endpoint, nonce, "POST", params);
	}


	public async latest(nonce: string): Promise<LogEntry[]> {
		const entries = await this.GET("latest", nonce);
		if (!entries) {
			[];
		}
		return LogEntries.parse(entries);
	}

	public async clear(nonce: string) {
		return await this.request("clear", nonce, "DELETE");
	}

	public async getMonitorStatus(nonce: string): Promise<boolean> {
		return !! await this.GET("monitor-status", nonce);
	}

	public async setMonitorStatus(status: boolean, nonce: string): Promise<boolean> {
		return !! await this.POST("monitor-status", nonce, status.toString());
	}

	public async getObserverStatus(name: Monitor, nonce: string): Promise<boolean> {
		return !! await this.GET("monitor-status", nonce, { name });
	}

	public async toggleObserverStatus(name: Monitor, nonce: string): Promise<boolean> {
		return !! await this.POST("monitor-status", nonce, { name });
	}

	public async updateFilter(name: Monitor, filter: string, nonce: string) {
		return await this.POST("filter", nonce, { name, filter });
	}

	public async getFilter(name: Monitor, nonce: string) {
		return await this.GET("filter", nonce, { name });
	}

	public async sendRequest(data: EntryData, nonce: string) {
		// data.body = maybeStringify(data.body);
		// data.headers = maybeStringify(data.headers);
		return await this.POST("send-request", nonce, maybeStringify(data));
	}

}
