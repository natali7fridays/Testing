<?php
/**
 * Flexible content page template
 *
 * A page template that includes the flex loop template part,
 * outputting flexible content fields in place of editor content.
 *
 * @package adaptdev/base
 */

?>
<?php get_header(); ?>

	<?php if ( function_exists( 'get_field' ) && get_field( 'page_hide_title' ) != 1 ) : ?>
		<header class="entry-header <?php echo get_field( 'page_align_title' ) == 1 ? 'aligned' : ''; ?> ">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<main class="main-content" id="content" role="main">
		<?php get_template_part( 'template-parts/loop', 'flex' ); ?>
	</main>

<?php get_footer(); ?>
