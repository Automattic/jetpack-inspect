import { z } from 'zod';

export const WP_Request = z.object({
	"method": z.string(),
	"timeout": z.number(),
	"redirection": z.number(),
	"httpversion": z.string(),
	"user-agent": z.string(),
	"reject_unsafe_urls": z.boolean(),
	"blocking": z.boolean(),
	"headers": z.object({
		"Authorization": z.string(),
	}),
	"cookies": z.array(z.string()),
	"body": z.string().nullable(),
	"compress": z.boolean(),
	"decompress": z.boolean(),
	"sslverify": z.boolean(),
	"sslcertificates": z.string(),
	"stream": z.boolean(),
	"filename": z.string().nullable(),
	"limit_response_size": z.string().nullable(),
	"_redirection": z.number()
});

export const Response = z.object({
	"headers": z.array(z.string()),
	"body": z.string(),
	"response": z.object({
		"code": z.number(),
		"message": z.string(),
	}),
	"cookies": z.array(z.string()),
	"filename": z.string().nullable(),
	"http_response": z.object({
		"data": z.string().nullable(),
		"headers": z.array(z.string()).nullable(),
		"status": z.number().nullable()
	})
});


export const LogEntry = z.object({
	"id": z.number(),
	"date": z.string(),
	"data": z.object({
		"url": z.string(),
		"duration": z.number(),
		"request": WP_Request,
		"response": Response,
	}),

});


export const LogEntries = z.array(LogEntry);

export type WP_Request = z.infer<typeof WP_Request>;
export type Response = z.infer<typeof Response>;
export type LogEntry = z.infer<typeof LogEntry>;
export type LogEntries = z.infer<typeof LogEntries>;
