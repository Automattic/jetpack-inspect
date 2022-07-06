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
		$body    = $request->get_param( 'body' );
		$headers = $request->get_param( 'headers' ) ?? [];
		$method  = $request->get_param( 'method' );
		$url     = $request->get_param( 'url' );
		
		return rest_ensure_response( jetpack_inspect_request( $url, $method, $body, $headers ) );
	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}