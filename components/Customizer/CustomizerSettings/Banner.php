<?php
/**
 * Sitewide Banner Customizer Settings
 *
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components\Customizer\CustomizerSettings;

use AdaptDevBase\Components\Customizer\CustomizerSetting;
use AdaptDevBase\Components\Customizer\CustomizerControls\Toggle;

/**
 * Banner settings group Class
 */
class Banner extends CustomizerSetting {

	/**
	 * Toggle type
	 *
	 * @param stdClass $wp_customize The customizer object.
	 */
	public function action_customize_register( $wp_customize ) {
		/**
		 * Add alert toggle setting
		 *
		 * @link https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
		 */
		$wp_customize->add_setting(
			'site_alert_banner_toggle',
			[
				'default'    => '1',
				'capability' => 'manage_options',
				'transport'  => 'postMessage',
			]
		);

		/**
		 * Add toggle setting control
		 *
		 * @link https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
		 */
		$wp_customize->register_control_type( Toggle::class );
		$wp_customize->add_control(
			new Toggle(
				$wp_customize,
				'site_alert_banner_toggle',
				[
					'settings' => 'site_alert_banner_toggle',
					'label'    => __( 'Sitewide Banner Display', 'adapt_dev' ),
					'section'  => $this->section_id,
					'type'     => 'adapt_dev-toggle',
					'priority' => 1,
				]
			)
		);

		// Add alert banner text field
		$wp_customize->add_setting(
			'site_alert_banner',
			[
				'default' => 'This is an important announcement!',
			]
		);

		$wp_customize->add_control(
			'site_alert_banner',
			[
				'label'    => __( 'Sitewide Banner Text', 'adapt_dev' ),
				'section'  => $this->section_id, // section id
				'type'     => 'text',
				'priority' => 2,
			]
		);

		// Add alert banner link field
		$wp_customize->add_setting(
			'site_alert_banner_link',
			[
				'default' => '',
			]
		);

		$wp_customize->add_control(
			'site_alert_banner_link',
			[
				'label'    => __( 'Sitewide Banner URL', 'adapt_dev' ),
				'section'  => $this->section_id, // section id
				'type'     => 'text',
				'priority' => 3,
			]
		);
	}
}
