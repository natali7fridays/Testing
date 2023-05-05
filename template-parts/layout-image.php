<?php
/**
 * Image layout for flex content
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$additional_classes[] = get_sub_field( 'remove_top_padding' ) ? 'no-top-padding' : '';
$additional_classes[] = get_sub_field( 'remove_bottom_padding' ) ? 'no-bottom-padding' : '';
$additional_classes[] = get_sub_field( 'image_width' ) == 'wide' ? 'wide-image' : '';
$additional_classes[] = get_sub_field( 'image_shape' ) == 'circle' ? 'image-shape-circle' : '';

$img = [ 'size' => '1500' ];

if ( get_sub_field( 'image_width' ) == 'thumbnail' ) :
	$img = [ 'size' => 'thumbnail' ];
endif;

if ( get_sub_field( 'image_width' ) == 'medium' ) :
	$img = [ 'size' => 'medium' ];
endif;

if ( get_sub_field( 'image_width' ) == 'default' || get_sub_field( 'image_width' ) == 'wide' ) :
	$img = [ 'size' => 'medium_large' ];
endif;
?>

<section <?php adapt_dev_section_classes( $additional_classes ); ?>>
	<?php adapt_dev_section_heading(); ?>

	<div class="image__container">
		<?php get_template_part( 'template-parts/partials/image', '', $img ); ?>
	</div>
</section>
