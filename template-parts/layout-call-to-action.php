<?php
/**
 * Hero flexible content layout
 *
 * @package adaptdev/base
 */

$cta_args  = array(
	'call-to-action' => get_sub_field( 'call-to-action' ),
	'hero'           => 'yes',
);
$alignment = get_sub_field( 'alignment' ) . '-align-content';

// $image_url = wp_get_attachment_image_url( get_sub_field( 'image' ), 'hero-bg', false ); ?>

<section
		<?php
		adapt_dev_section_classes(
			[
				'lazy',
				get_sub_field( 'hide_image_on_mobile' ) ? 'hide-image-on-mobile' : '',
				$alignment,
			]
		);
		?>
	>
	<?php get_template_part( 'template-parts/partials/call-to-action', '', $cta_args ); ?>
</section>
