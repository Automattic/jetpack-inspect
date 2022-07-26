<?php

namespace Automattic\Jetpack_Inspect\Async_Option\Contracts;

interface Sanitizer {
	public function sanitize( $value );
}
