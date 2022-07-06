<?php

namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\REST_API\Permissions\Current_User_Admin;
use WP_REST_Server;

class Filter {
	public function name() {
		return 'filter';
	}

	public function request_methods() {
		return WP_REST_Server::EDITABLE;
	}

	public function response( $request ) {
		$filter = $request->get_param( 'filter' );

		update_option( "jetpack_inspect_filter", sanitize_text_field( $filter ) );
		return rest_ensure_response( 200 );
	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}