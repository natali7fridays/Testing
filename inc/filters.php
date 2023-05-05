<?php
/**
 * Filters
 *
 * A collection of WordPress filter functions.
 *
 * @package adaptdev/base
 * @since 3.0.0
 */

/**
 * Add filters to script and style loader src hooks
 * to remove version query parameters.
 *
 * @return void
 */
function adapt_dev_remove_query_strings() {
	if ( ! is_admin() ) {
		add_filter( 'script_loader_src', 'adapt_dev_remove_query_strings_split', 15 );
		add_filter( 'style_loader_src', 'adapt_dev_remove_query_strings_split', 15 );
	}
}

/**
 * Remove the version query parameter from a script or style src.
 *
 * @param string $src The URL of the static asset
 * @return string $output The URL minus the ver query parameter
 */
function adapt_dev_remove_query_strings_split( $src ) {
	$output = preg_split( '/(&ver|\?ver)/', $src );
	return $output[0];
}
add_action( 'init', 'adapt_dev_remove_query_strings' );

/**
 * Limit secondary menu area to 5 items
 *
 * @param array  $items top menu links
 * @param string $args args passed like menu location
 * @return array $items top level link items
 */
function adapt_dev_menufilter( $items, $args ) {
	// want our secondary menu to have MAX of 5 items
	if ( $args->theme_location == 'secondary' ) {
		$toplinks = 0;
		foreach ( $items as $k => $v ) {
			if ( $v->menu_item_parent == 0 ) {
				// count how many top-level links we have so far...
				$toplinks++;
			}
			// if we've passed our max # ...
			if ( $toplinks > 5 ) {
				unset( $items[ $k ] );
			}
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'adapt_dev_menufilter', 10, 2 );
 
function adapt_dev_hide_admin_uploads( $query ) {
    $user_id = get_current_user_id();

    if ( is_admin() && $user_id && false === current_user_can( 'manage_options' ) ) {
		$query['meta_query'][] = array(
			'key' => '_adaptdev_upload',
			'compare' => 'NOT EXISTS'
		);
	}

	return $query;
}
add_filter( 'ajax_query_attachments_args', 'adapt_dev_hide_admin_uploads' );