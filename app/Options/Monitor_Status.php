<?php

namespace Automattic\Jetpack_Inspect\Options;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Parser;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Transformer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;

class Monitor_Status implements Validator, Sanitizer, Transformer, Parser {

	public function sanitize( $value ): bool {
		return (bool) $value;
	}

	public function validate( $value ) {
		if ( ! is_bool( $value ) ) {
			return sprintf( __( "Status should be a 'boolean'. Received '%s'.", 'jetpack-inspect' ), gettype( $value ) );
		}
		return true;
	}

	public function transform( $value ) {
		return (bool) $value;
	}

	public function parse( $value ) {
		return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
	}
}


