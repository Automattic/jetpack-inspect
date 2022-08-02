<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Options\Monitor_Status;


function jetpack_inspect_register_option( $name, $handler = null ) {
	return Registry::get_instance( 'jetpack_inspect' )
	               ->regsiter( $name, $handler );
}



/**
 * Functions to make it easier to interface with Async Option:
 */
/**
 * @param $name
 *
 * @return Async_Option
 */
function jetpack_inspect_option( $name ) {
	return Registry::get_instance( 'jetpack_inspect' )->get_option( $name );
}

function jetpack_inspect_get_option( $option ) {
	return jetpack_inspect_option( $option )->get();
}

function jetpack_inspect_update_option( $option, $value ) {
	return jetpack_inspect_option( $option )->set( $value );
}

/**
 * Register Options
 */
jetpack_inspect_register_option( 'monitor_status', Monitor_Status::class );



add_action( 'admin_init', function() {

	add_action( get_plugin_page_hook( 'jetpack-inspect', 'admin' ), function() {
		Registry::get_instance( 'jetpack_inspect' )
		        ->attach_to_script( 'jetpack-inspect-main' );
	} );

} );

