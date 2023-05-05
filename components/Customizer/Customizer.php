<?php
/**
 * Customizer component class
 *
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components\Customizer;

use WP_Customize_Manager;
use AdaptDevBase\Components\Customizer\CustomizerSettings\Banner;

/**
 * Customizer base Class
 */
class Customizer {

	/**
	 * Constructor
	 */
	final public function __construct() {}

	public const DEFAULT_SECTION_ID = 'adapt_dev_options';

	/**
	 * Init function
	 */
	public function init() {
		add_action( 'customize_register', [ $this, 'action_customize_register' ] );

		$enabled_settings = [
			new Banner(),
		];

		foreach ( $enabled_settings as $setting ) {
			$setting->init();
		}
	}
	/**
	 * Register function
	 *
	 * @param WP_Customize_Manager $wp_customize The customzier object
	 */
	public function action_customize_register( WP_Customize_Manager $wp_customize ) {
		$wp_customize->add_section(
			$this::DEFAULT_SECTION_ID,
			[
				'title'    => __( 'Theme Options', 'adapt_dev' ),
				'priority' => 10,
			]
		);
	}
}
