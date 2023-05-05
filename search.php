<?php
/**
 * Search Template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

get_header();
?>

<?php if ( have_posts() ) : ?>
<header class="entry-header">
	<h1 class="entry-title">
		<?php
		printf(
			/* translators: %s: Search term. */
			esc_html__( 'Results for "%s"', 'adapt_dev' ),
			'<span class="page-description search-term">' . esc_html( get_search_query() ) . '</span>'
		);
		?>
	</h1>
</header><!-- .page-header -->

<main class="page-full main-content" id="content" role="main">
	<div class="container">
		<div class="search-result-count guttered">
			<?php
			printf(
				esc_html(
					/* translators: %d: The number of search results. */
					_n(
						'We found %d result for your search.',
						'We found %d results for your search.',
						(int) $wp_query->found_posts,
						'adapt_dev'
					)
				),
				(int) $wp_query->found_posts
			);
			?>
		</div><!-- .search-result-count -->

		<div class="posts-container list-view">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'post' );

				endwhile;
			?>
		</div> <!-- posts-container -->

		<?php if ( function_exists( 'adapt_dev_paging_nav' ) ) : ?>
			<div class="paginate">
				<?php adapt_dev_paging_nav(); ?>
			</div>
		<?php endif; ?>
	</div>

</main>


<?php else : ?>
	<?php get_template_part( 'template-parts/content-none' ); ?>
<?php endif; ?>

<?php
get_footer();
?>
