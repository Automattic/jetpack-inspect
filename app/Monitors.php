<?php

namespace Automattic\Jetpack_Inspect;

use Automattic\Jetpack_Inspect\Monitor\Incoming_REST_API;
use Automattic\Jetpack_Inspect\Monitor\Outgoing;

class Monitors {
	protected const AVAILABLE_OBSERVERS = [
		'outgoing' => Outgoing::class,
		'incoming' => Incoming_REST_API::class,
	];
	protected static $instances = [];

	public static function get( $name ) {

		if ( ! isset( static::AVAILABLE_OBSERVERS[ $name ] ) ) {
			return new \WP_Error( "The requested monitor doesn't exist." );
		}

		if ( ! isset( static::$instances[ $name ] ) ) {
			$class                      = static::AVAILABLE_OBSERVERS[ $name ];
			static::$instances[ $name ] = new Monitor( $name, new $class() );
		}

		return static::$instances[ $name ];

	}

	public static function initialize() {
		foreach ( self::AVAILABLE_OBSERVERS as $name => $class ) {
			self::get( $name )->initialize();
		}
	}

	public static function activate() {
		update_option( 'jetpack_inspect_monitoring_active', true );
		return self::status();
	}

	public static function deactivate() {
		update_option( 'jetpack_inspect_monitoring_active', false );
		return self::status();
	}

	public static function status() {
		return get_option( 'jetpack_inspect_monitoring_active' );
	}

	public static function toggle() {
		$status = static::status();
		if ( $status ) {
			return static::deactivate();
		}

		return static::activate();
	}

}
