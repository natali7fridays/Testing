<?php
/**
 * Video layout for flex content
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$section_classname = uniqid( 'video-' );
$align             = get_sub_field( 'alignment' ); 
$description       = get_sub_field( 'description' ); ?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php adapt_dev_section_heading(); ?>

	<figure class="video__container">
		<?php get_template_part( 'template-parts/partials/video', '', $args ); ?>
		<?php if ( $description ) : ?> 
			<figcaption class="video__description">
				<?php echo wp_kses_post( $description ); ?>
			</figcaption>
		<?php endif; ?>
	</figure>
</section>
