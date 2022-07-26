<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Transformer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Storage;
use Automattic\Jetpack_Inspect\Async_Option\Storage\WP_Option;

class Async_Option {

	private Sanitizer   $sanitizer;
	private Transformer $transformer;
	private Storage     $storage;
	private Validator   $validator;
	private string      $key;
	private             $default = false;
	private             $errors  = [
		'validation'   => [],
		'sanitization' => [],
		'validator'    => [],
	];

	public function __construct( $key ) {
		$this->key = $key;

		$default_handler   = new Unsafe_Handler();
		$this->sanitizer   = $default_handler;
		$this->transformer = $default_handler;
		$this->validator   = $default_handler;

		$this->storage = new WP_Option();
	}

	/**
	 * Automatically register based on implemented interfaces.
	 *
	 * @return void
	 */
	public function handler( $handler ) {

		if ( $handler instanceof Sanitizer ) {
			$this->sanitizer = $handler;
		}

		if ( $handler instanceof Validator ) {
			$this->validator = $handler;
		}

		if ( $handler instanceof Transformer ) {
			$this->transformer = $handler;
		}

	}

	public function error( $group, $message ) {
		return new Error( $group, $message );

	}

	public function store( Storage $storage ) {
		$this->storage = $storage;

		return $this;
	}

	public function get() {
		return $this->transformer->transform(
			$this->storage->get( $this->key, $this->default )
		);
	}

	public function set( $value ) {
		if ( true !== $this->validator->validate( $value ) ) {
			$this->error( 'validator', $this->validator->validate( $value ) );
		}
		if ( ! empty( $this->storage ) ) {
			return $this->storage->set( $this->key, $this->sanitizer->sanitize( $value ) );
		}
	}

	public function delete( $key ) {
		return $this->storage->delete( $key );
	}


}
