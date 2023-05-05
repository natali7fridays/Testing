<?php
/**
 * Hooks for Yoast SEO.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( ! function_exists( 'adapt_dev_yoast_meta_to_bottom' ) ) {
	/**
	 * Yoast meta to bottom
	 */
	function adapt_dev_yoast_meta_to_bottom() {
		return 'low';
	}
}
add_filter( 'wpseo_metabox_prio', 'adapt_dev_yoast_meta_to_bottom' );
