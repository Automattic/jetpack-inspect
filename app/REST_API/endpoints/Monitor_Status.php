<?php
/**
 * Create a new request for cloud critical CSS.
 *
 * Handler for POST 'cloud-css/request-generate'.
 */

namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\Monitor;
use Automattic\Jetpack_Inspect\Monitors;
use Automattic\Jetpack_Inspect\REST_API\Contracts\Endpoint;
use Automattic\Jetpack_Inspect\REST_API\Permissions\Current_User_Admin;
use Automattic\Jetpack_Inspect\REST_API\Permissions\Nonce;

class Monitor_Status implements Endpoint {

	public function name() {
		return 'monitor-status';
	}

	public function request_methods() {
		return 'GET, POST, PUT, PATCH';
	}

	public function response( $request ) {
		if ( $request->get_method() === 'GET' ) {
			return $this->handle_get( $request );
		}

		return $this->handle_post( $request );

	}

	private function handle_get( $request ) {
		$name = $request->get_param( 'name' );
		if ( ! $name ) {
			return rest_ensure_response( Monitors::status() );
		}
		$monitor = Monitors::get( $name );
		if ( ! $monitor ) {
			return rest_ensure_response( new \WP_Error( 'monitor_not_found', 'Monitor not found.', [ 'status' => 404 ] ) );
		}
		return rest_ensure_response( $monitor->is_enabled() );
	}

	private function handle_post( $request ) {
		$name = $request->get_param( 'name' );
		if ( ! $name ) {
			return rest_ensure_response( Monitors::toggle() );
		}
		$monitor = Monitors::get( $name );
		if ( ! $monitor ) {
			return rest_ensure_response( new \WP_Error( 'monitor_not_found', 'Monitor not found.', [ 'status' => 404 ] ) );
		}
		rest_ensure_response(
			$monitor->toggle( $request )
		);
	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}
