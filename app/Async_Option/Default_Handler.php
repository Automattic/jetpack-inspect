<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Parser;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Transformer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;


/**
 * This is a null-class.
 *
 * It's used as a fallback handler by default on every option that is registered.
 * When an option registers a custom handler, it's going to
 * automatically overwrite the method listed here.
 */
class Default_Handler implements Parser, Transformer, Validator, Sanitizer {

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
