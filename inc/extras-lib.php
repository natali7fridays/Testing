<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function adapt_dev_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'adapt_dev_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function adapt_dev_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'adapt_dev_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function adapt_dev_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		// translators: %s is the current page.
		$title .= " $sep " . sprintf( __( 'Page %s', 'adapt_dev' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'adapt_dev_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function adapt_dev_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author ); //phpcs:ignore
	}
}
add_action( 'wp', 'adapt_dev_setup_author' );

/*
// Allow HTML tags in Widget title.
function html_widget_title( $var) {
$var = (str_replace( '[', '<', $var ));
$var = (str_replace( ']', '>', $var ));
return $var ;

}
add_filter( 'widget_title', 'html_widget_title' );

// allow html in widget titles.
add_filter('widget_title', 'do_shortcode');

add_shortcode('br', 'wpse_shortcode_br');
function wpse_shortcode_br( $attr ){ return '<br />'; }

add_shortcode('span', 'wpse_shortcode_span');
function wpse_shortcode_span( $attr, $content ){ return '<span>'. $content . '</span>'; }

add_shortcode('anchor', 'wpse_shortcode_anchor');
function wpse_shortcode_anchor( $attr, $content ){
return '<a href="'. ( isset($attr['url']) ? $attr['url'] : '' ) .'">'. $content . '</a>';
}
*/
