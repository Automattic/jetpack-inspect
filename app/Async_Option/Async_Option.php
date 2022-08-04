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
	 * @param $namespace string
	 * @param $key       string
	 * @param $value     Async_Option_Template
	 */
	public function __construct( $namespace, $key, $value ) {
		$this->key     = $key;
		$this->value   = $value;
		$this->storage = $this->value->setup_storage( $namespace );
	}

	public function get() {
		return $this->value->transform(
			$this->storage->get( $this->key, $this->value::DEFAULT )
		);
	}

	public function set( $input ) {

		$value = $this->value->parse( $input );

		if ( true !== $this->value->validate( $value ) ) {
			return $this->value->get_errors();
		}

		if ( ! empty( $this->storage ) ) {
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

	public function has_errors() {
		return $this->value->has_errors();
	}

	public function get_errors() {
		return $this->value->get_errors();
	}


}
