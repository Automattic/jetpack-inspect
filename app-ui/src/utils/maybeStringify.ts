import type { JSONSchema } from '@src/utils/Validator';

export function maybeStringify(value: JSONSchema | string): string {
	if (typeof value === "string") {
		return value;
	}

	try {
		return JSON.stringify(value, null, 2);
	} catch (_e) {
		return value;
	}

}
