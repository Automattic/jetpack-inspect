<?php
/**
 * Create a new request for cloud critical CSS.
 *
 * Handler for POST 'cloud-css/request-generate'.
 */

namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\Capture;
use Automattic\Jetpack_Inspect\REST_API\Contracts\Endpoint;
use Automattic\Jetpack_Inspect\REST_API\Permissions\Current_User_Admin;
use Automattic\Jetpack_Inspect\REST_API\Permissions\Nonce;
use WP_REST_Response;

class Capture_Status implements Endpoint {

	public function name() {
		return 'capture-status';
	}

	public function request_methods() {
		return 'GET, POST, PUT, PATCH';
	}

	public function response( $request ) {

		if ( $request->get_method() === 'GET' ) {
			return new WP_REST_Response( Capture::instance()->is_enabled() );
		}

		return new WP_REST_Response(
			Capture::instance()->toggle()
		);

	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
			new Nonce("capture-status"),
		);
	}
}
