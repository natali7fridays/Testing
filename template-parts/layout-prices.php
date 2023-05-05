<?php
/**
 * List of Prices (from Price CPT)
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

$prices = get_sub_field( 'select_prices' );

if ( ! empty( $prices ) ) :
	$args = [
		'post_type'      => 'adapt_dev_prices',
		'posts_per_page' => -1,
		'post__in'       => $prices,
		'orderby'        => 'post__in',
	];

	$prices_query = new WP_Query( $args );

	if ( $prices_query->have_posts() ) : ?>

	<section <?php adapt_dev_section_classes(); ?>>
		<?php adapt_dev_section_heading(); ?>
		<div class="prices-list">
			<?php
			foreach ( $prices_query->get_posts() as $my_post ) :
				$post = $my_post;//phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $my_post );
				// get_template_part( 'template-parts/content', get_post_type() );
					$price    = get_field( 'price' );
					$currency = get_field( 'currency' );
				?>
					<div class="price-row">
						<div class="entry-title">
							<h3 style="text-align: left;"><?php the_title(); ?></h3>  
							<span class="price"><?php echo esc_html( $currency ) . esc_html( $price ); ?></span>
						</div>
						<hr />
						<?php the_content(); ?>
					</div>
				<?php
			endforeach;
			wp_reset_postdata();
			?>
		</div><!--.card-grid-->
	</section>
	<?php endif;
endif; ?>
