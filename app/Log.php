<?php

namespace Automattic\Jetpack_Inspect;

class Log {

	const POST_TYPE_NAME = 'jetpack_inspect_log';

	/**
	 * Static initialization.
	 */
	public static function register_post_type() {

		// Check if post type already registered.
		if ( post_type_exists( static::POST_TYPE_NAME ) ) {
			return;
		}

		register_post_type(
			static::POST_TYPE_NAME,
			array(
				'label'        => 'Jetpack Inspect Log',
				'description'  => 'Cache entries for the Jetpack Boost plugin.',
				// @TODO: WIP - set to false when UI is ready.
				'public'       => true,
				'show_in_rest' => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'jetpack_inspect_log' ),
			)
		);
	}


	public static function insert( $url, $data ) {
		$data_post_data = array(
			'post_type'    => static::POST_TYPE_NAME,
			'post_title'   => $url,
			'post_name'    => uniqid( "jetpack_inspect_log_", true ),
			'post_status'  => 'publish',
			'post_content' => json_encode( $data, JSON_PRETTY_PRINT ),
		);

		wp_insert_post( $data_post_data );
	}

	public static function clear() {
		global $wpdb;

		return $wpdb->delete(
			$wpdb->posts,
			array( 'post_type' => static::POST_TYPE_NAME ),
			array( '%s' )
		);
	}
}