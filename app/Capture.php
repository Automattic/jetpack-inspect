<?php

namespace Automattic\Jetpack_Inspect;

class Capture {

	private $start_time = [];

	public static function initialize() {
		$capture = new self();
		add_filter( 'http_request_args', [ $capture, 'start_timer' ], 10, 2 );
		add_action( 'http_api_debug', [ $capture, 'capture_request' ], 10, 5 );
	}

	public function capture_request( $response, $context, $transport, $args, $url ) {
		if ( false !== strpos( $url, 'doing_wp_cron' ) ) {
			return;
		}

		$log_data = [
			'url'      => $url,
			'request'     => $args,
			'response' => $response,
			'duration'  => floor( 1000 * ( microtime( true ) - $this->start_time[ $url ] ) )
		];

		if ( false !== $log_data ) {
			Log::insert( $url, $log_data );
		}
	}

	public function start_timer( $args, $url ) {
		$this->start_time[ $url ] = microtime( true );
		return $args;
	}
}
