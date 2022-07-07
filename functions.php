<?php

use Automattic\Jetpack\Connection\Client;
use Automattic\Jetpack_Inspect\Capture;

function maybe_start_capture_manually() {
	$capture = Capture::instance();

	// Don't attach filters if the capture is already enabled as an option.
	if ( $capture->is_enabled() ) {
		return;
	}

	add_filter('option_jetpack_inspect_filter', '__return_null');
	$capture->attach_filters();
}

function maybe_stop_capture_manually() {
	$capture = Capture::instance();

	// Don't detach filters if the capture is enabled as an option.
	if ( $capture->is_enabled() ) {
		return;
	}

	remove_filter('option_jetpack_inspect_filter', '__return_null');
	$capture->detach_filters();
}

function jetpack_inspect_request( $url, $method = 'GET', $body = null, $headers = [] ) {

	maybe_start_capture_manually();
	
	//	$type = $request->get_param('type');

	if ( ! isset( $headers['Content-Type'] ) ) {
		$headers['Content-Type'] = 'application/json; charset=utf-8;';
	}

	//	if ( $type !== 'simple' ) {
	//		$request_data = Client::build_signed_request(
	//			[
	//				'url'     => $params['url'],
	//				'method'  => $params['method'] ?? 'POST',
	//				// @TODO: Deal with headers
	//				//			'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
	//				'headers' => (array) json_decode( $params['headers'] ),
	//			],
	//			$params['body']
	//	);
	//	}
	//
	//	if ( ! $request_data || is_wp_error( $request_data ) ) {
	//		return $request_data;
	//	}

	$result = Client::_wp_remote_request( $url, [
		'method'  => $method,
		'body'    => $body,
		'headers' => $headers,
	] );
	// Workaround a Jetpack Connection empty body feature/bug:
	if ( empty( $rbody ) ) {
		$rbody = null;
	}

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
