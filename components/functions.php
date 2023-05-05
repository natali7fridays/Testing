<?php
/**
 * Component functions file
 *
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components;

use AdaptDevBase\Components\Navigation\Navigation;
use AdaptDevBase\Components\Lazy\Lazy;
use AdaptDevBase\Components\Customizer\Customizer;

/**
 * Initialize active components
 *
 * Returns one instance of the class Registry,
 * holding each of the initialized Components
 */
function init() {
	static $registry = null;

	if ( is_null( $registry ) ) {
		$registry = new Registry();

		$components = [
			new Navigation(),
			new Lazy(),
			new Customizer(),
		];

		foreach ( $components as $component ) {
			$registry->add( $component );
		}
	}

	return $registry;
}
