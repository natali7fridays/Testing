<?php
/**
 * Navigation theme component
 *
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components\Navigation;

use WP_Post;
use is_admin;
use register_nav_menus;
use __;

/**
 * Navigation component class
 *
 * Registers filters and scripts to enforce accessibility best practices.
 */
class Navigation {

	const DEFAULT_LOCATION = 'primary';
	const ALT_LOCATION     = 'secondary';
	const FOOTER_LOCATION  = 'footer';

	/**
	 * Add actions and filters
	 */
	public function init() {
		add_filter( 'nav_menu_link_attributes', [ $this, 'filter_nav_menu_link_attributes_aria_current' ], 10, 2 );
		add_filter( 'page_menu_link_attributes', [ $this, 'filter_nav_menu_link_attributes_aria_current' ], 10, 2 );
		add_action( 'init', [ $this, 'action_register_nav' ] );
	}

	/**
	 * Filter nav menu link attributes
	 *
	 * Adds an ARIA attribute for the current post/page.
	 *
	 * @param array   $atts The current link attributes.
	 * @param WP_Post $item The current post.
	 */
	public function filter_nav_menu_link_attributes_aria_current( array $atts, WP_Post $item ) : array {
		if ( isset( $item->current ) ) {
			if ( $item->current ) {
				$atts['aria-current'] = 'page';
			}
		} elseif ( ! empty( $item->ID ) ) {
			global $post;

			if ( ! empty( $post->ID ) && (int) $post->ID === (int) $item->ID ) {
				$atts['aria-current'] = 'page';
			}
		}

		return $atts;
	}

	/**
	 * Register primary navigation menu
	 */
	public function action_register_nav() {
		register_nav_menus(
			[
				$this::DEFAULT_LOCATION => __( 'Primary Menu', 'base_teami' ),
				$this::ALT_LOCATION     => __( 'Secondary Menu', 'base_teami' ),
				$this::FOOTER_LOCATION  => __( 'Footer Menu', 'base_teami' ),
			]
		);
	}
}
