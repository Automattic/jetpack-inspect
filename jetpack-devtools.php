<?php
/**
 * Plugin Name: Jetpack Devtools
 * Version: 1.0.0
 * Plugin URI: https://automattic.com
 * Description: Easier development for Jetpack
 * Author: Nauris Pūķis
 * Author URI: https://automattic.com
 * Requires at least: 5.5
 *
 * Text Domain: jetpack-devtools
 */

namespace Automattic\Jetpack_Devtools;


function enqueue_admin_scripts() {
	wp_enqueue_script( 'jetpack-devtools', plugins_url( 'public/build/bundle.js', __FILE__ ), [], '1.0.0', true );
}

/**
 * Create an admin menu item for Jetpack Boost Svelte edition.
 */
function register_admin_menu() {
	$title = __( 'Jetpack Devtools', 'jetpack-boost' );

	$page = add_menu_page(
		$title,
		$title,
		'manage_options',
		'jetpack-devtols',
		__NAMESPACE__ . '\render_admin_page',
		'dashicons-hammer',
		50
	);

	add_action( 'load-' . $page, __NAMESPACE__ . '\enqueue_admin_scripts' );
}

function render_admin_page() {
	wp_localize_script(
		'boost-svelte-bundle-js',
		'wpApiSettings',
		array(
			'root' => esc_url_raw( rest_url() ),
		)
	);
	?>
	<div id="jetpack-devtools"></div>
	<?php
}


add_action( 'admin_menu', __NAMESPACE__ . '\register_admin_menu' );
