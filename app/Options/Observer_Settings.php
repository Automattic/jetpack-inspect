<?php

namespace Automattic\Jetpack_Inspect\Options;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Parser;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;

class Observer_Settings implements Sanitizer, Validator, Parser {

	public function sanitize( $value ) {
		return [
			'enabled' => filter_var($value['enabled'], FILTER_VALIDATE_BOOLEAN),
			'filter' => sanitize_text_field( $value['filter'] ),
		];
	}

	public function validate( $value ) {
		// @TODO: Would be nice to be able to return multiple errors at once.
		if ( ! isset( $value['enabled'] ) ) {
			return "Missing required paramtered 'enabled'";
		}
		if ( ! isset( $value['filter'] ) ) {
			return "Missing required paramtered 'filters'";
		}

		return true;
	}

	public function parse( $value ) {
		 return json_decode($value, ARRAY_A);
	}
}

