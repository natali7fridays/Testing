<?php
/**
 * Hero flexible content layout
 *
 * @package adaptdev/base
 */

$cta_args = array(
	'call-to-action' => get_sub_field( 'call-to-action' ),
	'hero'           => 'yes',
);

$bg_img_position_h = get_sub_field( 'background_image_position_h' );
$bg_img_position_v = get_sub_field( 'background_image_position_v' );

$hero_section_height = get_sub_field( 'hero_section_height' );

$image_url = wp_get_attachment_image_url( get_sub_field( 'image' ), 'hero-bg', false ); ?>

<section
	style="--hero-background-image:url(<?php echo esc_url( $image_url ); ?>); --hero-background-position: <?php echo esc_html( $bg_img_position_h ) . ' ' . esc_html( $bg_img_position_v ); ?>"
		<?php
		adapt_dev_section_classes(
			[
				'lazy',
				get_sub_field( 'hero_alignment' ) == 'center' ? 'aligned' : '',
				get_sub_field( 'hero_alignment' ) == 'right' ? 'aligned-right' : '',
				get_sub_field( 'hero_bg_overlay' ) ? 'bg-overlay' : '',
				get_sub_field( 'hide_image_on_mobile' ) ? 'hide-image-on-mobile' : '',
				'vertical-align-' . get_sub_field( 'hero_alignment_vertical' ),
				$hero_section_height == 'large' ? 'min-height-large' : '',
				$hero_section_height == 'full' ? 'min-height-full' : '',
			]
		);
		?>
	>
	<?php get_template_part( 'template-parts/partials/call-to-action', '', $cta_args ); ?>
</section>
