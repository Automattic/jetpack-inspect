<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Has_Storage;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Parser;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Transformer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;
use Automattic\Jetpack_Inspect\Async_Option\Storage\WP_Option;

/**
 * This is a null-class.
 *
 * It's used as a fallback handler by default on every option that is registered.
 * When an option registers a custom handler, it's going to
 * automatically overwrite the method listed here.
 */
class Async_Option_Template implements Parser, Transformer, Validator, Sanitizer, Has_Storage {

	/**
	 * @inheritDoc
	 */
	public function setup_storage( $key ) {
		return new WP_Option( $key );
	}

	/**
	 * @inheritDoc
	 */
	public function transform( $value ) {
		return $value;
	}

	/**
	 * @inheritDoc
	 */
	public function validate( $value ) {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function sanitize( $value ) {
		return $value;
	}

	/**
	 * @inheritDoc
	 */
	public function parse( $value ) {
		return $value;
	}
}
