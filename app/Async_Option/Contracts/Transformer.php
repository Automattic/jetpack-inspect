<?php

namespace Automattic\Jetpack_Inspect\Async_Option\Contracts;

/**
 * Classes that implement Transformer will
 * change the value when it is returned.
 *
 * Useful when you want to store a key and return
 * a value that's dynamically populated.
 */
interface Transformer {
	public function transform( $value );
}
