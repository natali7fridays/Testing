<?php
/**
 * Flexible content page template
 *
 * A page template that includes the flex loop template part,
 * outputting flexible content fields in place of editor content.
 *
 * @package adaptdev/base
 *
 * Template Name: Events Template
 */

$adapt_dev_events_header_bg      = get_field( 'events_header_background', 'option' ) ? wp_get_attachment_image_src( get_field( 'events_header_background', 'option' ), 'full' ) : false;
$adapt_dev_featured_img_url      = $adapt_dev_events_header_bg ? $adapt_dev_events_header_bg : wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
$adapt_dev_header_is_visible     = is_single() ? get_field( 'events_display_header_on_single', 'option' ) : get_field( 'events_display_header', 'option' );
$adapt_dev_header_section_height = get_field( 'section_height', 'option' );
?>

<?php get_header(); ?>

	<?php if ( function_exists( 'get_field' ) && get_field( 'page_hide_title' ) != 1 && $adapt_dev_header_is_visible ) : ?>
		<header class="entry-header events-header <?php echo get_field( 'page_align_title' ) == 1 ? 'aligned' : ''; ?> <?php echo $adapt_dev_featured_img_url ? 'has-bg-img' : ''; ?> <?php echo 'min-height-' . esc_attr( $adapt_dev_header_section_height ); ?>"

		<?php if ( $adapt_dev_featured_img_url ) : ?>
			style="--entry-background-image:url(<?php echo esc_html( $adapt_dev_featured_img_url[0] ); ?>);"
		<?php endif; ?>	

		><!--header-->
		<div class="cta">
			<h1 class="cta__title"><?php the_field( 'events_heading', 'option' ); ?></h1>
			<div class="entry-content cta__content"><?php the_field( 'events_subheading', 'option' ); ?></div>
		</div>
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
