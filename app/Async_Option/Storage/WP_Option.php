<?php

namespace Automattic\Jetpack_Inspect\Async_Option\Storage;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Storage;

class WP_Option implements Storage {
	
	public function get( $key, $default = false ) {
		return get_option( $key, $default );
	}


	public function set( $key, $value ) {
		return update_option( $key, $value );
	}

	public function delete( $key ) {
		return delete_option( $key );
	}
}
