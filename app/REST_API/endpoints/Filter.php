<?php

namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\REST_API\Permissions\Current_User_Admin;

class Filter {
	public function name() {
		return 'filter';
	}

	public function request_methods() {
		return 'GET, POST';
	}

	public function response( $request ) {

		if ( $request->get_method() === 'GET' ) {
			return rest_ensure_response( get_option( "jetpack_inspect_filter") );
		}

		$filter = $request->get_param( 'filter' );
		update_option( "jetpack_inspect_filter", sanitize_text_field( $filter ) );
		return rest_ensure_response( true );
	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}