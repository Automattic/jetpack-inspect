import type { z } from 'zod';

export function getOptionsFromGlobal<T extends z.ZodTypeAny>(key: string, parser: T): z.infer<T> {
	if (!(key in window)) {
		console.error(`Could not locate global variable ${key}`);
		return false;
	}

	// @TODO: Mark? Any Ideas to avoid @ts-ignore?
	// Ignore TypeScript complaints just this once.
	// @ts-ignore
	const obj = window[key];
	const result = parser.safeParse(obj);

	if (!result.success) {
		console.error("Error parsing options for", key, result.error);
		return false;
	}

	return result.data;
}
