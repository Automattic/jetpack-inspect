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

require __DIR__ . '/vendor/autoload.php';

use Automattic\Jetpack_Inspect\Capture;
use Automattic\Jetpack_Inspect\Log;
use Automattic\Jetpack_Inspect\REST_API\Endpoints\Latest;
use Automattic\Jetpack_Inspect\REST_API\REST_API;

function enqueue_admin_scripts() {
	wp_enqueue_script( 'jetpack-inspect-main', plugins_url( 'app-ui/build/main.js', __FILE__ ), [], '1.0.0', true );
	wp_enqueue_style( 'jetpack-inspect-css', plugins_url( 'app-ui/build/style.css', __FILE__ ), [], '1.0.0' );
}

/**
 * Create an admin menu item for Jetpack Boost Svelte edition.
 */
function register_admin_menu() {
	$title = __( 'Jetpack Inspect', 'jetpack-boost' );

	$page = add_menu_page(
		$title,
		$title,
		'manage_options',
		'jetpack-inspect',
		__NAMESPACE__ . '\render_admin_page',
		'dashicons-hammer',
		50
	);

	add_action( 'load-' . $page, __NAMESPACE__ . '\enqueue_admin_scripts' );
}

function render_admin_page() {
	wp_localize_script(
		'jetpack-inspect-config',
		'wpApiSettings',
		array(
			'root' => esc_url_raw( rest_url() ),
		)
	);
	?>
	<div id="jetpack-inspect"></div>
	<?php
}


add_action( 'admin_menu', __NAMESPACE__ . '\register_admin_menu' );
//add_action( 'rest_api_init', 'Automattic\Jetpack_Inspect\API\register_rest_routes' );

add_action( 'init', [ Log::class, 'register_post_type' ] );
//add_action( 'plugins_loaded', [ Capture::class, 'initialize' ] );

add_action( 'init', function() {
	REST_API::register( Latest::class );
} );
