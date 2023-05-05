<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( ! function_exists( 'adapt_dev_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @param string $base THe base of the paging request
	 */
	function adapt_dev_paging_nav( $base = null ) {
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = ( isset( $base ) ) ? trailingslashit( $base ) : html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		} elseif ( isset( $_GET['category'] ) ) {//phpcs:ignore
			wp_parse_str( 'category=' . $_GET['category'], $query_args );//phpcs:ignore
		} elseif ( get_query_var( 'category_name' ) !== '' ) {
			wp_parse_str( 'category=' . get_query_var( 'category_name' ), $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $GLOBALS['wp_query']->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 2,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '←', 'adapt_dev' ),
				'next_text' => __( '→', 'adapt_dev' ),
				'type'      => 'list',
			)
		);

		if ( $links ) :
			?>
			<nav class="navigation paging-navigation clearfix guttered centered mv-5" role="navigation">
				<h1 class="sr-only"><?php esc_html_e( 'Posts navigation', 'adapt_dev' ); ?></h1>
						<?php echo wp_kses_post( $links, 'adapt_dev' );  //phpcs:ignore?>
			</nav><!-- .navigation -->
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'adapt_dev_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function adapt_dev_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
	<nav class="navigation post-navigation clearfix" role="navigation">
		<h1 class="sr-only"><?php esc_html_e( 'Post navigation', 'adapt_dev' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="previous-step">%link</div>', _x( '&lt; Prev', 'Previous post link', 'adapt_dev' ) );
				next_post_link( '<div class="next-step">%link</div>', _x( 'Next &gt;', 'Next post link', 'adapt_dev' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
		<?php
	}
endif;

if ( ! function_exists( 'adapt_dev_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function adapt_dev_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		//phpcs:disable
		// translators: %s is the posted time html.
		$posted_on = sprintf(
			_x( 'Posted on %s', 'post date', 'adapt_dev' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		// translators: %s is the author html.
		$byline = sprintf(
			_x( 'by %s', 'post author', 'adapt_dev' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);
		//phpcs:enable

		echo '<span class="posted-on">' . esc_html_e( $posted_on ) . '</span><span class="byline"> ' . esc_html_e( $byline ) . '</span>';

	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function adapt_dev_categorized_blog() {
	$all_the_cool_cats = get_transient( 'adapt_dev_categories' );

	if ( false === ( $all_the_cool_cats ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'adapt_dev_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so adapt_dev_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so adapt_dev_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in adapt_dev_categorized_blog.
 */
function adapt_dev_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'adapt_dev_categories' );
}
add_action( 'edit_category', 'adapt_dev_category_transient_flusher' );
add_action( 'save_post', 'adapt_dev_category_transient_flusher' );

if ( ! function_exists( 'adapt_dev_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function adapt_dev_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			the_post_thumbnail(
				'post-thumbnail',
				array(
					'alt' => the_title_attribute(
						array(
							'echo' => false,
						)
					),
				)
			);
			?>
		</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'adapt_dev_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function adapt_dev_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'adapt_dev' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'adapt_dev' ) . '</span>', $categories_list ); //phpcs:ignore
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'adapt_dev' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'adapt_dev' ) . '</span>', $tags_list ); //phpcs:ignore
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="sr-only"> on %s</span>', 'adapt_dev' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="sr-only">%s</span>', 'adapt_dev' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'adapt_dev_the_button' ) ) :

	/**
	 * Output an anchor tag with button styles
	 *
	 * Expects an array of fields from the Button acf field group
	 * and a string of the classes to be applied to the anchor tag.
	 *
	 * @param array  $acf_link_group  The ACF button field group.
	 * @param string $class_names     Additional classes to be applied to the link.
	 * @param bool   $close           If set to true, this will output a complete anchor tag. If set to false, this will output an open anchor tag.
	 */
	function adapt_dev_the_button( $acf_link_group = [], $class_names = [], $close = true ) {
		[
			'button_type'  => $type,
			'button_link'  => $link,
			'button_file'   => $file,
			'button_download_file' => $file_download,
			'button_label' => $file_label,
			'button_style'   => $style,
			'button_color'   => $color
		] = $acf_link_group;

		$link_attrs = [];

		if ( empty( $acf_link_group ) ) :
			return false;
		endif;

		switch ( $type ) {
			case 'link':
				$link_arr = $link ? $link : array();
				break;
			case 'file':
				$link_arr = [
					'url'   => $file,
					'title' => $file_label,
				];
				if ( $file_download === true ) :
					$link_attrs['download'] = true;
				endif;
				break;
			case 'none':
				return false;
		}

		$class_names[] = $style ? $style : 'btn-primary';
		$class_names[] = $color;

		$link_attrs['class'] = join( ' ', array_unique( $class_names ) );

		adapt_dev_the_link( $link_arr, $link_attrs, $close );
	}
endif;

if ( ! function_exists( 'adapt_dev_the_link' ) ) {
	/**
	 * Builds the HTML for a link
	 *
	 * @param array $link_array - The standard ACF array for a link containing information for the URL, target, title, & aria label. If constructing your own link array, the only required
	 * @param array $attrs - An array of custom attributes to apply to the anchor tag. Current supported attributes are `class`, `data-attrs` and `download`
	 * @param bool  $close - If set to true, this will ouput a complete anchor tag. If set to false, this will output an opened anchor tag. This is useful if you want to link other elements like images. Use with adapt_dev_close_the_link()
	 * @return void
	 */
	function adapt_dev_the_link( array $link_array = [], array $attrs = [], $close = true ) {

		if ( ! array_key_exists( 'url', $link_array ) ) :
			return;
		endif;

		//phpcs:ignore
		$default_attrs = [
			'class'      => '',
			'data-attrs' => '',
			'download'   => false,
		];

		$attrs = array_merge( $default_attrs, $attrs );

		$link_attributes = 'href="' . esc_url( $link_array['url'] ) . '"';

		if ( array_key_exists( 'target', $link_array ) && ! empty( $link_array['target'] ) ) :
			$link_attributes .= ' target="' . $link_array['target'] . '"';
		endif;

		if ( array_key_exists( 'aria-label', $link_array ) && ! empty( $link_array['aria-label'] ) ) :
			$link_attributes .= ' aria-label="' . $link_array['aria-label'] . '"';
		endif;

		if ( array_key_exists( 'title', $link_array ) && ! empty( $link_array['title'] ) ) :
			$title = $link_array['title'];
		else :
			$title = false;
		endif;

		if ( ! empty( $attrs['class'] ) ) :
			$link_attributes .= ' class="' . $attrs['class'] . '"';
		endif;

		if ( ! empty( $attrs['data-attrs'] ) && is_array( $attrs['data-attrs'] ) ) :
			foreach ( $attrs['data-attrs'] as $key => $value ) :
				$link_attributes .= 'data-' . $key . '="' . $value . '" ';
			endforeach;
		endif;

		if ( $attrs['download'] !== false ) :
			$link_attributes .= 'download';
		endif;

		$link_html = '<a ' . trim( $link_attributes ) . '>';
		if ( false !== $title ) :
			$link_html .= $title;
		endif;

		if ( $close ) :
			$link_html .= '</a>';
		endif;
		//phpcs:ignore
		echo $link_html;
	}
}

if ( ! function_exists( 'adapt_dev_close_the_link' ) ) {
	/**
	 * Outputs a closing anchor tag
	 *
	 * @return void
	 */
	function adapt_dev_close_the_link() {
		echo '</a>';
	}
}

if ( ! function_exists( 'adapt_dev_classnames' ) ) :
	/**
	 * Conditionally build classlist for an element
	 * 
	 * @param string|array Either a string classname to definitely include, or an array with key(s) for classnames and value(s) that are truthy or falsy.
	 * 
	 * @return string The classlist, already escaped and space separated.
	 */
	function adapt_dev_classnames() : string {
		// @see https://www.php.net/manual/en/function.func-get-args.php
		$args = func_get_args();

		$data = array_reduce(
			$args,
			function( $memo, $arg ) {
				if ( is_array( $arg ) ) {
					return array_merge( $memo, $arg );
				}

				array_push( $memo, $arg );

				return $memo;
			},
			array()
		);

		$classnames = array_map(
			function( $key, $value ) {
				$class = $key;
				$predicate = $value;

				if ( is_int( $key ) ) {
					return $value;
				}

				if ( $predicate ) {
					return $class;
				}

				return null;
			},
			array_keys( $data ),
			array_values( $data )
		);

		return esc_attr( implode( ' ', array_filter( $classnames ) ) );
	}
endif;

if ( ! function_exists( 'adapt_dev_section_classes' ) ) :
	/**
	 * Output the classes for an acf flex section
	 *
	 * @param array $addtl_classnames Additional classnames
	 */
	function adapt_dev_section_classes( $addtl_classnames = [] ) {
		$classnames     = [ 'acf-flex-layout' ];
		$base_classname = 'layout--' . get_row_layout();
		$classnames[]   = $base_classname;

		$background_image = get_sub_field( 'background_image' ) ? get_sub_field( 'background_image' ) : '';
		$background_tag   = $background_image ? 'style="--background-image:url(' . esc_url( $background_image ) . ');" ' : '';
		$classnames[]     = $background_image ? 'bg-image' : '';

		$background_color = get_sub_field( 'background_color' ) ? get_sub_field( 'background_color' ) : '';
		$classnames[]     = $background_color;

		$text_align_center = get_sub_field( 'widget_text_align' ) == 'center' ? 'text-center' : '';
		$classnames[]      = $text_align_center;

		$text_align_left = get_sub_field( 'widget_text_align' ) == 'left' ? 'text-left' : '';
		$classnames[]    = $text_align_left;

		$has_background_color = ! empty( get_sub_field( 'background_color' ) ) && get_sub_field( 'background_color' ) !== 'white' ? 'has-bg-color' : '';
		$classnames[]         = $has_background_color;

		$has_top_divider = ! empty( get_sub_field( 'divider' )['top'] ) && get_sub_field( 'divider' )['top'] == 1 ? 'has-top-slant-divider' : '';
		$classnames[]    = $has_top_divider;

		$has_bottom_divider = ! empty( get_sub_field( 'divider' )['bottom'] ) && get_sub_field( 'divider' )['bottom'] == 1 ? 'has-bottom-slant-divider' : '';
		$classnames[]       = $has_bottom_divider;

		$has_slant_divider = ! empty( get_sub_field( 'divider' )['top'] ) == 1 || ! empty( get_sub_field( 'divider' )['bottom'] ) == 1 ? 'has-slant-divider' : '';
		$classnames[]      = $has_slant_divider;

		if ( ! empty( $has_top_divider ) ) :
			$slant_top_color = ! empty( get_sub_field( 'divider' )['top_color'] ) ? 'divider-top-' . get_sub_field( 'divider' )['top_color'] : '';
			$classnames[]    = $slant_top_color;
		endif;

		if ( ! empty( $has_bottom_divider ) ) :
			$slant_bottom_color = ! empty( get_sub_field( 'divider' )['bottom_color'] ) ? 'divider-bottom-' . get_sub_field( 'divider' )['bottom_color'] : '';
			$classnames[]       = $slant_bottom_color;
		endif;

		$classnames[] = get_sub_field( 'hide_image_on_mobile' ) ? 'hide-image-on-mobile' : '';

		$widget_padding_top = get_sub_field( 'widget_padding' )['top'];
		$classnames[]       = $widget_padding_top !== 'default' ? $widget_padding_top : '';

		$widget_padding_bottom = get_sub_field( 'widget_padding' )['bottom'];
		$classnames[]          = $widget_padding_bottom !== 'default' ? $widget_padding_bottom : '';

		$widget_id = get_sub_field( 'widget_id' );

		// Output a widget ID if present.
		echo $widget_id ? 'id="' . esc_attr( preg_replace( '/[[:space:]]+/', '-', $widget_id ) ) . '"' : '';

		echo $background_tag . 'class="' . esc_attr( implode( ' ', array_unique( array_merge( $classnames, $addtl_classnames ) ) ) ) . '"';//phpcs:ignore
	}
endif;

if ( ! function_exists( 'adapt_dev_section_heading' ) ) :
	/**
	 * Output the section heading
	 */
	function adapt_dev_section_heading() {
		$heading     = get_sub_field( 'section_heading' );
		$sub_heading = get_sub_field( 'section_sub_heading' );
		?>

		<?php if ( $heading || $sub_heading ) : ?>
			<div class="flex-layout__headings">
				<?php if ( ! empty( $heading ) ) : ?>
					<h2 class="flex-layout__heading"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $sub_heading ) ) : ?>
					<h3 class="flex-layout__sub-heading"><?php echo esc_html( $sub_heading ); ?></h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php
	}
endif;

if ( ! function_exists( 'adapt_dev_get_the_address' ) ) :
	/**
	 * Construct an address element with microdata.
	 *
	 * @param array $address Associative array of contact information fields.
	 */
	function adapt_dev_get_the_address( $address ) {
		global $adapt_dev_config;

		if ( empty( $address ) ) {
			$address = array(
				'address'     => $adapt_dev_config['address_1'],
				'address_2'   => $adapt_dev_config['address_2'],
				'city'        => $adapt_dev_config['city'],
				'state'       => $adapt_dev_config['state'],
				'postal_code' => $adapt_dev_config['zip'],
			);
		}

		$address_element = '';
		if ( empty( array_filter( $address ) ) ) {
			return $address_element; }

		$address_element .= '<address class="address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">';

		if ( ! empty( $address['name'] ) ) {
			$address_element .= '<span class="name">' . esc_html( $address['name'] ) . '<br></span>';
		}

		if ( ! empty( $address['address'] ) ) {
			$address_element .= '<span class="street-address" itemprop="streetAddress">' . esc_html( $address['address'] ) . '<br></span>';

			if ( ! empty( $address['address_2'] ) ) :
				$address_element .= '<span class="street-address-2" itemprop="streetAddress">' . esc_html( $address['address_2'] ) . '<br></span>';
			endif;
		}

		if ( ! empty( $address['city'] ) ) {
			$address_element .= '<span class="city" itemprop="addressLocality">' . esc_html( $address['city'] ) . ',</span>';
		}

		if ( ! empty( $address['state'] ) ) {
			$address_element .= '<span class="state" itemprop="addressRegion"> ' . esc_html( $address['state'] ) . '</span>';
		}

		if ( ! empty( $address['postal_code'] ) ) {
			$address_element .= '<span class="postal-code" itemprop="postalCode"> ' . esc_html( $address['postal_code'] ) . '</span>';
		}

		$address_element .= '</address>';

		return $address_element;
	}
endif;

if ( ! function_exists( 'adapt_dev_the_address' ) ) :
	/**
	 * Output an address element with microdata.
	 *
	 * @param array $address Associative array of contact information fields.
	 */
	function adapt_dev_the_address( $address = array() ) {
		echo adapt_dev_get_the_address( $address );//phpcs:ignore
	}
endif;

if ( ! function_exists( 'adapt_dev_get_the_address_url' ) ) :
	/**
	 * Construct the address url to google maps.
	 *
	 * @param array $address Associative array of contact information fields.
	 */
	function adapt_dev_get_the_address_url( $address ) {
		global $adapt_dev_config;

		if ( empty( $address ) ) {
			$address = array(
				'name'        => get_bloginfo( 'name' ),
				'address'     => $adapt_dev_config['address_1'],
				'address_2'   => $adapt_dev_config['address_2'],
				'city'        => $adapt_dev_config['city'],
				'state'       => $adapt_dev_config['state'],
				'zip'         => $adapt_dev_config['zip'],
			);
		}

		$address_element = '';

		$address_string = $address['address']	. '+' . $address['address_2'] . '+' . $address['city'] . '+' . $address['state'] . '+' . $address['zip'];//phpcs:ignore
		$address_string = str_replace( ' ', '+', $address_string );
		$address_string = str_replace( '-', '', $address_string );
		$address_string = str_replace( '++', '+', $address_string );

		$address_element = 'https://www.google.com/maps/search/' . $address_string;
		return $address_element;
	}
endif;

if ( ! function_exists( 'adapt_dev_the_address_url' ) ) :
	/**
	 * Output an address url for google maps.
	 *
	 * @param array $address Associative array of contact information fields.
	 */
	function adapt_dev_the_address_url( $address = array() ) {
		echo adapt_dev_get_the_address_url( $address );//phpcs:ignore
	}
endif;

if ( ! function_exists( 'adapt_dev_the_site_logo' ) ) :
	/**
	 * Output the site logo
	 */
	function adapt_dev_the_site_logo() {
		global $adapt_dev_config;

		$site_logo = $adapt_dev_config['header_logo'];

		if ( empty( $site_logo ) ) {
			$site_logo = trailingslashit( ADAPT_DEV_IMAGES ) . 'logo.png';
		} else {
			$site_logo = wp_get_attachment_image_url( $site_logo, 'large' );
		}
		?>

		<div class="logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="logo__img" loading="lazy" lazy width="179" height="50" src="<?php echo esc_url( $site_logo ); ?>" alt="<?php bloginfo( 'name' ); ?> logo"><span class="sr-only">Return to homepage</span></a>
		</div><!--logo-->
		<?php
	}
endif;

if ( ! function_exists( 'adapt_dev_the_social_icons' ) ) :
	/**
	 * Output the social icons
	 */
	function adapt_dev_the_social_icons() {
		global $adapt_dev_config;

		$output = '';

		$options = array(
			'facebook_url',
			'twitter_url',
			'instagram_url',
			'linkedin_url',
			'youtube_url',
		);

		$icons_html = '';
		foreach ( $options as $option ) {
			$url = $adapt_dev_config[ $option ];
			if ( $url ) {
				$option_name = str_replace( '_url', '', $option );
				$icons_html .= '<div><a href="' . $url . '" target="_blank"><span class="sr-only">' . $option_name . '</span><i class="fab fa-' . $option_name . '"></i></a></div>';
			}
		}

		if ( $icons_html ) {
			$output .= '<div class="social-icons">' . $icons_html . '</div>';
		}

		echo wp_kses_post( $output );
	}
endif;

if ( ! function_exists( 'adapt_dev_sitemap' ) ) :
	/**
	 * Create a sitemap and shortcode using wp_list_pages
	 * https://developer.wordpress.org/reference/functions/wp_list_pages/
	 */
	function adapt_dev_sitemap() {
		global $adapt_dev_config;

		$excluded_pages = array();
		$excluded_pages = $adapt_dev_config['sitemap_excluded_pages'];

		$args = array(
			'title_li' => '',
			'exclude'  => $excluded_pages != false ? implode( ', ', $excluded_pages ) : '',
		);

		ob_start();
		?>
		<ul class="page-list">
			<?php wp_list_pages( $args ); ?>
		</ul>
		<?php
		return ob_get_clean();
	}
	add_shortcode( 'sitemap', 'base_teamsi_sitemap' );
endif;

