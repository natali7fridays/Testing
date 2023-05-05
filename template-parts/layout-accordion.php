<?php
/**
 * Accordion flexible content layout
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php adapt_dev_section_heading(); ?>

	<div class="accordion-list">
		<?php
		if ( have_rows( 'accordion' ) ) :
			while ( have_rows( 'accordion' ) ) :
				the_row();
				get_template_part(
					'template-parts/partials/accordion',
					'',
					[
						'accordion' => [
							'summary'    => get_sub_field( 'summary' ),
							'details'    => get_sub_field( 'entry-content' ),
							'classnames' => [ 'accordion-item' ],
						],
					]
				);
			endwhile;
		endif;
		?>
	</div>

</section>
