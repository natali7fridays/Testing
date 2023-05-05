<?php
/**
 * Features list flexible content layout
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$features = get_sub_field( 'features' );
if ( ! empty( $features ) ) : ?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php adapt_dev_section_heading(); ?>

	<?php foreach ( $features as $feature ) : ?>
		<?php get_template_part( 'template-parts/content', 'feature', $feature ); ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>
