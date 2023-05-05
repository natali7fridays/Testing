<?php
/**
 * SVG Component for icons related functions and filters
 *
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components\SVG;

use __;
use wp_parse_args;
use wp_get_nav_menu_object;
use esc_html;
use esc_attr;

/**
 * SVG Component class
 *
 * Registers filters and scripts to support adding svg icons
 */
class SVG {
	/**
	 * Add actions and filters
	 */
	public function init() {
		add_filter( 'walker_nav_menu_start_el', [ $this, 'adapt_dev_nav_menu_social_icons' ], 10, 4 );
		add_filter( 'nav_menu_item_title', [ $this, 'adapt_dev_dropdown_icon_to_menu_link' ], 10, 4 );
		add_action( 'wp_footer', [ $this, 'adapt_dev_include_svg_icons' ], 9999 );
		add_action( 'wp_print_footer_scripts', [ $this, 'action_print_script' ] );
	}

	/**
	 * Add SVG definitions to the footer.
	 */
	public static function adapt_dev_include_svg_icons() {
		// Define SVG sprite file.
		$svg_icons = get_theme_file_path( '/assets/img/svg-icons.svg' );

		// If it exists, include it.
		if ( file_exists( $svg_icons ) ) {
			require_once $svg_icons;
		}
	}

	/**
	 * Return SVG markup.
	 *
	 * @param array $args {
	 *     Parameters needed to display an SVG.
	 *
	 *     @type string $icon  Required SVG icon filename.
	 *     @type string $title Optional SVG title.
	 *     @type string $desc  Optional SVG description.
	 * }
	 * @return string SVG markup.
	 */
	public static function adapt_dev_get_svg( $args = array() ) {
		// Make sure $args are an array.
		if ( empty( $args ) ) {
			return __( 'Please define default parameters in the form of an array.', 'adapt_dev' );
		}

		// Define an icon.
		if ( false === array_key_exists( 'icon', $args ) ) {
			return __( 'Please define an SVG icon filename.', 'adapt_dev' );
		}

		// Set defaults.
		$defaults = array(
			'icon'        => '',
			'title'       => '',
			'desc'        => '',
			'fallback'    => false,
		);

		// Parse args.
		$args = wp_parse_args( $args, $defaults );

		// Set aria hidden.
		$aria_hidden = ' aria-hidden="true"';

		// Set ARIA.
		$aria_labelledby = '';

		/*
		* Twenty Seventeen doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
		*
		* However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
		*
		* Example 1 with title: <?php echo adapt_dev_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
		*
		* Example 2 with title and description: <?php echo adapt_dev_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
		*
		* See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
		*/
		if ( $args['title'] ) {
			$aria_hidden     = '';
			$unique_id       = uniqid();
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

			if ( $args['desc'] ) {
				$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
			}
		}

		// Begin SVG markup.
		$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

		// Display the title.
		if ( $args['title'] ) {
			$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

			// Display the desc only if the title is already set.
			if ( $args['desc'] ) {
				$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
			}
		}

		/*
		* Display the icon.
		*
		* The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
		*
		* See https://core.trac.wordpress.org/ticket/38387.
		*/
		$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';

		// Add some markup to use as a fallback for browsers that do not support SVGs.
		if ( $args['fallback'] ) {
			$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
		}

		$svg .= '</svg>';

		return $svg;
	}

	/**
	 * Display SVG icons in social links menu.
	 *
	 * @param  string  $item_output The menu item output.
	 * @param  WP_Post $item        Menu item object.
	 * @param  int     $depth       Depth of the menu.
	 * @param  array   $args        wp_nav_menu() arguments.
	 * @return string  $item_output The menu item output with social icon.
	 */
	public static function adapt_dev_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
		$menu_object      = wp_get_nav_menu_object( 'social-links-menu' );
		$made_replacement = false;
		if ( $menu_object ) {
			$social_menu_id = $menu_object->term_id;
			if ( is_object( $args->menu ) ) {
				$cur_obj  = $args->menu;
				$cur_menu = $cur_obj->term_id;
			} else {
				$cur_menu = $args->menu;
			}
			// Change SVG icon inside social links menu if there is supported URL.
			if ( $social_menu_id === $cur_menu ) {
				// Load the social icons.
				$social_icons     = self::adapt_dev_social_links_icons();
				$is_menu_assigned = $args->theme_location;
				$item_output      = str_replace( 'itemprop="url">', 'itemprop="url"><span class="screen-reader-text">', $item_output );
				$item_output      = str_replace( '</a>', '</span></a>', $item_output );
				foreach ( $social_icons as $attr => $value ) {
					if ( false !== strpos( $item_output, $attr ) ) {
						$made_replacement = true;
						if ( $is_menu_assigned ) {
							$item_output = str_replace( '</span></span>', '</span></span>' . self::adapt_dev_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
						} else {
							$item_output = str_replace( '</span>', '</span>' . self::adapt_dev_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
						}
					}
				}
				if ( ! $made_replacement ) {
					if ( $is_menu_assigned ) {
						$item_output = str_replace( '</span></span>', '</span></span>' . self::adapt_dev_get_svg( array( 'icon' => esc_attr( 'chain' ) ) ), $item_output );
					} else {
						$item_output = str_replace( '</span>', '</span>' . self::adapt_dev_get_svg( array( 'icon' => esc_attr( 'chain' ) ) ), $item_output );
					}
				}
			}
		}
		return $item_output;
	}

	/**
	 * Add dropdown icon if menu item has children.
	 *
	 * @param  string  $title The menu item's title.
	 * @param  WP_Post $item  The current menu item.
	 * @param  array   $args  An array of wp_nav_menu() arguments.
	 * @param  int     $depth Depth of menu item. Used for padding.
	 * @return string  $title The menu item's title with dropdown icon.
	 */
	public static function adapt_dev_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
		if ( 'primary' === $args->theme_location ) {
			foreach ( $item->classes as $value ) {
				if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
					$title = $title . self::adapt_dev_get_svg( array( 'icon' => 'angle-down' ) );
				}
			}
		}

		return $title;
	}

	/**
	 * Returns an array of supported social links (URL and icon name).
	 *
	 * @return array $social_links_icons
	 */
	public static function adapt_dev_social_links_icons() {
		// Supported social links icons.
		$social_links_icons = array(
			'behance.net'     => 'behance',
			'codepen.io'      => 'codepen',
			'deviantart.com'  => 'deviantart',
			'digg.com'        => 'digg',
			'docker.com'      => 'dockerhub',
			'dribbble.com'    => 'dribbble',
			'dropbox.com'     => 'dropbox',
			'facebook.com'    => 'facebook',
			'flickr.com'      => 'flickr',
			'foursquare.com'  => 'foursquare',
			'plus.google.com' => 'google-plus',
			'github.com'      => 'github',
			'instagram.com'   => 'instagram',
			'linkedin.com'    => 'linkedin',
			'mailto:'         => 'envelope-o',
			'medium.com'      => 'medium',
			'pinterest.com'   => 'pinterest-p',
			'pscp.tv'         => 'periscope',
			'getpocket.com'   => 'get-pocket',
			'reddit.com'      => 'reddit-alien',
			'skype.com'       => 'skype',
			'skype:'          => 'skype',
			'slideshare.net'  => 'slideshare',
			'snapchat.com'    => 'snapchat-ghost',
			'soundcloud.com'  => 'soundcloud',
			'spotify.com'     => 'spotify',
			'stumbleupon.com' => 'stumbleupon',
			'tumblr.com'      => 'tumblr',
			'twitch.tv'       => 'twitch',
			'twitter.com'     => 'twitter',
			'vimeo.com'       => 'vimeo',
			'vine.co'         => 'vine',
			'vk.com'          => 'vk',
			'wordpress.org'   => 'wordpress',
			'wordpress.com'   => 'wordpress',
			'yelp.com'        => 'yelp',
			'youtube.com'     => 'youtube',
		);

		/**
		 * Filter Twenty Seventeen social links icons.
		 *
		 * @since Twenty Seventeen 1.0
		 *
		 * @param array $social_links_icons Array of social links icons.
		 */
		return apply_filters( 'adapt_dev_social_links_icons', $social_links_icons );
	}

	/**
	 * Print component script at document body close
	 */
	public function action_print_script() {
		?>
		<script id="adapt_dev_SVG-js" async>
			<?php include get_theme_file_path( adapt_dev_get_asset_path( 'js/SVG.js' ) ); ?>
		</script>
		<?php
	}
}
