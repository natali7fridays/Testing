<?php
/**
 * Flexible content page template
 *
 * A page template that includes the flex loop template part,
 * outputting flexible content fields in place of editor content.
 *
 * @package adaptdev/base
 */

$adapt_dev_featured_img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
?>

<?php get_header(); ?>

	<?php if ( function_exists( 'get_field' ) && get_field( 'page_hide_title' ) != 1 ) : ?>
		<header class="entry-header <?php echo get_field( 'page_align_title' ) == 1 ? 'aligned' : ''; ?> <?php echo $adapt_dev_featured_img_url ? 'has-bg-img' : ''; ?>"

		<?php if ( $adapt_dev_featured_img_url ) : ?>
			style="--entry-background-image:url(<?php echo esc_html( $adapt_dev_featured_img_url[0] ); ?>);"
		<?php endif; ?>	

		><!--header-->
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<?php do_action( 'adapt_dev_content_before' ); ?>
	<main class="main-content" id="content" role="main">
		<?php do_action( 'adapt_dev_content_top' ); ?>
		<?php get_template_part( 'template-parts/loop', 'flex' ); ?>
		<?php do_action( 'adapt_dev_content_bottom' ); ?>
	</main>
	<?php do_action( 'adapt_dev_content_after' ); ?>

<?php get_footer(); ?>
