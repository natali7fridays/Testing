<?php
/**
 * Block Editor
 *
 * A collection of functions and hook ins to support theme styles in the gutenberg editor.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Remove block styles from the block editor
 */
function adapt_dev_gutenberg_scripts() {
	wp_enqueue_script( 'adapt_dev-editor', trailingslashit( ADAPT_DEV_SCRIPTS ) . 'custom-block-editor.js', array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'enqueue_block_editor_assets', 'adapt_dev_gutenberg_scripts' );


/**
 * Enqueque Goole fonts for the block editor
 */
function adapt_dev_block_editor_fonts() {
	wp_enqueue_style( 'adapt_dev-block-editor-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600;700&display=swap', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'enqueue_block_editor_assets', 'adapt_dev_block_editor_fonts' );

/** Adds support for editor color palette. */
add_theme_support(
	'editor-color-palette',
	array(
		array(
			'name'  => __( 'Adapt Dev Red/Pink', 'adapt_dev' ),
			'slug'  => 'red-pink',
			'color' => '#ec1e66',
		),
		array(
			'name'  => __( 'Dark Navy', 'adapt_dev' ),
			'slug'  => 'dark-navy',
			'color' => '#132b44',
		),
		array(
			'name'  => __( 'Sky Blue', 'adapt_dev' ),
			'slug'  => 'sky-blue',
			'color' => '#1ecbff',
		),
		array(
			'name'  => __( 'Team Green', 'adapt_dev' ),
			'slug'  => 'team-green',
			'color' => '#b7d348',
		),
		array(
			'name'  => __( 'Just Black', 'adapt_dev' ),
			'slug'  => 'just-black',
			'color' => '#22292F',
		),
		array(
			'name'  => __( 'Darkest Gray', 'adapt_dev' ),
			'slug'  => 'darkest-gray',
			'color' => '#3D4852',
		),
		array(
			'name'  => __( 'Dark Gray', 'adapt_dev' ),
			'slug'  => 'dark-gray',
			'color' => '#8795A1',
		),
		array(
			'name'  => __( 'Light Gray', 'adapt_dev' ),
			'slug'  => 'light-gray',
			'color' => '#DAE1E7',
		),
		array(
			'name'  => __( 'Lightest Gray', 'adapt_dev' ),
			'slug'  => 'lightest-gray',
			'color' => '#F8FAFC',
		),
		array(
			'name'  => __( 'Just White', 'adapt_dev' ),
			'slug'  => 'just-white',
			'color' => '#ffffff',
		),

	)
);

/**
 * Remove the custom color picker
 */
function adapt_dev_disable_custom_colors() {
	add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'adapt_dev_disable_custom_colors' );
