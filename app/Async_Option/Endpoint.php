<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

class Endpoint {

	/**
	 * @var Async_Option $option
	 */
	private $option;

	/**
	 * @var string $rest_namespace
	 */
	private $rest_namespace;


	/**
	 * @var string $route
	 */
	private $route;

	/**
	 * @param string       $namespace
	 * @param Async_Option $option
	 */
	public function __construct( $namespace, $route, Async_Option $option ) {
		$this->option         = $option;
		$this->rest_namespace = $namespace;
		$this->route          = $route;
	}

	public function register_rest_route() {
		register_rest_route(
			$this->rest_namespace,
			$this->route,
			array(
				'methods'             => \WP_REST_Server::ALLMETHODS,
				'callback'            => array( $this, 'handler' ),
				'permission_callback' => array( $this, 'permissions' ),
			)
		);
	}

	/**
	 * @param \WP_REST_Request $request
	 */
	public function handler( $request ) {
		$methods = [
			'GET'    => 'handle_get',
			'POST'   => 'handle_post',
			'DELETE' => 'handle_delete',
		];

		if ( ! isset( $methods[ $request->get_method() ] ) ) {
			return new \WP_Error( 'invalid_method', 'Invalid method.', array( 'status' => 400 ) );
		}

		$method = $methods[ $request->get_method() ];

		return rest_ensure_response( $this->$method( $request ) );
	}



	/**
	 * @param \WP_REST_Request $request
	 */
	public function handle_get( $request ) {
		return $this->option->get();
	}

	/**
	 * @param \WP_REST_Request $request
	 */
	public function handle_post( $request ) {
		$this->option->set( $request->get_body() );
		if ( $this->option->has_errors() ) {
			return new \WP_Error( 400, $this->option->get_errors(), array( 'status' => 400 ) );
		}
		return $this->option->get();
	}

	/**
	 * @param \WP_REST_Request $request
	 */
	public function handle_delete( $request ) {
		$this->option->delete();
		return $this->option->get();
	}

	/**
	 * @param \WP_REST_Request $request
	 */
	public function permissions( $request ) {
		return current_user_can( 'manage_options' ) && $this->option->nonce->verify( $request->get_header( 'X-Async-Options-Nonce' ) );
	}
}
