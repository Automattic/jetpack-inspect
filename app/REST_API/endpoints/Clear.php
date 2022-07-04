<?php
/**
 * Create a new request for cloud critical CSS.
 *
 * Handler for POST 'cloud-css/request-generate'.
 */
namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\Log;
use Automattic\Jetpack_Inspect\REST_API\Contracts\Endpoint;
use Automattic\Jetpack_Inspect\REST_API\Permissions\Current_User_Admin;
use WP_REST_Response;

class Clear implements Endpoint {

	public function name() {
		return 'clear';
	}

	public function request_methods() {
		return \WP_REST_Server::DELETABLE;
	}

	//phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
	public function response( $request ) {
		return new WP_REST_Response(
			Log::clear(),
		);

	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}
