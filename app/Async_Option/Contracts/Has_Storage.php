<?php

namespace Automattic\Jetpack_Inspect\Async_Option\Contracts;

interface Has_Storage {

	/**
	 * Setup Storage object with the specified key,
	 *
	 * @param $key string
	 *
	 * @return Storage
	 */
	public function setup_storage( $key );
}
