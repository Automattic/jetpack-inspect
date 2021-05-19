<?php

namespace Automattic\Jetpack_DevTools\API;

//register_rest_route( string $namespace, string $route, array $args = array(), bool $override = false );
//The Following registers an api route with multiple parameters.
use Automattic\Jetpack\Connection\Client;

add_action( 'rest_api_init', __NAMESPACE__ . '\register_rest_routes' );

function user_is_admin() {
	current_user_can( 'manage' );
}

function register_rest_routes() {
	register_rest_route( 'jetpack-devtools', 'wpcom', array(
		'methods' => \WP_REST_Server::EDITABLE,
		'permissions' => __NAMESPACE__ . '\user_is_admin',
		'callback' => __NAMESPACE__ . '\jetpack_request',
	) );
}


function jetpack_request( \WP_REST_Request $request ) {
	$data = $request->get_params();

	$request_data = Client::build_signed_request(
		[
			'url' => $data['url'],
			'method' => $data['method'] ?? 'POST',
			'headers' => [ 'Content-Type' => 'application/json; charset=utf-8' ],
//				'headers' => (array) json_decode( $data['headers'] ),
		],
		$data['body']
	);
	if ( ! $request_data || is_wp_error( $request_data ) ) {
		return $request_data;
	}
	$result = Client::_wp_remote_request( $request_data['url'], $request_data['request'] );

	$body = wp_remote_retrieve_body( $result );
	$bodyObj = json_decode( $body );
	if ( is_object( $bodyObj ) ) {
		$body = $bodyObj;
	}

	return rest_ensure_response( [
		'body' => $body,
		'request' => $request_data,
		'headers' => wp_remote_retrieve_headers( $result ),
		'cookies' => wp_remote_retrieve_cookies( $result ),
		 'data' => $request,
		'response' => $result,
	] );
}
