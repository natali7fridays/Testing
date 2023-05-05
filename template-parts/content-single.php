<?php
/**
 * Content Single
 *
 * A content single template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php 
		$post_type = get_post_type();
		if ( 'post' === $post_type ) :
			$blog_id = get_option( 'page_for_posts' );
			if ( $blog_id ) :
				$alignment = ( get_field('page_align_title', $blog_id ) ) ? 'aligned' : '';
				$title = get_the_title( get_option( 'page_for_posts' ) );
			else :
				$alignment = 'aligned';
				$title = 'Blog';
			endif;
		else :
			$alignment = 'aligned';
			$obj = get_post_type_object( $post_type );
			$title = $obj->labels->name;
		endif;
	?>
	<header class="entry-header <?php echo $alignment; ?>">
		<h1 class="entry-title"><?php echo $title; ?></h1>
	</header><!-- .entry-header -->

	<div class="container single-container">
		<div class="entry-content">
			<?php
			adapt_dev_post_thumbnail();

			the_content();

			wp_link_pages(
				array(
					'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'adapt_dev' ) . '">',
					'after'    => '</nav>',
					/* translators: %: Page number. */
					'pagelink' => esc_html__( 'Page %', 'adapt_dev' ),
				)
			);
			?>
			<?php if ( ! get_field( 'hide_post_meta', 'option' ) ) : ?>
				<footer class="entry-footer default-max-width">
					<?php // adapt_dev_entry_meta_footer(); ?>
				</footer><!-- .entry-footer -->
			<?php endif; ?>
		</div><!-- .entry-content -->
	</div>

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php // get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
