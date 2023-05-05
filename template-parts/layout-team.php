<?php
/**
 * Grid of featured post cards
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

$team         = get_sub_field( 'select_team' );
$layout       = get_sub_field( 'layout' );
$show_excerpt = get_sub_field( 'show_excerpt' );

$card_args = [
	'layout'       => $layout,
	'show_excerpt' => $show_excerpt,
];

if ( ! empty( $team ) ) :
	$args = [
		'post_type'      => 'adaptdev_team_member',
		'posts_per_page' => -1,
		'post__in'       => $team,
		'orderby'        => 'post__in',
	];

	$team_query = new WP_Query( $args );

	if ( $team_query->have_posts() ) : ?>

	<section <?php adapt_dev_section_classes(); ?>>
		<?php adapt_dev_section_heading(); ?>
		<div class="card-<?php echo $layout ? esc_attr( $layout ) : 'grid'; ?> <?php echo $show_excerpt ? 'excerpt-visible' : 'excerpt-hidden'; ?>">
			<?php
			foreach ( $team_query->get_posts() as $my_post ) :
				$post = $my_post;//phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $my_post );
				get_template_part( 'template-parts/content', 'team-member', $card_args );
			endforeach;
			wp_reset_postdata();
			?>
		</div><!--.card-grid-->
	</section>
	<?php endif;
endif; ?>
