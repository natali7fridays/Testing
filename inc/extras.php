<?php
/**
 * Some Extra helper functions that might be useful.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Stop images getting wrapped up in p tags when they get dumped out with the_content() for easier theme styling
 *
 * @param string $content The content.
 */
function adapt_dev_remove_img_ptags( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}
add_filter( 'the_content', 'adapt_dev_remove_img_ptags' );

/**
 * Removes default a tag when adding new media
 */
function adapt_dev_imagelink_setup() {

	$image_set = get_option( 'image_default_link_type' );

	if ( $image_set !== 'none' ) {

		update_option( 'image_default_link_type', 'none' );
	}

}
add_action( 'admin_init', 'adapt_dev_imagelink_setup', 10 );

/**
 * Make an excerpt
 *
 * @param int $limit The number of words to be included in the excerpt.
 */
function adapt_dev_excerpt( $limit = 16 ) {
	echo wp_trim_words( get_the_excerpt(), apply_filters( 'adapt_dev_excerpt_length', $limit ), '...' ); //phpcs:ignore
}

/**
 * Starkers comments
 *
 * @param string $comment The comment.
 * @param mixed  $args The args.
 * @param mixed  $depth The depth.
 */
function adapt_dev_comment( $comment, $args, $depth ) {
	//phpcs:ignore
	$GLOBALS['comment'] = $comment;
	?>
	<?php if ( $comment->comment_approved === '1' ) : ?>
	<li>
		<article id="comment-<?php comment_ID(); ?>">
			<?php echo get_avatar( $comment ); ?>
			<h4><?php comment_author_link(); ?></h4>
			<time><a href="#comment-<?php comment_ID(); ?>" pubdate><?php comment_date(); ?> at <?php comment_time(); ?></a></time>
			<?php comment_text(); ?>
		</article>
		<?php
	endif;
}
/**
 * Output a Get Directions link from Google Maps
 *
 * @param array $address associative array containing address information
 * @return string href value for anchor tag that will bring user to exact location on google maps
 */
function adapt_dev_gmaps_directions( $address ) {
	$link = 'https://maps.google.com/?q=';
	return $link . $address['address_line_1'] . ',' . $address['city'] . ',' . $address['state'] . ' ' . $address['zip_code'];
}

/**
 * Creates custom video shortcode to use in lieu of wp_video_shortcode
 *
 * @param array  $atts array of video attributes
 * @param string $content variable require by wp_video_shortcode
 */
function adapt_dev_video_shortcode( $atts, $content = '' ) {

	foreach ( $atts as $att => $a ) :
		if ( is_array( $a ) ) :
			if ( $a[0] == 'yes' ) :
				$atts[ $att ] = true;
			else :
				$atts[ $att ] = false;
			endif;
		endif;
	endforeach;

	global $content_width;
	$post_id = get_post() ? get_the_ID() : 0;

	static $instance = 0;
	$instance++;

	/**
	 * Filters the default video shortcode output.
	 *
	 * If the filtered output isn't empty, it will be used instead of generating
	 * the default video template.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_video_shortcode()
	 *
	 * @param string $html     Empty variable to be replaced with shortcode markup.
	 * @param array  $attr     Attributes of the shortcode. @see wp_video_shortcode()
	 * @param string $content  Video shortcode content.
	 * @param int    $instance Unique numeric ID of this video shortcode instance.
	 */
	$override = apply_filters( 'wp_video_shortcode_override', '', $attr, $content, $instance );//phpcs:ignore

	if ( '' !== $override ) {
		return $override;
	}

	$video = null;

	$default_types = wp_get_video_extensions();
	$defaults_atts = array(
		'src'            => '',
		'poster'         => '',
		'loop'           => '',
		'autoplay'       => '',
		'preload'        => 'metadata',
		'width'          => 640,
		'height'         => 360,
		'class'          => 'wp-video-shortcode',
		'starting_frame' => '',
		'playsinline'    => '',
		'muted'          => '',
	);

	foreach ( $default_types as $type ) {
		$defaults_atts[ $type ] = '';
	}

	$atts = shortcode_atts( $defaults_atts, $atts, 'adapt_dev_video' );

	if ( is_admin() ) {
		// Shrink the video so it isn't huge in the admin.
		if ( $atts['width'] > $defaults_atts['width'] ) {
			$atts['height'] = round( ( $atts['height'] * $defaults_atts['width'] ) / $atts['width'] );
			$atts['width']  = $defaults_atts['width'];
		}
	} else {
		// If the video is bigger than the theme.
		if ( ! empty( $content_width ) && $atts['width'] > $content_width ) {
			$atts['height'] = round( ( $atts['height'] * $content_width ) / $atts['width'] );
			$atts['width']  = $content_width;
		}
	}

	$is_vimeo      = false;
	$is_youtube    = false;
	$yt_pattern    = '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#';
	$vimeo_pattern = '#^https?://(.+\.)?vimeo\.com/.*#';

	$primary = false;
	if ( ! empty( $atts['src'] ) ) {
		$is_vimeo   = ( preg_match( $vimeo_pattern, $atts['src'] ) );
		$is_youtube = ( preg_match( $yt_pattern, $atts['src'] ) );

		if ( ! $is_youtube && ! $is_vimeo ) {
			$type = wp_check_filetype( $atts['src'], wp_get_mime_types() );

			if ( ! in_array( strtolower( $type['ext'] ), $default_types, true ) ) {
				return sprintf( '<a class="wp-embedded-video" href="%s">%s</a>', esc_url( $atts['src'] ), esc_html( $atts['src'] ) );
			}
		}

		if ( $is_vimeo ) {
			wp_enqueue_script( 'mediaelement-vimeo' );
		}

		$primary = true;
		array_unshift( $default_types, 'src' );
	} else {
		foreach ( $default_types as $ext ) {
			if ( ! empty( $atts[ $ext ] ) ) {
				$type = wp_check_filetype( $atts[ $ext ], wp_get_mime_types() );
				if ( strtolower( $type['ext'] ) === $ext ) {
					$primary = true;
				}
			}
		}
	}

	if ( ! $primary ) {
		$videos = get_attached_media( 'video', $post_id );
		if ( empty( $videos ) ) {
			return;
		}

		$video       = reset( $videos );
		$atts['src'] = wp_get_attachment_url( $video->ID );
		if ( empty( $atts['src'] ) ) {
			return;
		}

		array_unshift( $default_types, 'src' );
	}

	/**
	 * Filters the media library used for the video shortcode.
	 *
	 * @since 3.6.0
	 *
	 * @param string $library Media library used for the video shortcode.
	 */
	$library = apply_filters( 'wp_video_shortcode_library', 'mediaelement' );//phpcs:ignore
	if ( 'mediaelement' === $library && did_action( 'init' ) ) {
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
		wp_enqueue_script( 'mediaelement-vimeo' );
	}

	// MediaElement.js has issues with some URL formats for Vimeo and YouTube,
	// so update the URL to prevent the ME.js player from breaking.
	if ( 'mediaelement' === $library ) {
		if ( $is_youtube ) {
			// Remove `feature` query arg and force SSL - see #40866.
			$atts['src'] = remove_query_arg( 'feature', $atts['src'] );
			$atts['src'] = set_url_scheme( $atts['src'], 'https' );
		} elseif ( $is_vimeo ) {
			// Remove all query arguments and force SSL - see #40866.
			$parsed_vimeo_url = wp_parse_url( $atts['src'] );
			$vimeo_src        = 'https://' . $parsed_vimeo_url['host'] . $parsed_vimeo_url['path'];

			// Add loop param for mejs bug - see #40977, not needed after #39686.
			$loop        = $atts['loop'] ? '1' : '0';
			$atts['src'] = add_query_arg( 'loop', $loop, $vimeo_src );
		}
	}

	/**
	 * Filters the class attribute for the video shortcode output container.
	 *
	 * @since 3.6.0
	 * @since 4.9.0 The `$atts` parameter was added.
	 *
	 * @param string $class CSS class or list of space-separated classes.
	 * @param array  $atts  Array of video shortcode attributes.
	 */
	$atts['class']  = apply_filters( 'wp_video_shortcode_class', $atts['class'], $atts );//phpcs:ignore
	$atts['poster'] = wp_get_attachment_image_src( $atts['poster'], 'large' );
	$atts['poster'] = $atts['poster'][0];

	$html_atts = array(
		'class'          => $atts['class'],
		'id'             => sprintf( 'video-%d-%d', $post_id, $instance ),
		'width'          => absint( $atts['width'] ),
		'height'         => absint( $atts['height'] ),
		'poster'         => $atts['poster'],
		'loop'           => $atts['loop'],
		'autoplay'       => $atts['autoplay'],
		'preload'        => $atts['preload'],
		'starting_frame' => $atts['starting_frame'],
		'playsinline'    => $atts['playsinline'],
		'muted'          => $atts['muted'],
	);

	// These ones should just be omitted altogether if they are blank.
	foreach ( array( 'poster', 'loop', 'autoplay', 'preload', 'playsinline', 'muted' ) as $a ) {
		if ( empty( $html_atts[ $a ] ) ) {
			unset( $html_atts[ $a ] );
		}
	}

	$attr_strings = array();
	foreach ( $html_atts as $k => $v ) {
		//phpcs:ignore
		if ( in_array( $k, array( 'loop', 'autoplay', 'playsinline', 'muted' ) ) ) :
			$attr_strings[] = $k . ' ';
		else :
			$attr_strings[] = $k . '="' . esc_attr( $v ) . '"';
		endif;
	}

	$html = '';

	if ( 'mediaelement' === $library && 1 === $instance ) {
		$html .= "<!--[if lt IE 9]><script>document.createElement('video');</script><![endif]-->\n";
	}

	$html .= sprintf( '<video %s controls="controls">', implode( ' ', $attr_strings ) );

	$fileurl = '';
	$source  = '<source type="%s" src="%s" />';

	foreach ( $default_types as $fallback ) {
		if ( ! empty( $atts[ $fallback ] ) ) {
			if ( empty( $fileurl ) ) {
				$fileurl = $atts[ $fallback ];
			}
			if ( 'src' === $fallback && $is_youtube ) {
				$type = array( 'type' => 'video/youtube' );
			} elseif ( 'src' === $fallback && $is_vimeo ) {
				$type = array( 'type' => 'video/vimeo' );
			} else {
				$type = wp_check_filetype( $atts[ $fallback ], wp_get_mime_types() );
			}
			$url = add_query_arg( '_', $instance, $atts[ $fallback ] );
			if ( $html_atts['starting_frame'] ) :
				$url .= '#t=' . $html_atts['starting_frame'];
			endif;
			$html .= sprintf( $source, $type['type'], esc_url( $url ) );
		}
	}

	if ( ! empty( $content ) ) {
		if ( false !== strpos( $content, "\n" ) ) {
			$content = str_replace( array( "\r\n", "\n", "\t" ), '', $content );
		}
		$html .= trim( $content );
	}

	if ( 'mediaelement' === $library ) {
		$html .= wp_mediaelement_fallback( $fileurl );
	}
	$html .= '</video>';

	$width_rule = '';
	if ( ! empty( $atts['width'] ) ) {
		$width_rule = sprintf( 'width: %dpx;', $atts['width'] );
	}
	$output = sprintf( '<div style="%s" class="wp-video">%s</div>', $width_rule, $html );

	/**
	 * Filters the output of the video shortcode.
	 *
	 * @since 3.6.0
	 *
	 * @param string $output  Video shortcode HTML output.
	 * @param array  $atts    Array of video shortcode attributes.
	 * @param string $video   Video file.
	 * @param int    $post_id Post ID.
	 * @param string $library Media library used for the video shortcode.
	 */
	return apply_filters( 'wp_video_shortcode', $output, $atts, $video, $post_id, $library );//phpcs:ignore
}
add_shortcode( 'adapt_dev_video', 'adapt_dev_video_shortcode', 1, 5 );

/**
 * Filters tiny mcs to remove the h1 option from the formatting dropdown.
 *
 * @param array $args The args.
 * @return array The filtered args.
 */
function adapt_dev_remove_h1_tiny_mce( $args ) {
	$args['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';
	return $args;
}
add_filter( 'tiny_mce_before_init', 'adapt_dev_remove_h1_tiny_mce' );

/**
 * Filters wp entry (wysiwyg) content to strip out h1 tags to help avoid accessability conflicts with the page title
 *
 * @param array $allowedposttags The post tags.
 * @return array The filtered post tags.
 */
function adapt_dev_disallow_h1_tags( $allowedposttags ) {
	// error_log( print_r( $allowedposttags, true ) );
	unset( $allowedposttags['h1'] );

	return $allowedposttags;
}
add_filter( 'wp_kses_allowed_html', 'adapt_dev_disallow_h1_tags' );

/**
 * Filters posts on aarchive.php/index.php if there is a category parameter in the URL
 *
 * @param WP_Query object $query The global WP_Query.
 */
function adapt_dev_filter_posts( $query ) {
	if ( ! is_admin() && $query->is_main_query() && isset( $_GET['category'] ) ) {//phpcs:ignore
		$query->set( 'category_name', $_GET['category'] );//phpcs:ignore
	}
}
add_action( 'pre_get_posts', 'adapt_dev_filter_posts' );

/**
 * Year shortcode using [year]
 */
function adapt_dev_year_shortcode() {
	$year = gmdate( 'Y' );
	return $year;
}
add_shortcode( 'year', 'adapt_dev_year_shortcode' );

/**
 * Hide comments if disabled for site
 */
if ( get_default_comment_status() !== 'open' ) :
	/** Remove from admin menu **/
	function adapt_dev_remove_admin_menus() {
		remove_menu_page( 'edit-comments.php' );
	}
	add_action( 'admin_menu', 'adapt_dev_remove_admin_menus' );

	/** Remove from posts and pages **/
	function adapt_dev_remove_comment_support() {
		remove_post_type_support( 'post', 'comments' );
		remove_post_type_support( 'page', 'comments' );
	}
	add_action( 'init', 'adapt_dev_remove_comment_support', 100 );

	/** Removes from admin bar **/
	function adapt_dev_admin_bar_render() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
	}
	add_action( 'wp_before_admin_bar_render', 'adapt_dev_admin_bar_render' );
endif;



/**
 * Disable the emoji's
 */
function adapt_dev_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// Remove from TinyMCE
	add_filter( 'tiny_mce_plugins', 'adapt_dev_disable_emojis_tinymce' );
}
add_action( 'init', 'adapt_dev_disable_emojis' );

/**
 * Filter out the tinymce emoji plugin.
 *
 * @param array $plugins The plugins
 */
function adapt_dev_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 *  Add body class for archive/blog/search to specify layout as list or grid.
 *
 *  @param array $classes = body classes array
 */
function adapt_dev_archive_layout_body_class( $classes ) {

	// if blog archive page
	if ( is_home() ) :
		$archive_layout = null;

		if ( function_exists( 'get_field' ) ) {
			$archive_layout = get_field( 'post_archive_layout', 'option' );
		}

		if ( $archive_layout ) :
			$classes[] = 'archive_' . $archive_layout;
		else :
			$classes[] = 'archive_list-view';
		endif;
	endif;

	// if general archive page or search results
	if ( is_archive() || is_search() ) :
		$classes[] = 'archive_list-view';
	endif;

	return $classes;
}
add_filter( 'body_class', 'adapt_dev_archive_layout_body_class' );
