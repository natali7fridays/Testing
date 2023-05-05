<?php
/**
 * Registry class definition
 *
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components;

/**
 * Registry of individual components
 *
 * Provides access to initialized components
 * via get_components
 */
class Registry {

	/**
	 * Registered components
	 *
	 * @var array $components All components added to the registry.
	 */
	private $components = [];

	/**
	 * Add a component to the registry
	 *
	 * Each component is added once, using its class name as an array key.
	 *
	 * @param object $component A theme component to add and initialize.
	 */
	public function add( $component ) : self {
		if ( ! isset( $this->components[ get_class( $component ) ] ) ) {
			$component->init();
			$this->components[ get_class( $component ) ] = $component;
		}

		return $this;
	}

	/**
	 * Remove a component from the registry
	 *
	 * @param object $component A theme component to remove and de-activate.
	 */
	public function remove( $component ) : self {
		unset( $this->components[ get_class( $component ) ] );

		return $this;
	}

	/**
	 * Get all registered components
	 *
	 * @return array All currently registered components.
	 */
	public function get_components() : array {
		return $this->getComponents();
	}
}
