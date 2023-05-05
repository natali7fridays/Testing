<?php
/**
 * Image layout for entry content
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$args = array(
	'entry-content' => get_sub_field( 'entry-content' ),
); ?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php adapt_dev_section_heading(); ?>
	<?php get_template_part( 'template-parts/partials/entry-content', '', $args ); ?>
</section>
