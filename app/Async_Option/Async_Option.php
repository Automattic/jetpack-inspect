<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Has_Storage;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Parser;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Transformer;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Validator;
use Automattic\Jetpack_Inspect\Async_Option\Contracts\Storage;


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


	/**
	 * @param $namespace string
	 * @param $key       string
	 * @param $storage   Storage
	 */
	public function __construct( $namespace, $key ) {
		$this->key   = $key;
		$this->nonce = new Authenticated_Nonce( $key );
		$this->setup_handlers( new Async_Option_Template() );

	}

	/**
	 * Automatically register based on implemented interfaces.
	 *
	 * @return void
	 */
	public function setup_handlers( $object ) {

		if ( $object instanceof Sanitizer ) {
			$this->sanitizer = $object;
		}

		if ( $object instanceof Validator ) {
			$this->validator = $object;
		}

		if ( $object instanceof Transformer ) {
			$this->transformer = $object;
		}

		if ( $object instanceof Parser ) {
			$this->parser = $object;
		}

		if ( $object instanceof Has_Storage ) {
			$this->storage = $object->setup_storage( $this->key );
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

	public function get() {
		return $this->transformer->transform(
			$this->storage->get( $this->key, $this->default )
		);
	}

	public function set_default( $value ) {
		$this->default = $value;
	}

	public function set( $value ) {

		$value = $this->parser->parse( $value );

		if ( true !== $this->validator->validate( $value ) ) {
			// @TODO: Would be nice to be able to return multiple errors at once.
			// This should become $this->add_errors() and just cast whatever value to array
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
