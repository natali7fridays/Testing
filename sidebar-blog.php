<?php
/**
 * Sidebar Blog Template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

wp_print_styles( array( 'adapt_dev-sidebar', 'adapt_dev-widgets' ) );

?>

<aside class="sidebar sidebar-right">
	<?php
	if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 'sidebar-blog' ) ) : //phpcs:ignore
	else : //phpcs:ignore
	endif;
	?>
</aside>
