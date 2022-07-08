<?php

namespace Automattic\Jetpack_Inspect;

class Monitor {

	private        $start_time = [];
	private static $instance;

	public static function instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function initialize() {
		if ( $this->is_enabled() ) {
			$this->attach_filters();
		}
	}

	public function attach_filters() {
		add_filter( 'http_request_args', [ $this, 'start_timer' ], 10, 2 );
		add_action( 'http_api_debug', [ $this, 'monitor_request' ], 10, 5 );
	}

	protected function match_request_filter( $url ): bool {
		$filter = get_option( 'jetpack_inspect_filter' );
		if ( ! $filter ) {
			return true;
		}

		// https://example.com/?foo=bar will match "*example[s].com*
		if ( str_contains( $filter, '*' ) || ( str_contains( $filter, '[' ) && str_contains( $filter, ']' ) ) ) {
			return fnmatch( $filter, $url );
		}

		// https://example.com/?foo=bar will match "https://example.com/?foo=bar"
		if ( $filter[0] === $filter[ strlen( $filter ) - 1 ] && $filter[0] === '"' ) {
			$filter = substr( $filter, 1, - 1 );
			return $filter === $url;
		}

		// https://example.com/?foo=bar will match example.com
		return str_contains( $url, $filter );
	}

	public function detach_filters() {
		remove_filter( 'http_request_args', [ $this, 'start_timer' ], 10 );
		remove_action( 'http_api_debug', [ $this, 'monitor_request' ], 10 );
	}

	public function monitor_request( $response, $context, $transport, $args, $url ) {
		if ( false !== strpos( $url, 'doing_wp_cron' ) ) {
			return;
		}

		if ( ! $this->match_request_filter( $url ) ) {
			return;
		}

		$log_data = [
			'url'      => $url,
			'args'  => $args,
			'transport' => $transport,
			'response' => $response,
			'duration' => floor( 1000 * ( microtime( true ) - $this->start_time[ $url ] ) ),
		];

		if ( false !== $log_data ) {
			Log::insert( $url, $log_data );
		}
	}

	public function start_timer( $args, $url ) {
		$this->start_time[ $url ] = microtime( true );
		return $args;
	}

	public function is_enabled() {
		return get_option( 'jetpack_inspect_enabled', false );
	}

	public function toggle() {
		$new_status = ! $this->is_enabled();
		update_option( 'jetpack_inspect_enabled', $new_status, false );
		return $new_status;
	}
}
