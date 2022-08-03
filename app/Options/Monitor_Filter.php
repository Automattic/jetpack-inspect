<?php

namespace Automattic\Jetpack_Inspect\Options;

use Automattic\Jetpack_Inspect\Async_Option\Contracts\Sanitizer;

class Monitor_Filter implements Sanitizer {

	public function sanitize( $value ) {
		return sanitize_text_field( $value );
	}
}

