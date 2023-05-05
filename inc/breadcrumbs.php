<?php
/**
 * Code for Breadcrumbs sourced from thewebtaylor and available for public use
 * https://www.thewebtaylor.com/articles/wordpress-creating-breadcrumbs-without-a-plugin
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Breadcrumbs
 */
function adapt_dev_breadcrumbs() {

	// Settings
	$separator        = '<i class="fal fa-angle-right"></i>';
	$breadcrums_id    = 'breadcrumbs';
	$breadcrums_class = 'breadcrumbs';
	$home_title       = 'Homepage';

	// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
	$custom_taxonomy = 'project_type';

	// Get the query & post information
	global $post,$wp_query;

	// Do not display on the homepage
	if ( ! is_front_page() ) {

		// Build the breadcrumbs
		echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';//phpcs:ignore

		// Home page
		echo '<li class="item-home"><a class="bread-link bread-home" href="' . esc_url( get_home_url() ) . '" title="' . esc_html( $home_title ) . '"><i class="fas fa-home"></i></a></li>';
		echo '<li class="separator separator-home"> ' . $separator . ' </li>';//phpcs:ignore

		if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {

			echo '<li class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title( '', false ) . '</span></li>';

		} elseif ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if ( $post_type != 'post' ) {

				$post_type_object  = get_post_type_object( $post_type );
				$post_type_archive = get_post_type_archive_link( $post_type );

				echo '<li class="item-cat item-custom-post-type-' . esc_attr( $post_type ) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_html( $post_type_object->labels->name ) . '</a></li>';
				echo '<li class="separator"> ' . esc_html( $separator ) . ' </li>';

			}

			$custom_tax_name = get_queried_object()->name;
			echo '<li class="item-current item-archive"><span class="bread-current bread-archive">' . esc_html( $custom_tax_name ) . '</span></li>';

		} elseif ( is_single() ) {

			$posts_page_title = get_the_title( get_option( 'page_for_posts', true ) );
			$posts_page_link  = get_the_permalink( get_option( 'page_for_posts', true ) );

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if ( $post_type != 'post' ) {

				$post_type_object  = get_post_type_object( $post_type );
				$post_type_archive = get_post_type_archive_link( $post_type );

				echo '<li class="item-cat item-custom-post-type-' . esc_attr( $post_type ) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_html( $post_type_object->labels->name ) . '</a></li>';
				echo '<li class="separator"> ' . esc_html( $separator ) . ' </li>';

			}

			// Get post category info
			$category = get_the_category();

			if ( ! empty( $category ) ) {

				// Get last category post is in
				$last_category = $category[ count( $category ) - 1 ];

				// Get parent any categories and create array
				$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
				$cat_parents     = explode( ',', $get_cat_parents );

				// Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				foreach ( $cat_parents as $parents ) {
					$cat_display .= '<li class="item-cat">' . $parents . '</li>';
					$cat_display .= '<li class="separator"> ' . $separator . ' </li>';
				}
			}

			// If it's a custom post type within a custom taxonomy
			$taxonomy_exists = taxonomy_exists( $custom_taxonomy );
			if ( empty( $last_category ) && ! empty( $custom_taxonomy ) && $taxonomy_exists ) {

				$taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
				$cat_id         = $taxonomy_terms[0]->term_id;
				$cat_nicename   = $taxonomy_terms[0]->slug;
				$cat_link       = get_term_link( $taxonomy_terms[0]->term_id, $custom_taxonomy );
				$cat_name       = $taxonomy_terms[0]->name;

			}

			// Check if the post is in a category
			if ( ! empty( $last_category ) ) {

				echo '<li><a class="bread-parent bread-parent-' . esc_attr( $posts_page_title ) . '" href="' . esc_url( $posts_page_link ) . '" title="' . esc_attr( $posts_page_title ) . '">' . esc_html( $posts_page_title ) . '</a></li>';
				echo '<li class="separator"> ' . esc_html( $separator ) . ' </li>';
				echo esc_html( $cat_display );
				echo '<li class="item-current item-' . esc_attr( $post->ID ) . '"><span class="bread-current bread-' . esc_attr( $post->ID ) . '" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span></li>';

				// Else if post is in a custom taxonomy
			} elseif ( ! empty( $cat_id ) ) {

				echo '<li class="item-cat item-cat-' . esc_attr( $cat_id ) . ' item-cat-' . esc_attr( $cat_nicename ) . '"><a class="bread-cat bread-cat-' . esc_attr( $cat_id ) . ' bread-cat-' . esc_attr( $cat_nicename ) . '" href="' . esc_url( $cat_link ) . '" title="' . esc_attr( $cat_name ) . '">' . esc_html( $cat_name ) . '</a></li>';
				echo '<li class="separator"> ' . esc_html( $separator ) . ' </li>';
				echo '<li class="item-current item-' . esc_attr( $post->ID ) . '"><span class="bread-current bread-' . esc_attr( $post->ID ) . '" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span></li>';

			} else {

				echo '<li class="item-current item-' . esc_attr( $post->ID ) . '"><span class="bread-current bread-' . esc_attr( $post->ID ) . '" title="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</span></li>';

			}
		} elseif ( is_category() ) {

			// Category page
			echo '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title( '', false ) . '</span></li>';

		} elseif ( is_page() ) {

			// Standard page
			if ( $post->post_parent ) {

				// If child page, get parents
				$anc = get_post_ancestors( $post->ID );

				// Get parents in the right order
				$anc = array_reverse( $anc );

				// Parent page loop
				if ( ! isset( $parents ) ) {
					$parents = null;
				}
				foreach ( $anc as $ancestor ) {
					$parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
					$parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
				}

				// Display parent pages
				echo esc_html( $parents );

				// Current page
				echo '<li class="item-current item-' . esc_attr( $post->ID ) . '"><span title="' . esc_attr( get_the_title() ) . '"> ' . esc_html( get_the_title() ) . '</span></li>';

			} else {

				// Just display current page if not parents
				echo '<li class="item-current item-' . esc_attr( $post->ID ) . '"><span class="bread-current bread-' . esc_attr( $post->ID ) . '"> ' . esc_html( get_the_title() ) . '</span></li>';

			}
		} elseif ( is_home() ) {
			$posts_page_title = get_the_title( get_option( 'page_for_posts', true ) );
			$posts_page_link  = get_the_permalink( get_option( 'page_for_posts', true ) );

			if ( get_query_var( 'paged' ) != '0' ) :

				echo '<li><a class="bread-parent bread-parent-' . esc_attr( $posts_page_title ) . '" href="' . esc_url( $posts_page_link ) . '" title="' . esc_attr( $posts_page_title ) . '">' . esc_html( $posts_page_title ) . '</a></li>';
				echo '<li class="separator"> ' . esc_html( $separator ) . ' </li>';
				echo '<li class="item-current item-current-' . esc_attr( get_query_var( 'paged' ) ) . '"><span class="bread-current bread-current-' . esc_attr( get_query_var( 'paged' ) ) . '" title="Page ' . esc_attr( get_query_var( 'paged' ) ) . '">' . esc_html__( 'Page' ) . ' ' . esc_html( get_query_var( 'paged' ) ) . '</span></li>';

				else :
					echo '<li><span>' . esc_html( $posts_page_title ) . '</span></li>';
					endif;

		} elseif ( is_tag() ) {

			// Tag page

			// Get tag information
			$term_id       = get_query_var( 'tag_id' );
			$taxonomy      = 'post_tag';
			$args          = 'include=' . $term_id;
			$terms         = get_terms( $taxonomy, $args );
			$get_term_id   = $terms[0]->term_id;
			$get_term_slug = $terms[0]->slug;
			$get_term_name = $terms[0]->name;

			// Display the tag name
			echo '<li class="item-current item-tag-' . esc_attr( $get_term_id ) . ' item-tag-' . esc_attr( $get_term_slug ) . '"><span class="bread-current bread-tag-' . esc_attr( $get_term_id ) . ' bread-tag-' . esc_attr( $get_term_slug ) . '">' . esc_html( $get_term_name ) . '</span></li>';

		} elseif ( is_day() ) {

			// Day archive

			// Year link
			echo '<li class="item-year item-year-' . esc_attr( get_the_time( 'Y' ) ) . '"><a class="bread-year bread-year-' . esc_attr( get_the_time( 'Y' ) ) . '" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . ' Archives</a></li>';
			echo '<li class="separator separator-' . esc_attr( get_the_time( 'Y' ) ) . '"> ' . esc_html( $separator ) . ' </li>';

			// Month link
			echo '<li class="item-month item-month-' . esc_attr( get_the_time( 'm' ) ) . '"><a class="bread-month bread-month-' . esc_attr( get_the_time( 'm' ) ) . '" href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . '">' . esc_html( get_the_time( 'M' ) ) . ' Archives</a></li>';
			echo '<li class="separator separator-' . esc_attr( get_the_time( 'm' ) ) . '"> ' . esc_html( $separator ) . ' </li>';

			// Day display
			echo '<li class="item-current item-' . esc_attr( get_the_time( 'j' ) ) . '"><span class="bread-current bread-' . esc_attr( get_the_time( 'j' ) ) . '"> ' . esc_html( get_the_time( 'jS' ) ) . ' ' . esc_html( get_the_time( 'M' ) ) . ' Archives</span></li>';

		} elseif ( is_month() ) {

			// Month Archive

			// Year link
			echo '<li class="item-year item-year-' . esc_attr( get_the_time( 'Y' ) ) . '"><a class="bread-year bread-year-' . esc_attr( get_the_time( 'Y' ) ) . '" href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . ' Archives</a></li>';
			echo '<li class="separator separator-' . esc_attr( get_the_time( 'Y' ) ) . '"> ' . esc_html( $separator ) . ' </li>';

			// Month display
			echo '<li class="item-month item-month-' . esc_attr( get_the_time( 'm' ) ) . '"><span class="bread-month bread-month-' . esc_attr( get_the_time( 'm' ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . '">' . esc_html( get_the_time( 'M' ) ) . ' Archives</span></li>';

		} elseif ( is_year() ) {

			// Display year archive
			echo '<li class="item-current item-current-' . esc_attr( get_the_time( 'Y' ) ) . '"><span class="bread-current bread-current-' . esc_attr( get_the_time( 'Y' ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . esc_html( get_the_time( 'Y' ) ) . ' Archives</span></li>';

		} elseif ( is_author() ) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata( $author );

			// Display author name
			echo '<li class="item-current item-current-' . esc_attr( $userdata->user_nicename ) . '"><span class="bread-current bread-current-' . esc_attr( $userdata->user_nicename ) . '" title="' . esc_attr( $userdata->display_name ) . '">Author: ' . esc_html( $userdata->display_name ) . '</span></li>';

		} elseif ( get_query_var( 'paged' ) ) {

			// Paginated archives
			echo '<li class="item-current item-current-' . esc_attr( get_query_var( 'paged' ) ) . '"><span class="bread-current bread-current-' . esc_attr( get_query_var( 'paged' ) ) . '" title="Page ' . esc_attr( get_query_var( 'paged' ) ) . '">' . esc_html__( 'Page' ) . ' ' . esc_html( get_query_var( 'paged' ) ) . '</span></li>';

		} elseif ( is_search() ) {

			// Search results page
			echo '<li class="item-current item-current-' . esc_attr( get_search_query() ) . '"><span class="bread-current bread-current-' . esc_attr( get_search_query() ) . '" title="Search results for: ' . esc_attr( get_search_query() ) . '">Search results for: ' . get_search_query() . '</span></li>';

		} elseif ( is_404() ) {

			// 404 page
			echo '<li>Error 404</li>';
		}

		echo '</ul>';

	}

}
