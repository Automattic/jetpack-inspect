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
		add_action( 'shutdown', [ $this, 'save' ] );
	}

	public function ensure_enabled() {
		if ( $this->is_enabled() ) {
			return;
		}
		$this->observer->attach_hooks();
		add_action( 'shutdown', [ $this, 'log' ] );
	}

	protected function match_request_filter( $url ): bool {
		if ( $this->bypass_filter ) {
			return true;
		}

		$filter = $this->get_filter();
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

	public function save() {

		$log_data = $this->observer->get();
		if ( ! $log_data ) {
			return;
		}

		foreach ( $log_data as $data ) {

			if ( empty( $data ) || ! $this->match_request_filter( $data['url'] ) ) {
				continue;
			}

			// @TODO: Create a Log object. This will do for now.
			$url = $data['url'];
			unset( $data['url'] );

			$log_name = $this->name;
			if ( isset( $data['error'] ) ) {
				$log_name = 'wp_error';
			}

			$log = [
				'url'     => $url,
				$log_name => $data,
			];


			Log::insert( $url, $log );
		}


	}

	/**
	 * Generate keys for wp options dynamically
	 *   Example keys:
	 *      * jp_inspect_remote_request_enabled => boolean
	 *      * jp_inspect_remote_request_filter => string
	 */
	private function key( $name ) {
		return "jp_inspect_{$this->name}_{$name}";
	}

	public function is_enabled() {
		return get_option( $this->key( 'enabled' ), false );
	}

	public function toggle() {
		$new_status = ! $this->is_enabled();
		update_option( $this->key( 'enabled' ), $new_status, false );
		return $this->is_enabled();
	}

	public function set_filter( $value ) {
		return update_option( $this->key( 'filter' ), sanitize_text_field( $value ), false );
	}

	public function get_filter() {
		return get_option( $this->key( 'filter' ), '' );
	}

}
