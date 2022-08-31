<?php

namespace Automattic\Jetpack\Package\Async_Option\Contracts;

interface Storage {

	public function get( $key );

	public function set( $key, $value );

	public function delete( $key );
}
