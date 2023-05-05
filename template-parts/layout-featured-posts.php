<?php
/**
 * Grid of featured post cards
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

if ( get_sub_field( 'select_posts' ) ) {
	$featured_posts = get_sub_field( 'posts' );
	if ( ! empty( $featured_posts ) ) :
		$args = [
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'post__in'       => $featured_posts,
			'orderby'        => 'post__in',
		];
	endif;
} else {
	$args = [
		'post_type'      => 'post',
		'posts_per_page' => 2,
	];
}

$featured_posts_query = new WP_Query( $args );

if ( $featured_posts_query->have_posts() ) : ?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php adapt_dev_section_heading(); ?>
	<div class="card-grid">
		<?php
		foreach ( $featured_posts_query->get_posts() as $my_post ) :
			$post = $my_post;//phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $my_post );
			get_template_part( 'template-parts/content', get_post_type() );
		endforeach;
		wp_reset_postdata();
		?>
	</div><!--.card-grid-->
</section>

<?php endif; ?>
