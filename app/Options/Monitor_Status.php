<?php

namespace Automattic\Jetpack_Inspect\Options;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Transformer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;

class Monitor_Status implements Validator, Sanitizer, Transformer {

	public function sanitize( $value ): bool {
		return (bool) $value;
	}

	public function validate( $value ) {
		if ( ! is_bool( $value ) ) {
			return esc_html__( 'Monitor status should be a boolean.', 'jetpack-inspect' );
		}

		return true;
	}

	public function transform( $value ) {
		return (bool) $value;
	}
}


