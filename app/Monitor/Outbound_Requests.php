<?php

namespace Automattic\Jetpack_Inspect\Monitor;

class Outbound_Requests implements Observable {
	private $start_time = [];
	private $logs       = [];

	public function attach_hooks() {
		add_filter( 'http_request_args', [ $this, 'start_timer' ], 10, 2 );
		add_action( 'http_api_debug', [ $this, 'log' ], 10, 5 );
	}

	public function detach_hooks() {
		remove_filter( 'http_request_args', [ $this, 'start_timer' ], 10 );
		remove_action( 'http_api_debug', [ $this, 'log' ], 5 );
	}

	public function start_timer( $args, $url ) {
		$this->start_time[ $url ] = microtime( true );
		return $args;
	}

	public function log( $response, $context, $transport, $args, $url ) {
		$this->logs[] = [
			'url'      => $url,
			'args'     => $args,
			'response' => $response,
			'duration' => floor( 1000 * ( microtime( true ) - $this->start_time[ $url ] ) ),
		];
	}

	public function get() {
		return $this->logs;
	}
}