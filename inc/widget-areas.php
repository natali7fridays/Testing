<?php
/**
 * Register Widget Areas
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Initialize theme widgets
 */
function adapt_dev_widgets_init() {

	// register_sidebar(
	// array(
	// 'name'          => 'Sidebar Default',
	// 'id'            => 'sidebar-1',
	// 'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	// 'after_widget'  => '</div>',
	// 'before_title'  => '<div class="widget-title">',
	// 'after_title'   => '</div>',
	// )
	// );

	// register_sidebar(
	// array(
	// 'name'          => 'Blog Sidebar',
	// 'id'            => 'sidebar-blog',
	// 'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
	// 'after_widget'  => '</div>',
	// 'before_title'  => '<div class="widget-title">',
	// 'after_title'   => '</div>',
	// )
	// );

	register_sidebar(
		array(
			'name'          => 'Footer Area 1',
			'id'            => 'footer-area-1',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title">',
			'after_title'   => '</div>',
		)
	);

	register_sidebar(
		array(
			'name'          => 'Footer Area 2',
			'id'            => 'footer-area-2',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title">',
			'after_title'   => '</div>',
		)
	);

	register_sidebar(
		array(
			'name'          => 'Footer Area 3',
			'id'            => 'footer-area-3',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title">',
			'after_title'   => '</div>',
		)
	);

	register_sidebar(
		array(
			'name'          => 'Footer Area 4',
			'id'            => 'footer-area-4',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title">',
			'after_title'   => '</div>',
		)
	);
}
add_action( 'widgets_init', 'adapt_dev_widgets_init' );

/**
 * Unregister default widgets.
 */
function adapt_dev_unregister_default_widgets() {
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
}
add_action( 'widgets_init', 'adapt_dev_unregister_default_widgets', 11 );
