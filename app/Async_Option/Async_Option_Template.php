<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Storage\WP_Option;

/**
 * This is a null-class.
 *
 * It's used as a fallback handler by default on every option that is registered.
 * When an option registers a custom handler, it's going to
 * automatically overwrite the method listed here.
 */
abstract class Async_Option_Template {

	const DEFAULT = false;

	public function setup_storage( $storage_namespace ) {
		return new WP_Option( $storage_namespace );
	}

	public function transform( $value ) {
		return $value;
	}

	public function validate( $value ) {
		return true;
	}

	public function sanitize( $value ) {
		return $value;
	}

	public function parse( $value ) {
		return $value;
	}


}
