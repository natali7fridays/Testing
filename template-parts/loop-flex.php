<?php
/**
 * ACF flexible content loop
 *
 * Include this file in page and post templates where
 * content is rendered via ACF Flexible Content fields.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>
		<?php
		if ( function_exists( 'have_rows' ) && have_rows( 'page-sections' ) ) :
			do_action( 'adapt_dev_flex_loop_before' );
			?>
			<?php
			while ( have_rows( 'page-sections' ) ) :
				the_row();
				do_action( 'adapt_dev_flex_section_before' );
				get_template_part( 'template-parts/layout', get_row_layout() );
				do_action( 'adapt_dev_flex_section_after' );
			endwhile;
			do_action( 'adapt_dev_flex_loop_after' );
			?>
		<?php else : ?>
		<div class="entry-content">
				<?php the_content(); ?>
		</div><!--.entry-content-->
		<?php endif; ?>
	<?php endwhile;
endif; ?>
