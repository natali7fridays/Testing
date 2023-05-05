<?php
/**
 * Define the global vars that can be used in various frontend templates
 *
 * @package adaptdev/base
 * @since 3.0.0
 */

//phpcs:disable WordPress.PHP.DisallowShortTernary.Found

$adapt_dev_config = array();

/**
 * Define the global vars that can be used in various frontend templates
 * Also provide filters so child temes can modify these values
 */
function adapt_dev_define_global_vars() {
	global $adapt_dev_config;

	if ( false === function_exists( 'get_field' ) ) {
		return array();
	}

	$adapt_dev_config_global = array(
		'phone'                               => get_field( 'phone', 'options' ),
		'email'                               => get_field( 'email', 'options' ),
		'facebook_url'                        => get_field( 'facebook_url', 'options' ),
		'twitter_url'                         => get_field( 'twitter_url', 'options' ),
		'instagram_url'                       => get_field( 'instagram_url', 'options' ),
		'linkedin_url'                        => get_field( 'linkedin_url', 'options' ),
		'youtube_url'                         => get_field( 'youtube_url', 'options' ),

		'address_1'                           => get_field( 'address_1', 'options' ),
		'address_2'                           => get_field( 'address_2', 'options' ),
		'city'                                => get_field( 'city', 'options' ),
		'state'                               => get_field( 'state', 'options' ),
		'zip'                                 => get_field( 'zip', 'options' ),

		'header_top_bar_display'              => get_field( 'header_top_bar_display', 'options' ),
		'header_top_bar_content'              => get_field( 'header_top_bar_content', 'options' ),
		'header_top_bar_text'                 => get_field( 'header_top_bar_text', 'options' ),
		'header_top_bar_phone'                => get_field( 'header_top_bar_phone', 'options' ),
		'header_layout'                       => get_field( 'header_layout', 'options' ),
		'header_primary_nav'                  => get_field( 'header_primary_nav', 'options' ),
		'header_nav_text_casing'              => get_field( 'header_nav_text_casing', 'options' ),
		'header_search_primary_menu_toggle'   => get_field( 'header_search_primary_menu_toggle', 'options' ),
		'header_search_secondary_menu_toggle' => get_field( 'header_search_secondary_menu_toggle', 'options' ),
		'header_nav_alignment'                => get_field( 'header_nav_alignment', 'options' ),
		'header_nav_bg_color'                 => get_field( 'header_nav_bg_color', 'options' ),
		'header_widget_type'                  => get_field( 'header_widget_type', 'options' ),
		'header_cta_button'                   => get_field( 'header_cta_button', 'options' ),
		'header_phone'                        => get_field( 'header_phone', 'options' ),
		'header_widget_text'                  => get_field( 'header_widget_text', 'options' ),
		'header_menu'                         => get_field( 'header_menu', 'options' ) ?: '',

		'sub_footer_links'                    => get_field( 'sub_footer_links', 'options' ),
		'sub_footer_social_icons_toggle'      => get_field( 'sub_footer_social_icons_toggle', 'options' ),
		'footer_bottom_toggle'                => get_field( 'footer_bottom_toggle', 'options' ),
		'footer_widgets_center_widgets'       => get_field( 'footer_widgets_center_widgets', 'options' ),
		'footer_widget_areas'                 => get_field( 'header_menu', 'options' ) ?: array( 'footer-area-1', 'footer-area-2', 'footer-area-3', 'footer-area-4' ),

		'header_logo'                         => get_field( 'header_logo', 'options' ),
		'footer_logo'                         => get_field( 'footer_logo', 'options' ),
		'site_icon'                           => get_field( 'site_icon', 'options' ),

		'404_headline'                        => get_field( '404_headline', 'options' ),
		'404_message'                         => get_field( '404_message', 'options' ),
		'404_show_sitemap'                    => get_field( '404_show_sitemap', 'options' ),
		'sitemap_excluded_pages'              => get_field( 'sitemap_excluded_pages', 'options' ),

		'theme_colors'                        => get_field( 'theme_colors', 'options' ),
		'font_options'                        => get_field( 'font_options', 'options' ),
		'background_colors'                   => get_field( 'background_colors', 'options' ),

		'header_top_bar_border_color'         => get_field( 'header_top_bar_border_color', 'options' ),
		'header_widget_colors'                => get_field( 'header_widget_colors', 'options' ),
		'header_nav_bg_color'                 => get_field( 'header_nav_bg_color', 'options' ),
		'header_nav_border_color'             => get_field( 'header_nav_border_color', 'options' ),
		'header_nav_text_color'               => get_field( 'header_nav_text_color', 'options' ),
		'header_nav_text_color_hover'         => get_field( 'header_nav_text_color_hover', 'options' ),
		'header_nav_text_bg_color_hover'      => get_field( 'header_nav_text_bg_color_hover', 'options' ),

		'page_title_bg_color'                 => get_field( 'page_title_bg_color', 'options' ),
		'page_title_text_color'               => get_field( 'page_title_text_color', 'options' ),

		'footer_top_bg_color'                 => get_field( 'footer_top_bg_color', 'options' ),
		'footer_top_text_color'               => get_field( 'footer_top_text_color', 'options' ),
		'footer_bottom_bg_color'              => get_field( 'footer_bottom_bg_color', 'options' ),
		'footer_bottom_text_color'            => get_field( 'footer_bottom_text_color', 'options' ),

		'video_play_background_color'         => get_field( 'video_play_background_color', 'options' ),
		'video_controls_background_color'     => get_field( 'video_controls_background_color', 'options' ),

		'sitewide_border_radius'              => get_field( 'sitewide_border_radius', 'options' ),
		'button_border_radius'                => get_field( 'button_border_radius', 'options' ),

		'head_scripts'                        => get_field( 'head_scripts', 'options' ),
		'body_open_scripts'                   => get_field( 'body_open_scripts', 'options' ),
		'body_close_scripts'                  => get_field( 'body_close_scripts', 'options' ),

		'debug_mode'                          => get_field( 'debug_mode', 'options' ),
	);

	$adapt_dev_config = apply_filters( 'adapt_dev_config', $adapt_dev_config_global );
}
add_action( 'wp', 'adapt_dev_define_global_vars', 1 );
add_action( 'admin_init', 'adapt_dev_define_global_vars', 1 );

