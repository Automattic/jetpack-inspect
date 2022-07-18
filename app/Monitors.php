<?php

namespace Automattic\Jetpack_Inspect;

use Automattic\Jetpack_Inspect\Monitor\Inbound_REST_API;
use Automattic\Jetpack_Inspect\Monitor\Outbound_Request;

class Monitors {
	protected const AVAILABLE_OBSERVERS = [
		'outbound_request' => Outbound_Request::class,
		'inbound_rest_request'  => Inbound_REST_API::class,
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
}