<?php
/**
 * Index Template - This is the template that is used for the Post type archive page (aka blog page)
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

?>

<?php get_header(); ?>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php if ( is_category() ) : ?>
				Category: <?php echo single_cat_title( '', false ); ?>
			<?php elseif ( is_tag() ) : ?>
				Tag: <?php single_tag_title(); ?>
			<?php elseif ( is_archive() ) : ?>
				Archive: <?php the_time( 'F Y' ); ?>
			<?php else : ?>
				<?php the_title(); ?>
			<?php endif; ?>
		</h1>
	</header>

	<main class="page-full main-content" id="content" role="main">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="posts-container list-view">
					<?php
					get_template_part( 'template-parts/partials/loading' );
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'post' );

					endwhile;
					?>
				</div> <!-- posts-container -->
			<?php endif; ?>

			<?php if ( function_exists( 'adapt_dev_paging_nav' ) ) : ?>
				<div class="paginate">
					<?php adapt_dev_paging_nav(); ?>
				</div>
			<?php endif; ?>
		</div>

	</main><!-- page-cols -->

<?php get_footer(); ?>
