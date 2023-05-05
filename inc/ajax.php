<?php
/**
 * Ajax
 *
 * Functions acting as AJAX request handlers
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Perform an ajax post filter
 *
 * @param mixed $query The query
 */
function adapt_dev_post_filter( $query ) {
	check_ajax_referer( 'adapt_dev_ajax', 'nonce' );
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'paged'          => 1,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	/* If this is not a clear all call */
	if ( $_POST['category'] != '' ) ://phpcs:ignore
		$args['category_name'] = $_POST['category'];//phpcs:ignore
	endif;

	$ajax_query          = new WP_Query( $args );
	$GLOBALS['wp_query'] = $ajax_query;//phpcs:ignore

	if ( $ajax_query->have_posts() ) :
		$result = '';

		ob_start();
			get_template_part( 'template-parts/partials/loading' );
		while ( $ajax_query->have_posts() ) :
			$ajax_query->the_post();
			$i++;
			get_template_part( 'template-parts/content', 'post' );
			endwhile;
		wp_reset_postdata();
		$result = ob_get_clean();
	else :
		$result = "<h2 class='no-posts'>Sorry. There are no posts inside this category</h2>";
	endif;

	ob_start();
	if ( function_exists( 'adapt_dev_paging_nav' ) ) : ?>
		<div class="paginate">
			<?php adapt_dev_paging_nav( $_POST['base'] );//phpcs:ignore?>
		</div>
		<?php
	endif;
	$paginate = ob_get_clean();

	wp_send_json_success(
		[
			'results'  => $result,
			'paginate' => $paginate,
			'query'    => $args,
		]
	);
	wp_die();
}
add_action( 'wp_ajax_post_filter', 'adapt_dev_post_filter' );
add_action( 'wp_ajax_nopriv_post_filter', 'adapt_dev_post_filter' );
