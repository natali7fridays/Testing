<?php
/**
 * File that handles loading and hooking of scripts and styles
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

// Ignoring some of the errors about versions and performance because we usually do better on our own.
//phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
//phpcs:disable Squiz.PHP.NonExecutableCode.Unreachable
//phpcs:disable WordPress.PHP.DisallowShortTernary.Found

global $async_scripts, $async_styles;
$async_scripts = array();//phpcs:ignore
$async_styles  = array();//phpcs:ignore

/**
 * Add scripts & styles to be loaded asynchronously
 *
 * @param string $handle  ID given to a script or style
 * @param string $type  What type of file is it? Defaults to "script". Other option is "style"
 */
function adapt_dev_add_async_scripts_and_styles( $handle, $type = 'script' ) {
	if ( $type == 'style' ) :
		global $async_styles;
		array_push( $async_styles, $handle );
	else :
		global $async_scripts;
		array_push( $async_scripts, $handle );
	endif;
}

/**
 * Enqueue global Adapt Dev scripts and styles
 * Register conditionals
 */
function adapt_dev_enqueue_styles_and_scripts() {
	// Load the stylesheets.
	global $adapt_dev_config;

	wp_register_style(
		'adapt_dev',
		get_theme_file_uri( adapt_dev_get_asset_path( 'css/style.css' ) ),
		[],
		'',
	);
	wp_enqueue_style( 'adapt_dev' );
	adapt_dev_add_async_scripts_and_styles( 'adapt_dev', 'style' );

	wp_register_script(
		'adapt_dev',
		get_theme_file_uri( adapt_dev_get_asset_path( 'js/main.js' ) ),
		[ 'jquery' ],
		'',
		true
	);
	adapt_dev_add_async_scripts_and_styles( 'adapt_dev' );
	wp_enqueue_script( 'adapt_dev' );

	// Load Font Awesome Pro
	wp_enqueue_script(
		'adapt_dev-fontawesome',
		'https://kit.fontawesome.com/0a48b11ed1.js',
		[],
		'',
		true
	);
	adapt_dev_add_async_scripts_and_styles( 'adapt_dev-fontawesome' );

	if ( is_archive() || is_home() ) :
		wp_register_style(
			'adapt_dev-archive',
			get_theme_file_uri( adapt_dev_get_asset_path( 'css/archive.css' ) ),
			[],
			false,
			'all' // Sets media attribute to defer, loads style async.
		);
		wp_enqueue_style( 'adapt_dev-archive' );
	endif;

	if ( is_search() ) :
		wp_register_style(
			'adapt_dev-search',
			get_theme_file_uri( adapt_dev_get_asset_path( 'css/search.css' ) ),
			[],
			false,
			'all' // Sets media attribute to defer, loads style async.
		);
		wp_enqueue_style( 'adapt_dev-search' );
	endif;

	/* AdaptDev Ajax Script file */
	wp_register_script(
		'adapt_dev-ajax',
		get_theme_file_uri( adapt_dev_get_asset_path( 'js/ajax.js' ) ),
		[ 'jquery' ],
		'',
		true
	);
	wp_script_add_data( 'adapt_dev', 'defer', true );
	wp_enqueue_script( 'adapt_dev-ajax' );

	$script_vars = [
		'ajax' => [
			'nonce' => wp_create_nonce( 'adapt_dev_ajax' ),
			'url'   => admin_url( 'admin-ajax.php' ),
		],
	];
	wp_localize_script( 'adapt_dev-ajax', 'adapt_dev', $script_vars );

	if ( is_single() ) {
		wp_register_style(
			'adapt_dev-single',
			get_theme_file_uri( adapt_dev_get_asset_path( 'css/single.css' ) ),
			[],
			false,
			'all' // Sets media attribute to defer, loads style async.
		);
		wp_enqueue_style( 'adapt_dev-single' );
	}

	// Enqueue Events CSS if on Events plugin page
	if ( is_archive() || is_single() ) {
		if ( 'tribe_events' == get_queried_object()->name || 'tribe_events' == get_post_type() ) {
			wp_register_style(
				'adapt_dev-events',
				get_theme_file_uri( adapt_dev_get_asset_path( 'css/events.css' ) ),
				[],
				false,
				'all'
			);
			wp_enqueue_style( 'adapt_dev-events' );
		}
	}

	// Widget Library template styles
	if ( is_page( 'widget-library' ) ) {

		wp_register_style(
			'adapt_dev-widget-library',
			get_theme_file_uri( adapt_dev_get_asset_path( 'css/widget-library-template.css' ) ),
			[],
			false,
			'all'
		);
		wp_enqueue_style( 'adapt_dev-widget-library' );

	}

	// Only load the gutenberg styles if we've said we need them.
	if ( ! ADAPT_DEV_USE_GUTENBERG ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS.
	}

	if ( wp_get_environment_type() != 'production' && $adapt_dev_config['debug_mode'] ) {
		wp_register_style(
			'adapt_dev_debug',
			get_theme_file_uri( adapt_dev_get_asset_path( 'css/debug.css' ) ),
			[],
			false,
			'all' // Sets media attribute to defer, loads style async.
		);
		wp_enqueue_style( 'adapt_dev_debug' );
	}
}
add_action( 'wp_enqueue_scripts', 'adapt_dev_enqueue_styles_and_scripts' );

if ( ! function_exists( 'adapt_dev_load_fonts' ) ) {
	/**
	 * Load the configured fonts
	 * Update according to fonts and font styles needed for this build.
	 */
	function adapt_dev_load_fonts() {
		global $adapt_dev_config;
		$font_options = $adapt_dev_config['font_options'];

		function filter_empty_rows( $repeater ) {
			if ( ! is_array( $repeater ) ) {
				return $repeater;
			}

			return array_filter(
				array_map(
					'array_filter',
					$repeater
				)
			);
		}

		$local_fonts = filter_empty_rows( $font_options['local_fonts'] );

		if ( empty( $local_fonts ) ) {
			/**
			 * Compatability wrapper.
			 */
			adapt_dev_google_font_fallback();
		} else {
			adapt_dev_load_local_fonts( $local_fonts );
		}
	}
}
add_action( 'wp_head', 'adapt_dev_load_fonts' );

if ( ! function_exists( 'adapt_dev_google_font_fallback' ) ) :
	/**
	 * Wraps deprecated automatic Google Font loading behavior in a function.
	 * 
	 * Should only be invoked if local or web fonts
	 * have not been configured in theme settings.
	 * 
	 * @return void
	 */
	function adapt_dev_google_font_fallback() {
		global $adapt_dev_config;

		$font_options = $adapt_dev_config['font_options'];
		$body_font = $font_options['font'] ?: 'Red Hat Display';
		$heading_font = $font_options['font_heading'] ?: 'Montserrat';

		$body_font_name_url    = str_replace( ' ', '+', $body_font );
		$heading_font_name_url = str_replace( ' ', '+', $heading_font );

		$fonts_url = '//fonts.googleapis.com/css2?family='
			. $body_font_name_url . ':ital,wght@0,100;0,200;0,300;0,400;0,700;0,800;0,900;1,400;1,700&family='
			. $heading_font_name_url . ':ital,wght@0,100;0,200;0,300;0,400;0,700;0,800;0,900;1,400;1,700&'
			. 'display=swap';
		?>
			<link rel="preconnect" href="//fonts.gstatic.com" crossorigin="">
			<link rel="preload" as="style" href="<?php echo esc_url_raw( $fonts_url ); ?>">
			<link rel="stylesheet" href="<?php echo esc_url_raw( $fonts_url ); ?>" media="print" onload="this.media='all'">

			<noscript>
				<link rel="stylesheet" media="all" href="<?php echo esc_url_raw( $fonts_url ); ?>">
			</noscript>
		<?php
	}
endif;


if ( ! function_exists( 'adapt_dev_print_user_theme_styles' ) ) {
	/**
	 * Theme colors from ACF settings page.
	 */
	function adapt_dev_print_user_theme_styles() {
		global $adapt_dev_config;

		$colors       = $adapt_dev_config['theme_colors'];
		$text_colors  = $adapt_dev_config['background_colors'];
		$font_options = $adapt_dev_config['font_options'];

		$font         = $font_options['font'] ?: 'Red Hat Display';
		$font_heading = $font_options['font_heading'] ?: 'Montserrat';

		$font_size_heading = $font_options['font_size_heading'] ?: '';

		$weight_body              = $font_options['weight_body'] ?: '400';
		$weight_h1                = $font_options['weight_h1'] ?: '700';
		$weight_h2                = $font_options['weight_h2'] ?: '700';
		$weight_h3                = $font_options['weight_h3'] ?: '700';
		$weight_h4                = $font_options['weight_h4'] ?: '700';
		$weight_h5                = $font_options['weight_h5'] ?: '700';
		$weight_h6                = $font_options['weight_h6'] ?: '700';
		$letter_spacing_uppercase = $font_options['letter_spacing_uppercase'] ?: '1.5px';

		$header_top_bar_border_color = $adapt_dev_config['header_top_bar_border_color'];

		$header_widget_colors = $adapt_dev_config['header_widget_colors'];

		$primary_nav_bg_color            = $adapt_dev_config['header_nav_bg_color'];
		$primary_nav_border_color        = $adapt_dev_config['header_nav_border_color'];
		$primary_nav_text_color          = $adapt_dev_config['header_nav_text_color'];
		$primary_nav_text_color_hover    = $adapt_dev_config['header_nav_text_color_hover'];
		$primary_nav_text_bg_color_hover = $adapt_dev_config['header_nav_text_bg_color_hover'];

		$primary_nav_text_casing = $adapt_dev_config['header_nav_text_casing'] ?: 'none';

		$page_title_bg_color   = $adapt_dev_config['page_title_bg_color'];
		$page_title_text_color = $adapt_dev_config['page_title_text_color'];

		$footer_top_bg_color   = $adapt_dev_config['footer_top_bg_color'];
		$footer_top_text_color = $adapt_dev_config['footer_top_text_color'];

		$footer_bottom_bg_color   = $adapt_dev_config['footer_bottom_bg_color'];
		$footer_bottom_text_color = $adapt_dev_config['footer_bottom_text_color'];

		$video_play_bg_color     = $adapt_dev_config['video_play_background_color'];
		$video_controls_bg_color = $adapt_dev_config['video_controls_background_color'];

		$sitewide_border_radius = $adapt_dev_config['sitewide_border_radius'];
		$button_border_radius   = $adapt_dev_config['button_border_radius'];

		if ( $colors ) {
			ob_start();
			?>
			<style>
				:root {
					--color-1: <?php echo esc_attr( $colors['color_1'] ?: '#0073E6' ); ?>;
					--color-2: <?php echo esc_attr( $colors['color_2'] ?: '#22518B' ); ?>;
					--color-3: <?php echo esc_attr( $colors['color_3'] ?: '#E9F6FF' ); ?>;

					--color-neutral-1: <?php echo esc_attr( $colors['neutral_1'] ?: '#F7F7F8' ); ?>;
					--color-neutral-2: <?php echo esc_attr( $colors['neutral_2'] ?: '#F0F0F0' ); ?>;
					--color-neutral-3: <?php echo esc_attr( $colors['neutral_3'] ?: '#cccccc' ); ?>;

					--text-color: <?php echo esc_attr( $colors['text'] ?: '#58595B' ); ?>;
					--heading-color: <?php echo esc_attr( $colors['heading'] ?: '#22518B' ); ?>;

					--font: "<?php echo esc_attr( $font ); ?>";
					--font-heading: "<?php echo esc_attr( $font_heading ); ?>";

					--font-size-h1: <?php echo esc_attr( $font_size_heading['h1'] ?: '65px' ); ?>;
					--font-size-h2: <?php echo esc_attr( $font_size_heading['h2'] ?: '45px' ); ?>;
					--font-size-h3: <?php echo esc_attr( $font_size_heading['h3'] ?: '30px' ); ?>;
					--font-size-h4: <?php echo esc_attr( $font_size_heading['h4'] ?: '24px' ); ?>;
					--font-size-h5: <?php echo esc_attr( $font_size_heading['h5'] ?: '16px' ); ?>;
					--font-size-h6: <?php echo esc_attr( $font_size_heading['h6'] ?: '16px' ); ?>;

					--text-transform-h1: <?php echo esc_attr( $font_size_heading['h1_text_transform'] ?: 'none' ); ?>;
					--text-transform-h2: <?php echo esc_attr( $font_size_heading['h2_text_transform'] ?: 'none' ); ?>;
					--text-transform-h3: <?php echo esc_attr( $font_size_heading['h3_text_transform'] ?: 'none' ); ?>;
					--text-transform-h4: <?php echo esc_attr( $font_size_heading['h4_text_transform'] ?: 'none' ); ?>;
					--text-transform-h5: <?php echo esc_attr( $font_size_heading['h5_text_transform'] ?: 'none' ); ?>;
					--text-transform-h6: <?php echo esc_attr( $font_size_heading['h6_text_transform'] ?: 'none' ); ?>;

					--font-size-base: 16px;
					--font-size-200: 12px;
					--font-size-300: 14px;
					--font-size-400: 16px;
					--font-size-500: 18px;
					--font-size-600: 20px;
					--font-size-700: 24px;
					--font-size-800: 32px;
					--font-size-900: 48px;

					--weight-body: <?php echo esc_attr( $weight_body ); ?>;
					--weight-h1: <?php echo esc_attr( $weight_h1 ); ?>;
					--weight-h2: <?php echo esc_attr( $weight_h2 ); ?>;
					--weight-h3: <?php echo esc_attr( $weight_h3 ); ?>;
					--weight-h4: <?php echo esc_attr( $weight_h4 ); ?>;
					--weight-h5: <?php echo esc_attr( $weight_h5 ); ?>;
					--weight-h6: <?php echo esc_attr( $weight_h6 ); ?>;

					--letter-spacing-uppercase: <?php echo esc_attr( $letter_spacing_uppercase ); ?>;

					--bg-color-text-color-1: <?php echo esc_attr( $text_colors['color_1'] ?: 'var(--text-color)' ); ?>;
					--bg-color-heading-color-1: <?php echo esc_attr( $text_colors['color_1_heading'] ?: 'var(--heading-color)' ); ?>;

					--bg-color-text-color-2: <?php echo esc_attr( $text_colors['color_2'] ?: 'var(--text-color)' ); ?>;
					--bg-color-heading-color-2: <?php echo esc_attr( $text_colors['color_2_heading'] ?: 'var(--heading-color)' ); ?>;

					--bg-color-text-color-3: <?php echo esc_attr( $text_colors['color_3'] ?: 'var(--text-color)' ); ?>;
					--bg-color-heading-color-3: <?php echo esc_attr( $text_colors['color_3_heading'] ?: 'var(--heading-color)' ); ?>;

					--header-top-bar-border-color: <?php echo esc_attr( $header_top_bar_border_color ?: '#f4f4f4' ); ?>;

					--header-widget-phone-number-color: <?php echo esc_attr( $header_widget_colors['phone_number_text'] ?: 'var(--color-2)' ); ?>;
					--header-widget-phone-icon-color: <?php echo esc_attr( $header_widget_colors['phone_icon_color'] ?: 'var(--color-1)' ); ?>;

					--primary-nav-bg-color: <?php echo esc_attr( $primary_nav_bg_color ?: '#F7F7F8' ); ?>;
					--primary-nav-border-color: <?php echo esc_attr( $primary_nav_border_color ?: '#F7F7F8' ); ?>;
					--primary-nav-text-color: <?php echo esc_attr( $primary_nav_text_color ?: '#58595B' ); ?>;
					--primary-nav-text-color-hover: <?php echo esc_attr( $primary_nav_text_color_hover ?: '#58595B' ); ?>;
					--primary-nav-text-bg-color-hover: <?php echo esc_attr( $primary_nav_text_bg_color_hover ?: '#58595B' ); ?>;

					--primary-nav-text-casing: <?php echo esc_attr( $primary_nav_text_casing ?: 'none' ); ?>;

					--page-title-bg-color: <?php echo esc_attr( $page_title_bg_color ?: 'none' ); ?>;
					--page-title-text-color: <?php echo esc_attr( $page_title_text_color ?: 'none' ); ?>;

					--footer-top-bg-color: <?php echo esc_attr( $footer_top_bg_color ?: '#FFFFFF' ); ?>;
					--footer-top-text-color: <?php echo esc_attr( $footer_top_text_color ?: '#58595B' ); ?>;

					--footer-bottom-bg-color: <?php echo esc_attr( $footer_bottom_bg_color ?: '#F0F0F0' ); ?>;
					--footer-bottom-text-color: <?php echo esc_attr( $footer_bottom_text_color ?: '#58595B' ); ?>;

					--video-play-bg-color: <?php echo esc_attr( $video_play_bg_color ?: '#222222' ); ?>;
					--video-controls-bg-color: <?php echo esc_attr( $video_controls_bg_color ?: '#222222' ); ?>;

					--sitewide-border-radius: <?php echo esc_attr( $sitewide_border_radius ?: '4px' ); ?>;
					--button-border-radius: <?php echo esc_attr( $button_border_radius ?: '4px' ); ?>;
				}
			</style>
			<?php
			$tag = ob_get_clean();
			echo $tag;//phpcs:ignore
		}
	}
}
add_action( 'wp_head', 'adapt_dev_print_user_theme_styles', 0 );
add_action( 'admin_footer', 'adapt_dev_print_user_theme_styles' );


if ( ! function_exists( 'adapt_dev_theme_editor_dynamic_styles' ) ) {
	/**
	 * Theme styles & css custom props for text editor.
	 */
	//phpcs:ignore
	function adapt_dev_theme_editor_dynamic_styles( $mce_init ) {
		global $adapt_dev_config;

		$colors       = $adapt_dev_config['theme_colors'];
		$font_options = $adapt_dev_config['font_options'];

		$color_1 = '--color-1: ' . $colors['color_1'] . ';';
		$color_2 = '--color-2: ' . $colors['color_2'] . ';';
		$color_3 = '--color-3: ' . $colors['color_3'] . ';';

		$neutral_1 = '--color-neutral-1: ' . $colors['neutral_1'] . ';';
		$neutral_2 = '--color-neutral-2: ' . $colors['neutral_2'] . ';';
		$neutral_3 = '--color-neutral-3: ' . $colors['neutral_3'] . ';';

		$color_vars = $color_1 . $color_2 . $color_3 . $neutral_1;

		$h1 = '--font-size-h1: ' . $font_options['font_size_heading']['h1'] . ';';
		$h2 = '--font-size-h2: ' . $font_options['font_size_heading']['h2'] . ';';
		$h3 = '--font-size-h3: ' . $font_options['font_size_heading']['h3'] . ';';
		$h4 = '--font-size-h4: ' . $font_options['font_size_heading']['h4'] . ';';
		$h5 = '--font-size-h5: ' . $font_options['font_size_heading']['h5'] . ';';
		$h6 = '--font-size-h6: ' . $font_options['font_size_heading']['h6'] . ';';

		$heading_sizes = $h1 . $h2 . $h3 . $h4 . $h5 . $h6;

		$styles = 'body.mce-content-body { ' . $color_vars . $heading_sizes . '}';
		if ( isset( $mce_init['content_style'] ) ) {
			$mce_init['content_style'] .= ' ' . $styles . ' ';
		} else {
			$mce_init['content_style'] = $styles . ' ';
		}
		return $mce_init;
	}
}
add_filter( 'tiny_mce_before_init', 'adapt_dev_theme_editor_dynamic_styles' );

/**
 * Print preloads for conditional scripts
 */
function adapt_dev_preload_styles() {
	// If we're using a flex layout and that layout has a hero image, let's preload that image.
	if ( function_exists( 'have_rows' ) ) {
		if ( have_rows( 'page-sections' ) ) {
			while ( have_rows( 'page-sections' ) ) {
				the_row();
				if ( get_row_layout() == 'hero' ) {
					if ( get_sub_field( 'image' ) ) {
						$image_url = wp_get_attachment_image_url( get_sub_field( 'image' ), 'large', false );
						echo '<link rel="preload" href="' . esc_attr( $image_url ) . '" as="image">';
					}
				}
			}
		}
	}
}
add_action( 'wp_head', 'adapt_dev_preload_styles' );

/**
 * Inline Critical css
 */
function adapt_dev_critical_styles() {
	$stylesheet_path = get_theme_file_path( adapt_dev_get_asset_path( 'css/critical.css' ) );
	if ( true === file_exists( $stylesheet_path ) ) {
		echo '<style type="text/css" id="adapt_dev-critical-css">';
		include_once $stylesheet_path;
		echo '</style>';
	}
}
add_action( 'wp_head', 'adapt_dev_critical_styles', 10 );

/**
 * Async all or some scripts
 *
 * @param string $url the url.
 * @param string $handle the hanlde of the script.
 */
function adapt_dev_defer_parsing_of_scripts( $url, $handle ) {
	if ( ADAPT_DEV_ASYNC_SCRIPTS ) {
		if ( is_user_logged_in() ) {
			return $url; // Don't break WP Admin.
		}
		if ( false === strpos( $url, '.js' ) ) {
			return $url;
		}
		if ( ! strpos( $url, 'aysnc' ) && ! strpos( $url, 'defer' ) ) {
			return str_replace( ' src', ' async src', $url );
		}
	} else {
		/* Only specific scripts are set to async */
		global $async_scripts;
		if ( is_user_logged_in() ) {
			return $url; // Don't break WP Admin.
		}
		if ( false === strpos( $url, '.js' ) ) {
			return $url;
		}
		//phpcs:ignore
		if ( in_array( $handle, $async_scripts ) ) {
			return str_replace( ' src', ' async src', $url );
		}
	}
	return $url;
}
add_filter( 'script_loader_tag', 'adapt_dev_defer_parsing_of_scripts', 10, 2 );

/**
 * Async all or some styles
 *
 * @param string $tag The tag.
 * @param string $handle the handle of the style.
 * @param string $href the href of the style.
 */
function adapt_dev_defer_parsing_of_styles( $tag, $handle, $href ) {
	/* All styles are set to async */
	if ( ADAPT_DEV_ASYNC_STYLES ) {
		if ( is_user_logged_in() ) {
			return $tag; // Don't break WP Admin.
		} else {
			/* Only specific scripts are set to async */
			global $async_styles;
			//phpcs:ignore
			if ( in_array( $handle, $async_styles ) ) {
				$tag = str_replace( "media='all'", "media='none' onload='if(media!=\"all\")media=\"all\";'", $tag );
				return $tag . '<noscript><link rel="stylesheet" href="' . $href . '"></noscript>';
			}

			return $tag;
		}
	}

	return $tag;
}
add_filter( 'style_loader_tag', 'adapt_dev_defer_parsing_of_styles', 10, 3 );

if ( ! function_exists( 'adapt_dev_load_local_fonts' ) ) :
	/**
	 * Extract font files and print styles for uploaded font families.
	 * 
	 * @param	array	$local_fonts	An array of file IDs.
	 * @return	void
	 */
	function adapt_dev_load_local_fonts( $local_fonts ) {
		if ( is_array( $local_fonts ) ) {
			foreach( $local_fonts as $font ) {
				$dir = adapt_dev_get_font_dir( $font['archive'] );

				$font_handle = basename( $dir );

				$stylesheets = glob( $dir . '**/*.css' );

				foreach( $stylesheets as $i => $stylesheet ) {
					$path_rel = ltrim( str_replace( ABSPATH, '', $stylesheet), '/' );
					$stylesheet_uri = implode( '/', array( get_site_url(), $path_rel ) );

					$handle = $font_handle . '-' . $i;

					wp_register_style(
						$handle,
						$stylesheet_uri
					);
					
					wp_print_styles( array( $handle ) );
				}
			}
		}
	}
endif;