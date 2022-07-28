<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Parser;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Transformer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Storage;
use Automattic\Jetpack_Inspect\Async_Option\Storage\WP_Option;

class Async_Option {

	/**
	 * @var Sanitizer
	 */
	private $sanitizer;

	/**
	 * @var Transformer
	 */
	private $transformer;

	/**
	 * @var Storage
	 */
	private $storage;

	/**
	 * @var Validator
	 */
	private $validator;

	/**
	 * @var Parser
	 */
	private $parser;

	/**
	 * @var string
	 */
	private $key;
	private $default = false;
	private $errors  = [];

	/**
	 * @var Authenticated_Nonce
	 */
	public $nonce;

	public function __construct( $key ) {
		$this->key = $key;

		$default_handler   = new Unsafe_Handler();
		$this->sanitizer   = $default_handler;
		$this->transformer = $default_handler;
		$this->validator   = $default_handler;
		$this->parser      = $default_handler;

		$this->storage = new WP_Option();
		$this->nonce   = new Authenticated_Nonce( $key );
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

		if ( $handler instanceof Parser ) {
			$this->parser = $handler;
		}

	}

	public function add_error( $message ) {
		$this->errors[] = $message;
	}

	public function has_errors() {
		return ! empty( $this->errors );
	}

	public function get_errors() {
		return implode( "\n", $this->errors );
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

		$value = $this->parser->parse( $value );

		if ( true !== $this->validator->validate( $value ) ) {
			$this->add_error( $this->validator->validate( $value ) );
		}

		if ( isset( $this->storage ) ) {
			return $this->storage->set( $this->key, $this->sanitizer->sanitize( $value ) );
		}

		return false;
	}

	public function delete() {
		return $this->storage->delete( $this->key );
	}

	public function key() {
		return $this->key;
	}


}
