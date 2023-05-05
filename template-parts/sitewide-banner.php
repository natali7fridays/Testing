<?php
/**
 * Sitewide banner template
 *
 * Include this file in page and post templates where
 * content is rendered via ACF Flexible Content fields.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$alert_text = get_theme_mod( 'site_alert_banner' );
$alert_url  = get_theme_mod( 'site_alert_banner_link' );

/**
 * Add http to alert url
 *
 * @param string $alert_url The alery url
 */
function adapt_dev_addhttp( $alert_url ) {
	if ( ! preg_match( '~^(?:f|ht)tps?://~i', $alert_url ) ) {
		$alert_url = 'http://' . $alert_url;
	}
	return $alert_url;
}

if ( get_theme_mod( 'site_alert_banner_toggle' ) && ! empty( $alert_text ) ) :

	echo '<div id="adapt-dev-alert-banner" class="color-light bg-primary | adapt-dev-alert--banner">';

	if ( ! empty( $alert_url ) ) {
		echo '<a class="banner__link" href="' . wp_kses_post( addhttp( $alert_url ) ) . '">';
	}

	echo '<span class="banner__text">' . wp_kses_post( $alert_text ) . '</span>';
	if ( ! empty( $alert_url ) ) {
		echo '</a>';
	}

	echo '<button class="banner__close"><i class="fas fa-times"></i></button>';

	echo '</div>';

endif;
