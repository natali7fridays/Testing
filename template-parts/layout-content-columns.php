<?php
/**
 * Columns flexible content layout
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$heading = get_sub_field( 'heading' );
$columns = get_sub_field( 'columns' ); ?>

<section <?php adapt_dev_section_classes(); ?>>
	<?php if ( $heading ) : ?>
	<h2><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<?php if ( have_rows( 'columns' ) ) : ?>
		<?php while ( have_rows( 'columns' ) ) : ?>
			<?php the_row(); ?>
			<div class="column">
				<?php get_template_part( 'template-parts/content-column', '' ); ?>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
</section>
