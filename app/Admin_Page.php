<?php

namespace Automattic\Jetpack_Inspect;

class Admin_Page {
	public function enqueue() {
		wp_enqueue_script( 'jetpack-inspect-main', plugins_url( '../app-ui/build/jetpack-inspect.js', __FILE__ ), [], '1.0.0', true );
		wp_enqueue_style( 'jetpack-inspect-css', plugins_url( '../app-ui/build/jetpack-inspect.css', __FILE__ ), [], '1.0.0' );
	}

	/**
	 * Create an admin menu item for Jetpack Boost Svelte edition.
	 */
	public function register() {
		$title = __( 'Jetpack Inspect', 'jetpack-boost' );

		$page = add_menu_page(
			$title,
			$title,
			'manage_options',
			'jetpack-inspect',
			[ $this, 'render' ],
			'dashicons-hammer',
			50
		);

		add_action( 'load-' . $page, [ $this, 'enqueue' ] );
	}

	public function render() {
		wp_localize_script(
			'jetpack-inspect-main',
			'wpApiSettings',
			array(
				'root' => untrailingslashit( esc_url_raw( rest_url() ) ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
			)
		);
		?>
		<div id="jetpack-inspect"></div>
		<?php
	}

}