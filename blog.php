<?php
/**
 * Blog Template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

?>

<?php get_header(); ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<section class="banner-inner" style="background-image: url('<?php echo trailingslashit( ADAPT_DEV_IMAGES ) . 'header-blog.jpg'; ?>');">
		<div class="module">
			<div class="page-title-wrap">
				<h1 class="page-title">Our Blog</h1>
			</div>
		</div>
	</section>

	<main class="group page-cols main-content" id="content" role="main">

		<div class="module">

			<div class="col-1 cf">

				<div class="blog-wrap">
					<?php
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //phpcs:ignore
						query_posts( 'post_type=post&paged=' . $paged ); //phpcs:ignore
						$page_var = get_query_var( 'paged' ); //phpcs:ignore
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							?>
							<?php get_template_part( 'content' ); ?>

										<?php endwhile; ?>
				</div><!-- blog-wrap -->
				<?php endif; ?>

				<?php if ( function_exists( 'adapt_dev_paging_nav' ) ) : ?>
					<div class="paginate">
						<?php adapt_dev_paging_nav(); ?>
					</div>
				<?php endif; ?>

			</div><!-- col-1 -->

			<?php get_sidebar( 'blog' ); ?>

		</div><!-- module -->

	</main><!-- group -->
	<?php get_footer(); ?>
