<?php
/**
 * Create a new request for cloud critical CSS.
 *
 * Handler for POST 'cloud-css/request-generate'.
 */

namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\Monitor;
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
			return rest_ensure_response( Monitor::instance()->is_enabled() );
		}

		return rest_ensure_response(
			Monitor::instance()->toggle()
		);

	}

	public function permissions() {
		return array(
			new Current_User_Admin()
		);
	}
}
