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

	public function response( $request ) {
		return rest_ensure_response( jetpack_inspect_request( $request ) );
	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}