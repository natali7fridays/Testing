<?php
/**
 * Theme functions
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

// Define constants.
define( 'ADAPT_DEV_THEME_URI', get_template_directory_uri() );
define( 'ADAPT_DEV_IMAGES', ADAPT_DEV_THEME_URI . '/dist/images' );
define( 'ADAPT_DEV_SCRIPTS', ADAPT_DEV_THEME_URI . '/dist/js' );
define( 'ADAPT_DEV_STYLES', ADAPT_DEV_THEME_URI . '/dist/css' );
define( 'ADAPT_DEV_THEME_DIR', get_template_directory() );
define( 'ADAPT_DEV_CRITICAL_CSS', false );
define( 'ADAPT_DEV_USE_GUTENBERG', false );
define( 'ADAPT_DEV_ASYNC_SCRIPTS', false );
define( 'ADAPT_DEV_ASYNC_STYLES', false );

// Theme setup.
require_once ADAPT_DEV_THEME_DIR . '/inc/theme-setup.php';

if ( ADAPT_DEV_USE_GUTENBERG ) {
	// include block editor settings.
	require_once ADAPT_DEV_THEME_DIR . '/inc/block-editor.php';
} else {
	add_filter( 'use_block_editor_for_post', '__return_false' );
}

// include scripts-styles.
require_once ADAPT_DEV_THEME_DIR . '/inc/scripts-styles.php';

// include widget areas.
require_once ADAPT_DEV_THEME_DIR . '/inc/widget-areas.php';

// include extras.
require_once ADAPT_DEV_THEME_DIR . '/inc/extras.php';

// include template-tags.
require_once ADAPT_DEV_THEME_DIR . '/inc/template-tags.php';

// include acf-functions
require_once ADAPT_DEV_THEME_DIR . '/inc/acf-functions.php';

// include acf widgets
require_once ADAPT_DEV_THEME_DIR . '/inc/acf-wp-widget.php';

// Include action hooks
require_once ADAPT_DEV_THEME_DIR . '/inc/actions.php';

// Include filter hooks
require_once ADAPT_DEV_THEME_DIR . '/inc/filters.php';

// Include global vars
require_once ADAPT_DEV_THEME_DIR . '/inc/globals.php';

// include custom content types.
require_once ADAPT_DEV_THEME_DIR . '/inc/cpts.php';

// include theme component classes.
require_once ADAPT_DEV_THEME_DIR . '/components/bootstrap.php';

// include customizations to the admin.
require_once ADAPT_DEV_THEME_DIR . '/inc/admin.php';

// include custom breadcrumbs
// require_once get_template_directory() . '/inc/breadcrumbs.php';

// include custom 'Add Button' button
require_once get_template_directory() . '/inc/post-editor.php';

// include ajax related code
require_once ADAPT_DEV_THEME_DIR . '/inc/ajax.php';

// include all plugin hooks files
foreach ( glob( ADAPT_DEV_THEME_DIR . '/inc/plugin-hooks/*.php' ) as $filename ) {
	require_once $filename;
}

