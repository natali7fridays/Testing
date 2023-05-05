<?php
/**
 * Grid of featured post cards
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

$location_layout    = get_sub_field( 'locations_layout' );
$locations          = get_sub_field( 'select_locations' );
$added_classnames[] = 'layout-style__' . esc_attr( $location_layout );

// Setting up a variable for adding the 'grid to list' swap feature (Disabled for now.)
$layout_swap_enabled = false;

if ( ! empty( $locations ) ) :
	$args = [
		'post_type'      => 'adapt_dev_locations',
		'posts_per_page' => -1,
		'post__in'       => $locations,
		'orderby'        => 'post__in',
	];

	$locations_query = new WP_Query( $args );

	if ( $locations_query->have_posts() ) : ?>

	<section <?php adapt_dev_section_classes( $added_classnames ); ?>>
		<?php adapt_dev_section_heading(); ?>
		<?php if ( $layout_swap_enabled ) : ?>
			<div class="locations-listing--toggle-container">
				<button class="locations-listing--toggle list">
					<i class="fas fa-th-large"></i><i class="fas fa-list"></i>
				</button>
			</div>
		<?php endif; ?>
		<div class="locations-listing <?php echo esc_attr( $location_layout ); ?>">
			<?php
			foreach ( $locations_query->get_posts() as $my_post ) :
				$post = $my_post;//phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $my_post );
				get_template_part( 'template-parts/content', 'location' );
			endforeach;
			wp_reset_postdata();
			?>
		</div><!--.card-grid-->
	</section>
	<?php endif;
endif; ?>
