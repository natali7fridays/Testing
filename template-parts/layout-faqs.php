<?php
/**
 * FAQ's layout for entry content
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$faqs_query = new WP_Query(
	[
		'post_type'      => 'adapt_dev_faq',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	]
);

if ( $faqs_query->have_posts() ) : ?>
	<section <?php adapt_dev_section_classes(); ?>>
		<?php adapt_dev_section_heading(); ?>
		<div class="faqs-list">
			<?php
			foreach ( $faqs_query->get_posts() as $my_post ) :
				setup_postdata( $my_post );
				get_template_part(
					'template-parts/partials/accordion',
					'',
					[
						'accordion' => [
							'summary'    => get_the_title( $my_post->ID ),
							'details'    => get_the_content(),
							'classnames' => [ 'faq' ],
						],
					]
				);
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	</section>
<?php endif; ?>
