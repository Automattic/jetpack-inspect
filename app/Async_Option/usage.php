<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

use Automattic\Jetpack_Inspect\Async_Option\Storage\WP_Option;
use Automattic\Jetpack_Inspect\Options\Monitor_Status;

//$registry = new Registry();

$monitor_status = new Async_Option('monitor-status');
$monitor_status
	->store( new WP_Option() )
	->handler( new Monitor_Status() );

$endpoint = new Endpoint( 'jetpack-inspect', $monitor_status );
add_action('rest_api_init', [$endpoint, 'register_rest_route']);

//$registry->add( $monitor_status );
