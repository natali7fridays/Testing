<?php
/**
 * Testimonials flexible content layout
 *
 * @package adaptdev/base
 */

?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php adapt_dev_section_heading(); ?>
	<?php get_template_part( 'template-parts/partials/testimonials', '' ); ?>
</section>
