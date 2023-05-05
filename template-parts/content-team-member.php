<?php
/**
 * Content for Team
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

 //phpcs:disable WordPress.NamingConventions.PrefixAllGlobals
 $permalink = get_field( 'adapt_dev_custom_post_types_options_team_members_permalinks', 'options' )
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<?php
		$post_content = 'post-content-full';
	if ( has_post_thumbnail( $post->ID ) ) {
		$post_content = 'post-content';
		?>
			<div class="thumb">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
			</div><!-- thumb -->
	<?php } ?>
	<div class="the-content <?php echo esc_html_e( $post_content ); ?>">
		<header class="post-header">
			<h2 class="post-title">
				<?php if ( $permalink ) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				<?php 
				else :
					the_title();
				endif; 
				?>
				</h2>
			
			<?php
			$title = get_field( 'title' );
			if ( ! empty( $title ) ) {
				echo '<p class="entry-subheading">' . esc_html( $title ) . '</p>';
			}
			?>
		</header>

		<?php if ( get_field( 'email' ) || get_field( 'phone' ) ) : ?>
			<div class="contact-info">

				<?php if ( $email = get_field( 'email' ) ) : ?>
					
					<a class="email" href="mailto:<?php echo esc_html( $email ); ?>"><i class="fas fa-envelope"></i> <?php echo esc_html( $email ); ?></a>
					
				<?php endif; ?>
				<?php if ( $phone = get_field( 'phone' ) ) : ?>
					
					<a class="phone" href="tel:<?php esc_html( $phone ); ?>"><i class="fas fa-phone-alt"></i> <?php echo esc_html( $phone ); ?></a>
				
				<?php endif; ?>

			</div>
		<?php endif; ?>
		<?php
		if ( $args['show_excerpt'] || $args['layout'] == 'rows' ) :
			?>
			<div class="entry-content">
				<?php adapt_dev_excerpt(); ?>
			</div>
		<?php endif; ?>
		<?php if ( $permalink ) : ?>
			<div class="learn-more"><a href="<?php the_permalink(); ?>" class="entry__cta" title="<?php printf( esc_attr__( 'Permalink to %s', 'wego_fran' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">Read More</a></div>
		<?php endif; ?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
