<?php

namespace Automattic\Jetpack_Inspect\Options;

use Automattic\Jetpack_Inspect\Async_Option\Async_Option_Template;

class Observer_Settings extends Async_Option_Template {

	const DEFAULT = [
		'enabled' => true,
		'filter'  => '',
	];

	public function sanitize( $value ) {
		return [
			'enabled' => filter_var( $value['enabled'], FILTER_VALIDATE_BOOLEAN ),
			'filter'  => sanitize_text_field( $value['filter'] ),
		];
	}

	public function validate( $value ) {
		// @TODO: Would be nice to be able to return multiple errors at once.
		if ( ! isset( $value['enabled'] ) ) {
			return "Missing required key 'enabled'";
		}
		if ( ! isset( $value['filter'] ) ) {
			return "Missing required key 'filters'";
		}

		return true;
	}

	public function parse( $value ) {
		return json_decode( $value, ARRAY_A );
	}
}

