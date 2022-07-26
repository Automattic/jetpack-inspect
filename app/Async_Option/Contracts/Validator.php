<?php

namespace Automattic\Jetpack_Inspect\Async_Option\Contracts;

interface Validator {
	/**
	 * @param $value
	 *
	 * @return true on success
	 * @return string on failure
	 */
	public function validate( $value );
}
