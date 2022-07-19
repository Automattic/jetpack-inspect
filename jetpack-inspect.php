<?php
/**
 * Plugin Name: Jetpack Inspect
 * Version: 1.0.0
 * Plugin URI: https://automattic.com
 * Description: Inspect HTTP requests and responses with Jetpack.
 * Author: pyronaur
 * Author URI: https://automattic.com
 * Requires at least: 6.0
 *
 * Text Domain: jetpack-inspect
 */

require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload_packages.php';


use Automattic\Jetpack_Inspect\Admin_Page;
use Automattic\Jetpack_Inspect\Log;
use Automattic\Jetpack_Inspect\Monitors;
use Automattic\Jetpack_Inspect\REST_API\Endpoints\Monitor_Status;
use Automattic\Jetpack_Inspect\REST_API\Endpoints\Clear;
use Automattic\Jetpack_Inspect\REST_API\Endpoints\Filter;
use Automattic\Jetpack_Inspect\REST_API\Endpoints\Latest;
use Automattic\Jetpack_Inspect\REST_API\Endpoints\Send_Request;
use Automattic\Jetpack_Inspect\REST_API\Endpoints\Test_Request;
use Automattic\Jetpack_Inspect\REST_API\REST_API;

require __DIR__ . '/functions.php';

function jetpack_inspect_initialize() {
	Log::register_post_type();
	REST_API::register(
		[
			Latest::class,
			Clear::class,
			Monitor_Status::class,
			Send_Request::class,
			Filter::class,
		]
	);

	if ( defined( 'JETPACK_INSPECT_DEBUG' ) && JETPACK_INSPECT_DEBUG ) {
		REST_API::register( Test_Request::class );
	}
}

add_action( 'init', 'jetpack_inspect_initialize' );
add_action( 'admin_menu', [ new Admin_Page(), 'register' ] );
add_action( 'plugins_loaded', [ Monitors::class, 'initialize' ] );


require_once __DIR__ . './app/Async_Option/usage.php';