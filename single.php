<?php
/**
 * Flexible content page template
 *
 * A page template that includes the flex loop template part,
 * outputting flexible content fields in place of editor content.
 *
 * @package adaptdev/base
 */

//phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

?>
<?php get_header(); ?>



	<main class="main-content" id="content" role="main">
		<?php
		get_template_part( 'template-parts/content-single' );

		if ( is_attachment() ) {
			// Parent post navigation.
			the_post_navigation(
				array(
					/* translators: %s: Parent post link. */
					'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'adapt_dev' ), '%title' ),
				)
			);
		}

		// If comments are open or there is at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

		// Previous/next post navigation.
		$next = '<i class="fas fa-arrow-alt-right"></i>';
		$prev = '<i class="fas fa-arrow-alt-left"></i>';

		$next_label     = esc_html__( 'Next', 'adapt_dev' );
		$previous_label = esc_html__( 'Prev', 'adapt_dev' );


		the_post_navigation(
			array(
				'next_text' => '<span class="meta-nav">' . $next_label . ' ' . $next . '</span>',
				'prev_text' => '<span class="meta-nav">' . $prev . ' ' . $previous_label . '</span>',
			)
		);
		?>

	</main>

<?php get_footer(); ?>
