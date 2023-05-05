<?php
/**
 * Actions
 *
 * A collection of functions hooked attached to WordPress action hooks.
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

if ( ! function_exists( 'adapt_dev_echo_doctype' ) ) :
	/**
	 * Outputs the document doctype declaration
	 *
	 * @return void
	 */
	function adapt_dev_echo_doctype() {
		echo '<!DOCTYPE html>';
	}
endif;
add_action( 'adapt_dev_html_before', 'adapt_dev_echo_doctype' );

if ( ! function_exists( 'adapt_dev_print_meta_tags' ) ) :
	/**
	 * Prints HTML metadata
	 *
	 * @return void
	 */
	function adapt_dev_print_meta_tags() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
		<!-- Use the .htaccess and remove these lines to avoid edge case issues. More info: h5bp.com/i/378 -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">

		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
		<?php
	}
endif;
add_action( 'adapt_dev_head_open', 'adapt_dev_print_meta_tags' );

if ( ! function_exists( 'adapt_dev_print_site_icons' ) ) :
	/**
	 * Prints site icon links
	 *
	 * @return void
	 */
	function adapt_dev_print_site_icon() {
		global $adapt_dev_config;

		$site_icon_option_id = $adapt_dev_config['site_icon'];

		$site_icon = $site_icon_option_id ? wp_get_attachment_image_src( $site_icon_option_id, [ 512, 512 ], true )[0] : esc_url( get_theme_file_uri( adapt_dev_get_asset_path( 'images/favicon.png' ) ) );

		printf( '<link rel="shortcut icon" href="%s">', $site_icon );//phpcs:ignore
	}
endif;
add_action( 'adapt_dev_head_close', 'adapt_dev_print_site_icon' );

if ( ! function_exists( 'adapt_dev_print_skiplink' ) ) :
	/**
	 * Adds a skiplink to main page content
	 *
	 * @return void
	 */
	function adapt_dev_print_skiplink() {
		printf( '<a class="skiplink sr-only" href="#content">%s</a>', esc_html__( 'Skip to content', 'adapt_dev' ) );
	}
endif;
add_action( 'adapt_dev_body_open', 'adapt_dev_print_skiplink' );

if ( ! function_exists( 'adapt_dev_the_gtm_tag' ) ) :
	/**
	 * If GTM is installed and active, echos the plugin output
	 *
	 * @return void
	 */
	function adapt_dev_the_gtm_tag() {
		if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) {
			gtm4wp_the_gtm_tag();
		}
	}
endif;
add_action( 'adapt_dev_body_open', 'adapt_dev_the_gtm_tag' );

if ( ! function_exists( 'adapt_dev_include_alert_banner' ) ) :
	/**
	 * If an alert banner is enabled, includes the banner template part
	 *
	 * @return void
	 */
	function adapt_dev_include_alert_banner() {
		if ( get_theme_mod( 'site_alert_banner_toggle' ) ) {
			get_template_part( 'template-parts', 'sitewide-banner' );
		}
	}
endif;
add_action( 'adapt_dev_header_top', 'adapt_dev_include_alert_banner' );


if ( ! function_exists( 'adapt_dev_print_flex_style' ) ) :
	/**
	 * Searches for and prints the current flex content layout stylesheet
	 *
	 * @return void
	 */
	function adapt_dev_print_flex_style() {
		if ( function_exists( 'get_row_layout' ) ) {
			$layout          = get_row_layout();
			$stylesheet_path = get_theme_file_path(
				adapt_dev_get_asset_path(
					sprintf(
						'css/flex/%s.css',
						$layout
					)
				)
			);
			
			if ( file_exists( $stylesheet_path ) ) {
				ob_start();
				include_once $stylesheet_path;
				$styles = ob_get_clean();
				if ( ! empty( $styles ) ) {
					printf( '<style id="flex-%s-css">', esc_attr( $layout ) );
					echo $styles;
					echo '</style>';
				}
			}
		}
	}
endif;
add_action( 'adapt_dev_flex_section_before', 'adapt_dev_print_flex_style' );

if ( ! function_exists( 'adapt_dev_echo_mobile_nav_toggle' ) ) :
	/**
	 * Print a button element to show/hide primary menu on mobile.
	 *
	 * @return void
	 */
	function adapt_dev_echo_mobile_nav_toggle() {
		printf(
			'<div class="site-header__mobile-action-btns"><button aria-label="%s" class="main-nav__toggle"><span class="main-nav__toggle-box"><span class="main-nav__toggle-box__inner"></span></span></button><div>',
			esc_attr__( 'Toggle Main Menu', 'adapt_dev' )
		);
	}
endif;
add_action( 'adapt_dev_header_bottom', 'adapt_dev_echo_mobile_nav_toggle' );

if ( ! function_exists( 'adapt_dev_print_template_stylesheet' ) ) :
	/**
	 * Print the page template stylesheet after the site header content.
	 */
	function adapt_dev_print_template_stylesheet() {
		global $template;
		$stylesheet_filename = preg_replace( '/.php$/', '.css', basename( $template ) );
		$stylesheet_path     = adapt_dev_get_asset_path( 'css/' . $stylesheet_filename );

		if ( file_exists( get_theme_file_path( $stylesheet_path ) ) ) {
			$handle = preg_replace( '/.php$/', '', basename( $template ) );
			wp_register_style(
				$handle,
				get_theme_file_uri( $stylesheet_path ),
				[],
				''
			);

			wp_print_styles( $handle );
		}
	}
endif;
add_action( 'adapt_dev_header_after', 'adapt_dev_print_template_stylesheet' );

if ( ! function_exists( 'adapt_dev_admin_menu_js' ) ) :
	/**
	 * Give if trying to add more than 5 menu items to secondary menu.
	 */
	function adapt_dev_admin_menu_js() {
		$screen = get_current_screen();
		if ( $screen->id != 'nav-menus' ) :
			return;
		endif;
		?>

		<script type="text/javascript">
			jQuery(function($){
				// run below code if the menu is set to secondary location
				if ( $('#locations-secondary').is(':checked') ) {
					let warn = false;

					$('#update-nav-menu').on('submit', function() {
						let num_menu = $('#menu-to-edit').children('.menu-item-depth-0').length;
						if ( num_menu > 5 ) {
							alert('Secondary Menu top level items are limited to 5! Please remove additional menu items and then you can save your menu.');
						return false;
						}
					});
				}
			})
		</script>
		<?php
	}
endif;
add_action( 'admin_footer', 'adapt_dev_admin_menu_js' );

if ( ! function_exists( 'adapt_dev_print_head_tracking_scripts' ) ) :
	/**
	 * Outputs scripts before close of head tag.
	 *
	 * @return void
	 */
	function adapt_dev_print_head_tracking_scripts() {
		global $adapt_dev_config;

		$adapt_dev_head_scripts = $adapt_dev_config['head_scripts'];
		if ( $adapt_dev_head_scripts ) {
			printf( '%s', $adapt_dev_head_scripts );//phpcs:ignore
		}
	}
endif;
add_action( 'adapt_dev_head_close', 'adapt_dev_print_head_tracking_scripts' );

if ( ! function_exists( 'adapt_dev_print_body_open_scripts' ) ) :
	/**
	 * Outputs scripts after opening of body tag.
	 *
	 * @return void
	 */
	function adapt_dev_print_body_open_scripts() {
		global $adapt_dev_config;

		$adapt_dev_body_open_scripts = $adapt_dev_config['body_open_scripts'];

		if ( $adapt_dev_body_open_scripts ) :
			printf( '%s', $adapt_dev_body_open_scripts );//phpcs:ignore
		endif;
	}
endif;
add_action( 'adapt_dev_body_open', 'adapt_dev_print_body_open_scripts' );

if ( ! function_exists( 'adapt_dev_print_body_close_scripts' ) ) :
	/**
	 * Outputs scripts before close of body tag.
	 *
	 * @return void
	 */
	function adapt_dev_print_body_close_scripts() {
		global $adapt_dev_config;

		$adapt_dev_body_close_scripts = $adapt_dev_config['body_close_scripts'];

		if ( $adapt_dev_body_close_scripts ) :
			printf( '%s', $adapt_dev_body_close_scripts );//phpcs:ignore
		endif;
	}
endif;
add_action( 'adapt_dev_body_close', 'adapt_dev_print_body_close_scripts' );
