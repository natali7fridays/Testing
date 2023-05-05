<?php
/**
 * Footer Template
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

global $adapt_dev_config;

$adapt_dev_sf_links              = $adapt_dev_config['sub_footer_links'];
$adapt_dev_sf_social_links       = $adapt_dev_config['sub_footer_social_icons_toggle'];
$adapt_dev_footer_bottom_toggle  = $adapt_dev_config['footer_bottom_toggle'];
$adapt_dev_center_footer_widgets = $adapt_dev_config['footer_widgets_center_widgets'];
$adapt_dev_footer_widget_areas   = $adapt_dev_config['footer_widget_areas'];

?>

		<?php do_action( 'adapt_dev_footer_before' ); ?>
		<footer class="site-footer<?php echo $adapt_dev_center_footer_widgets ? ' center-align-widgets' : ''; ?>">
			<?php do_action( 'adapt_dev_footer_top' ); ?>

			<?php if ( is_array( $adapt_dev_footer_widget_areas ) ) : ?>
				<ul class="site-footer__widgets">
					<?php
					foreach ( $adapt_dev_footer_widget_areas as $adapt_dev_footer_widget_area ) {
						if ( is_active_sidebar( $adapt_dev_footer_widget_area ) ) {
							echo '<li>';
							dynamic_sidebar( $adapt_dev_footer_widget_area );
							echo '</li>';
						}
					}
					?>
				</ul><!--.site-footer__widgets-->
			<?php endif; ?>

			<?php do_action( 'adapt_dev_footer_bottom' ); ?>
		</footer>
		<?php do_action( 'adapt_dev_footer_after' ); ?>

		<?php if ( $adapt_dev_footer_bottom_toggle == '1' ) : ?>
			<div class="site-info">
				<div class="col copyright_and_links">
					<div class="copyright">
						Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
						<a href="<?php echo esc_html( get_site_url() ); ?>" class="footer-site-name">
							<?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <span>All Rights Reserved.</span>
						</a>
					</div>

					<?php if ( $adapt_dev_sf_links ) : ?>
						<div class="sub-footer-links">
							<?php foreach ( $adapt_dev_sf_links as $adapt_dev_sf_link ) : ?>

								<?php if ( $adapt_dev_sf_link['link'] ) : ?>
									<span>
										<a href="<?php echo esc_html( $adapt_dev_sf_link['link']['url'] ); ?>" target="<?php echo $adapt_dev_sf_link['link']['target'] ? esc_html( $adapt_dev_sf_link['link']['target'] ) : '_self'; ?>">
											<?php echo esc_html( $adapt_dev_sf_link['link']['title'] ); ?>
										</a>
									</span>
								<?php endif; ?>

							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $adapt_dev_sf_social_links == '1' ) : ?>
					<div class="col social">
						<div class="social-icons">
							<?php adapt_dev_the_social_icons(); ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php wp_footer(); ?>

		<?php do_action( 'adapt_dev_body_close' ); ?>
	</body>
</html>
