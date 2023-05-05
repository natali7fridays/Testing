<?php
/**
 * Adapt Dev Theme setup
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

//phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

/**
 * Output the section heading
 *
 * @param string $asset The asset
 */
function adapt_dev_get_asset_path( $asset ) {
	$asset                = ltrim( $asset, '/' );
	static $manifest_file = null;

	if ( null === $manifest_file ) {
		$manifest_path = trailingslashit( ADAPT_DEV_THEME_DIR )
			. 'rev-manifest.json';

		$manifest_file = file_exists( $manifest_path ) ?
			json_decode( file_get_contents( $manifest_path ), true )
			: [];
	}

	if (
			array_key_exists( $asset, $manifest_file ) &&
			file_exists( ADAPT_DEV_THEME_DIR . '/dist/' . $manifest_file[ $asset ] )
		) {
		return '/dist/' . $manifest_file[ $asset ];
	}

	return '/dist/' . $asset;
}

if ( ! function_exists( 'adapt_dev_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function adapt_dev_setup() {
		/**
		 * Since WordPress 4.4
		 */
		add_theme_support( 'title-tag' );

		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on CC Base Theme, use a find and replace
		* to change 'adapt_dev' to the name of your theme in all the template files
		*/
		load_theme_textdomain( 'adapt_dev', ADAPT_DEV_THEME_DIR . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );
		add_image_size( '1600x300', 1600, 300, true );
		add_image_size( 'hero-bg', 1600 );
		add_image_size( 'postcard-bg', 500 );
		add_image_size( '1500', 1500 );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add theme support for block styles.
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		// Disable theme support for gradients.
		add_theme_support( 'disable-custom-gradients' );
		add_theme_support( 'editor-gradient-presets', array() );

		// Disable custom font sizes.
		add_theme_support( 'disable-custom-font-sizes' );

		// Editor Font Styles.
		add_theme_support(
			'editor-font-sizes',
			array(
			// array(
			// 'name'      => __( 'Small', 'adapt_dev' ),
			// 'shortName' => __( 'S', 'adapt_dev' ),
			// 'size'      => 12,
			// 'slug'      => 'small'
			// ).

			)
		);

		// Add CSS styles to the admin and visual editor.
		add_editor_style( ltrim( adapt_dev_get_asset_path( 'css/editor-style.css' ), '/' ) );

	}
endif;
// adapt_dev_setup.
add_action( 'after_setup_theme', 'adapt_dev_setup' );

if ( ! function_exists( 'adapt_dev_get_font_dir' ) ) :
	/**
	 * Get path to uploads directory where local fonts are unzipped.
	 * 
	 * If no font ID is specified, returns the base font directory.
	 * 
	 * $id int	Optional ID of the desired font.
	 */
	function adapt_dev_get_font_dir( $id=null ) {
		$wp_uploads = wp_get_upload_dir();

		$dir = path_join( $wp_uploads['basedir'], 'adaptdev-fonts' );

		if ( null !== $id ) {
			$dir = path_join(
				$dir,
				'font-' . $id
			);
		}

		return $dir;
	}
endif;