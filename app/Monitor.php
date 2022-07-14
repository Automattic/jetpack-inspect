<?php

namespace Automattic\Jetpack_Inspect;

use Automattic\Jetpack_Inspect\Monitor\Observable;

class Monitor {

	protected Observable $observer;
	protected string     $name;
	protected bool       $bypass_filter = false;

	public function __construct( string $name, Observable $observable ) {
		$this->name     = $name;
		$this->observer = $observable;
	}

	public function initialize() {

		if ( defined( "DOING_CRON" ) && DOING_CRON ) {
			return false;
		}

		if ( $this->is_enabled() ) {
			$this->observer->attach_hooks();

		}
		add_action( 'shutdown', [ $this, 'log' ] );
	}

	public function ensure_enabled() {
		if( $this->is_enabled() ) {
			return;
		}
		$this->observer->attach_hooks();
		add_action( 'shutdown', [ $this, 'log' ] );
	}

	protected function match_request_filter( $url ): bool {
		if( $this->bypass_filter ) {
			return true;
		}

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

	public function log() {

		$log_data = $this->observer->get();
		if ( ! $log_data ) {
			return;
		}
		foreach ( $log_data as $log ) {

			if ( empty( $log ) || ! $this->match_request_filter( $log['url'] ) ) {
				continue;
			}

			Log::insert( $log['url'], $log );
		}


	}

	private function key() {
		// @TODO: Compose from $this->name
		//		return 'jetpack_inspect_' . $this->name;
		return 'jetpack_inspect_enabled';
	}

	public function is_enabled() {
		return get_option( $this->key(), false );
	}

	public function toggle() {
		$new_status = ! $this->is_enabled();
		update_option( $this->key(), $new_status, false );
		return $new_status;
	}

}
