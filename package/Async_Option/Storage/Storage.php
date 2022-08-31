<?php

namespace Automattic\Jetpack\Package\Async_Option\Storage;

interface Storage {

	public function get( $key );

	public function set( $key, $value );

	public function delete( $key );
}
