<?php
/**
 * ACF Functions file
 * Useful for setting up ACF options page or adding ACF specific functions
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

// Theme Settings options page
if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		array(
			'page_title'    => 'Theme General Settings',
			'menu_title'    => 'Theme Settings',
			'menu_slug'     => 'theme-general-settings',
			'capability'    => 'edit_posts',
			'redirect'      => false,
		)
	);

}

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_sub_page(
		array(
			'page_title'     => 'Events Options',
			'menu_title'     => 'Events Options',
			'parent_slug'    => 'edit.php?post_type=tribe_events',
		)
	);
}

function adapt_dev_assert_attachment_ownership( $value ) {

	update_post_meta( $value, '_adaptdev_upload', 1 );

	return $value;

}
add_filter( 'acf/update_value/key=field_62988edca82a8', 'adapt_dev_assert_attachment_ownership' );