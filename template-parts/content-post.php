<?php
/**
 * Content for a post
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

 //phpcs:disable WordPress.NamingConventions.PrefixAllGlobals

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		<?php
		$post_content = 'post-content';
		?>
		<div class="thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php
			if ( has_post_thumbnail( $post->ID ) ) :
				the_post_thumbnail( 'medium' );
				else :
					$thumbnail = get_field( 'sitewide_placeholder_image', 'option' );
					if ( ! empty( $thumbnail ) ) :
						$placeholder = wp_get_attachment_image( $thumbnail, 'medium' );
						echo wp_kses_post( $placeholder );
						else :
							echo '<img src="' . esc_url( ADAPT_DEV_IMAGES ) . '/placeholder-image.jpg" />';
					endif;
			endif;
				?>
			</a>
		</div><!-- thumb -->
	<div class="the-content <?php echo esc_html_e( $post_content ); ?>">
		<header class="post-header">
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		</header>

		<div class="entry-content">
			<?php adapt_dev_excerpt(); ?>
		</div>

		<div class="learn-more"><a href="<?php the_permalink(); ?>" class="entry__cta btn" title="<?php printf( esc_attr__( 'Permalink to %s', 'wego_fran' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">Read More</a></div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
