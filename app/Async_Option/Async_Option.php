<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Storage;


class Async_Option {

	/**
	 * @var string
	 */
	private $key;


	/**
	 * @var Authenticated_Nonce
	 */
	public $nonce;


	/**
	 * @var Storage
	 */
	protected $storage;

	/**
	 * @var Async_Option_Template
	 */
	protected $value;

	/**
	 * @var string[]
	 */
	private $errors = [];



	/**
	 * @param $namespace string
	 * @param $key       string
	 * @param $value     Async_Option_Template
	 */
	public function __construct( $namespace, $key, $value ) {
		$this->key     = $key;
		$this->value   = $value;
		$this->nonce   = new Authenticated_Nonce( "{$namespace}_{$key}" );
		$this->storage = $this->value->setup_storage( $namespace );
	}

	public function add_error( $message ) {
		// @TODO: Would be nice to be able to return multiple errors at once.
		// This should become $this->add_errors() and just cast whatever value to array
		$this->errors[] = $message;
	}

	public function has_errors() {
		return ! empty( $this->errors );
	}

	public function get_errors() {
		return implode( "\n", $this->errors );
	}

	public function get() {
		return $this->value->transform(
			$this->storage->get( $this->key, $this->value::DEFAULT )
		);
	}

	public function set( $value ) {

		$value = $this->value->parse( $value );

		if ( true !== $this->value->validate( $value ) ) {
			$this->add_error( $this->value->validate( $value ) );
		}

		if ( isset( $this->storage ) ) {
			return $this->storage->set( $this->key, $this->value->sanitize( $value ) );
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
