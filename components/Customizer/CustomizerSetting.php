<?php
/**
 * Customizer setting abstract class
 *
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components\Customizer;

use AdaptDevBase\Components\Customizer\Customizer;
use WP_Customize_Manager;

/**
 * Customizer base Class
 */
abstract class CustomizerSetting {

	/**
	 * The section Id
	 *
	 * @var string $section_id Short docblock should contain a description.
	 */
	protected $section_id = '';
	/**
	 * The panel Id
	 *
	 * @var string $panel_id
	 */
	protected $panel_id = '';

	/**
	 * Action Custom Register
	 *
	 * @param WP_Customize_Manager $wp_customize The cusomizer object
	 */
	abstract public function action_customize_register( WP_Customize_Manager $wp_customize );

	/**
	 * Action Custom Register
	 */
	public function init() {
		if ( empty( $this->section_id ) ) {
			$this->section_id = Customizer::DEFAULT_SECTION_ID;
		}

		add_action( 'customize_register', [ $this, 'action_customize_register' ] );
	}
}
