<?php
/**
 * Full Page Template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

?>
<?php get_header(); ?>

	<?php if ( function_exists( 'get_field' ) && get_field( 'page_hide_title' ) != 1 ) : ?>
		<header class="entry-header <?php echo get_field( 'page_align_title' ) == 1 ? 'aligned' : ''; ?> ">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<main class="group page-full main-content">
		<?php get_template_part( 'template-parts/loop', 'flex' ); ?>
	</main><!-- page-cols -->

<?php get_footer(); ?>
