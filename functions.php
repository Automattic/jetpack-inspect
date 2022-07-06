<?php

use Automattic\Jetpack\Connection\Client;
use Automattic\Jetpack_Inspect\Capture;

function maybe_start_capture_manually() {
	$capture = Capture::instance();

	// Don't attach filters if the capture is already enabled as an option.
	if ( $capture->is_enabled() ) {
		return;
	}

	$capture->attach_filters();
}

function maybe_stop_capture_manually() {
	$capture = Capture::instance();

	// Don't detach filters if the capture is enabled as an option.
	if ( $capture->is_enabled() ) {
		return;
	}

	$capture->detach_filters();
}

function jetpack_inspect_request( \WP_REST_Request $request ) {

	maybe_start_capture_manually();


	$data                    = $request->get_params();
	$request_data            = $data;
	$request_data['headers'] = [ 'Content-Type' => 'application/json; charset=utf-8' ];

	// @TODO: Make auth optional
	$request_data = Client::build_signed_request(
		[
			'url'     => $data['url'],
			'method'  => $data['method'] ?? 'POST',
			// @TODO: Deal with headers
			//			'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
			'headers' => (array) json_decode( $data['headers'] ),
		],
		$data['body']
	);


	if ( ! $request_data || is_wp_error( $request_data ) ) {
		return $request_data;
	}
	$result = Client::_wp_remote_request( $request_data['url'], $request_data['request'] );

	$body = wp_remote_retrieve_body( $result );

	try {
		$bodyObj = json_decode( $body, false, 512, JSON_THROW_ON_ERROR );
		if ( is_object( $bodyObj ) ) {
			$body = $bodyObj;
		}
	} catch ( Exception $e ) {
		// do nothing
	}

	maybe_stop_capture_manually();
	return [
		'body'     => $body,
		'request'  => $request_data,
		'headers'  => wp_remote_retrieve_headers( $result ),
		'cookies'  => wp_remote_retrieve_cookies( $result ),
		'data'     => $request,
		'response' => $result,
	];
}
