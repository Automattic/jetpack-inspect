<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Storage\WP_Option;

class Registry {

	/**
	 * @var Registry[]
	 */
	private static $instance = array();

	/**
	 * @var Async_Option[]
	 */
	private $options = array();

	/**
	 * @var Endpoint[]
	 */
	private $endpoints = array();

	/**
	 * @var string
	 */
	private $namespace;

	/**
	 * @var string
	 */
	private $rest_namespace;

	private function __construct( $namespace ) {
		$this->namespace      = $namespace;
		$this->rest_namespace = $this->sanitize_http_name( $namespace );
	}

	public static function get_instance( $namespace ) {
		if ( ! isset( self::$instance[ $namespace ] ) ) {
			self::$instance[ $namespace ] = new self( $namespace );
		}

		return self::$instance[ $namespace ];
	}

	public function sanitize_option_name( $key ) {
		$sanitized_key = sanitize_key( $key );
		$sanitized_key = str_replace( '-', '_', $sanitized_key );
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG && $sanitized_key !== $key ) {
			throw new \Exception( "Invalid key '$key'. Keys should only include alphanumeric characters and underscores." );
		}
		return $sanitized_key;
	}

	public function sanitize_http_name( $key ) {
		return str_replace( '_', '-', sanitize_key( $key ) );
	}

	public function regsiter( $option_name, $handler = null ) {

		$storage     = new WP_Option();
		$option_name = $this->sanitize_option_name( $option_name );

		$option                        = new Async_Option( $this->namespace, $option_name, $storage );
		$this->options[ $option_name ] = $option;

		if ( $handler ) {
			$option->handler( new $handler() );
		}

		$endpoint                        = new Endpoint( $this->rest_namespace, $this->sanitize_http_name( $option->key() ), $option );
		$this->endpoints[ $option_name ] = $endpoint;

		add_action( 'rest_api_init', [ $endpoint, 'register_rest_route' ] );

		return $option;
	}

	public function all() {
		return $this->options;
	}

	public function get_endpoint( $name ) {
		return $this->endpoints[ $name ];
	}

	public function get_option( $name ) {
		return $this->options[ $name ];
	}

	public function attach_to_script( $script_handle_name ) {
		$data = [
			'rest_api' => [
				'value'  => rest_url( $this->rest_namespace ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
			],
		];
		foreach ( $this->options as $option ) {
			$data[ $option->key() ] = [
				'value' => $option->get(),
				'nonce' => $option->nonce->create(),
			];
		}
		wp_localize_script( $script_handle_name, $this->namespace, $data );
	}

}
