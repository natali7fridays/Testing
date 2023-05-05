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

	<?php if ( function_exists( 'get_field' ) && get_field( 'page_hide_title' ) != 1 ) : ?>
		<header class="entry-header testing <?php echo get_field( 'page_align_title' ) == 1 ? 'aligned' : ''; ?> ">
			<h1 class="entry-title">Our Team</h1>
		</header>
	<?php endif; ?>

	<main class="main-content container" id="content" role="main">
		<div class="column-left">
			<?php
			if ( has_post_thumbnail( $post->ID ) ) :
				?>
				<div class="entry-thumbnail team-portrait">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
			<?php
			$subheading = get_field( 'subheading' );
			if ( ! empty( $subheading ) ) {
				echo '<p class="entry-subheading">' . esc_html( $subheading ) . '</p>';
			}
			?>
		</div>
		<div class="column-right entry-content">
			<?php the_content(); ?>
		</div>
	</main>

<?php get_footer(); ?>
