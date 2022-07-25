<?php

namespace Automattic\Jetpack_Inspect\Async_Option;

Async_Option::setup( 'monitor-status' )
            ->validate_with( 'is_string', "The 'name' parameter must be a string." )
            ->valid_values( Monitors::names() )
            ->sanitize_with( 'sanitize_text_field' )
            ->get_value_with( 'get_option' )
            ->set_value_with( 'update_option' )
            ->default( 'enabled' )
            ->on_save( 'strtolower' )
            ->on_get( 'strtolower' );


Async_Option::setup( 'monitor-filter' )
			->validate_with( 'is_string', "The 'name' parameter must be a string." )
			->valid_values( Monitors::names() )
			->sanitize_with( 'sanitize_text_field' )
			->get_value_with( 'get_option' )
			->set_value_with( 'update_option' )
			->default( 'enabled' )
			->on_save( 'strtolower' )
			->on_get( 'strtolower' );

Async_Option::setup(['remote_request_filter', 'remote_'])
			->validate_with( 'is_string', "The 'name' parameter must be a string." )
			->valid_values( Monitors::names() )
			->sanitize_with( 'sanitize_text_field' )
			->get_value_with( 'get_option' )
			->set_value_with( 'update_option' )
			->default( 'enabled' )
			->on_save( 'strtolower' )
			->on_get( 'strtolower' );

Async_Option::setup('dismissed_notices')
			->validate_with( 'is_array', "The 'dismissed_notices' parameter must be an array." )
			->
			->get_value_with( 'get_option' )
			->set_value_with( 'update_option' )
			->default( 'enabled' )
			->on_save( 'strtolower' )
			->on_get( 'strtolower' );