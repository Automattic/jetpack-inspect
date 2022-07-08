<?php

namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\REST_API\Permissions\Current_User_Admin;
use WP_REST_Server;

class Submit {
	public function name() {
		return 'submit';
	}

	public function request_methods() {
		return WP_REST_Server::EDITABLE;
	}

	public function maybe_get_json( $string ) {
		try {
			return json_decode( $string, ARRAY_A, 512, JSON_THROW_ON_ERROR );
		} catch ( \Exception $e ) {
			if ( "" === $string ) {
				return [];
			}
			return $string;
		}
	}

	public function response( $request ) {

		$body    = $request->get_param( 'body' );
		$headers = $request->get_param( 'headers' );
		$method  = $request->get_param( 'method' );
		$url     = $request->get_param( 'url' );


		$headers = $this->maybe_get_json( $headers );
		$body    = $this->maybe_get_json( $body );



		$args = [
			'method'  => $method,
			'body'    => $body,
			'headers' => $headers,
		];

		$function = $this->get_transport_function( $request );
		if ( is_wp_error( $function ) ) {
			return rest_ensure_response( $function );
		}

		maybe_start_capture_manually();
		$results = $function( $url, $args, );
		maybe_stop_capture_manually();

		return rest_ensure_response( $results );
	}

	private function get_transport_function( $request ) {
		$transport_name       = $request->get_param( 'transport' ) ?? 'wp_remote_request';
		$available_transports = [
			'jetpack_connection' => 'jetpack_inspect_request',
			'wp'                 => 'wp_remote_request',
		];

		if ( isset( $available_transports[ $transport_name ] ) ) {
			$function = $available_transports[ $transport_name ];
		}

		if ( ! isset( $function ) || ! function_exists( $function ) ) {
			return new \WP_Error( 'Invalid Request Type' );
		}

		return $function;
	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}