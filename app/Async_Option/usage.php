<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Storage\WP_Option;
use Automattic\Jetpack_Inspect\Options\Monitor_Status;

//$registry = new Registry();

$monitor_status = new Async_Option('monitoring_active');
$monitor_status
	->store( new WP_Option() )
	->handler( new Monitor_Status() );

$endpoint = new Endpoint( 'jetpack-inspect', $monitor_status );
add_action('rest_api_init', [$endpoint, 'register_rest_route']);

//$registry->add( $monitor_status );

//Async_Option::setup( 'monitor-filter' )
//			->validate_with( 'is_string', "The 'name' parameter must be a string." )
//			->valid_values( Monitors::names() )
//			->sanitize_with( 'sanitize_text_field' )
//			->get_value_with( 'get_option' )
//			->set_value_with( 'update_option' )
//			->default( 'enabled' )
//			->on_save( 'strtolower' )
//			->on_get( 'strtolower' );
//
//Async_Option::setup(['remote_request_filter', 'remote_'])
//			->validate_with( 'is_string', "The 'name' parameter must be a string." )
//			->valid_values( Monitors::names() )
//			->sanitize_with( 'sanitize_text_field' )
//			->get_value_with( 'get_option' )
//			->set_value_with( 'update_option' )
//			->default( 'enabled' )
//			->on_save( 'strtolower' )
//			->on_get( 'strtolower' );
//
//Async_Option::setup('dismissed_notices')
//			->validate_with( 'is_array', "The 'dismissed_notices' parameter must be an array." )
//			->
//			->get_value_with( 'get_option' )
//			->set_value_with( 'update_option' )
//			->default( 'enabled' )
//			->on_save( 'strtolower' )
//			->on_get( 'strtolower' );
