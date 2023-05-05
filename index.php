<?php
/**
 * Index Template - This is the template that is used for the Post type archive page (aka blog page)
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

//phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$archive_layout = get_field( 'post_archive_layout', 'option' );
?>

<?php get_header(); ?>
	<?php
	$_blog_id = get_option( 'page_for_posts' );
	if ( is_home() ) :
		$_blog_id = get_option( 'page_for_posts' );
		if ( function_exists( 'get_field' ) && get_field( 'page_hide_title', $_blog_id ) != 1 ) :
			?>
			<header class="entry-header <?php echo get_field( 'page_align_title', $_blog_id ) == 1 ? 'aligned' : ''; ?> ">
				<h1 class="entry-title"><?php echo esc_html( get_the_title( $_blog_id ) ); ?></h1>
			</header>
			<?php
		endif;
	endif;
	?>

	<main class="page-full main-content" id="content" role="main">
		<div class="container">
			<?php
			if ( have_posts() ) :
				$filtered  = ( isset( $_GET['category'] ) ) ? true : false;//phpcs:ignore
				$filter_by = $_GET['category'];//phpcs:ignore
				$_taxonomy = 'category';
				$terms     = get_terms( $_taxonomy );

				if ( count( $terms ) > 1 ) :
					?>
				<div class="toggle-filter-container">
					<div class="filter-container">
						<select class="filter-posts" name="post-filter" data-base="<?php echo esc_attr( remove_query_arg( $_taxonomy, get_pagenum_link() ) ); ?>">
							<option value="">View All</option>
							<?php foreach ( $terms as $_term ) : ?>
								<option 
									<?php
									if ( $filtered && $filter_by == $_term->slug ) :
										echo 'selected ';
									endif;
									?>
									value="<?php echo esc_attr( $_term->slug ); ?>">
										<?php echo esc_html( $_term->name ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<?php endif; ?>
				<div class="posts-container <?php echo $archive_layout ? esc_html( $archive_layout ) : 'list-view'; ?>">
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
