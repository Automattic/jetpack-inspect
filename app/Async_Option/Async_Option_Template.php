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

	/**
	 * @var string[]
	 */
	private $errors = [];

	public function setup_storage( $storage_namespace ) {
		return new WP_Option( $storage_namespace );
	}

	public function transform( $value ) {
		return $value;
	}

	public function validate( $value ) {
		return ! $this->has_errors();
	}

	public function sanitize( $value ) {
		return $value;
	}

	public function parse( $value ) {
		return $value;
	}

	public function has_errors() {
		return ! empty( $this->errors );
	}

	public function get_errors() {
		return implode( "\n", $this->errors );
	}

	protected function add_error( $message ) {
		$this->errors[] = $message;
	}
}
