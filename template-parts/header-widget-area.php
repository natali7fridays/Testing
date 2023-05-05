<?php
/**
 * Template header part for acf widget area.
 *
 * @package adaptdev/base
 */

global $adapt_dev_config;

$widget_types = $adapt_dev_config['header_widget_type'];

$cta_button = $adapt_dev_config['header_cta_button'];
$phone      = $adapt_dev_config['header_phone'];
$text_area  = $adapt_dev_config['header_widget_text'];
?>

<?php if ( $widget_types && is_array( $widget_types ) ) : ?>

	<?php if ( in_array( 'text', $widget_types, true ) ) : ?>
			<?php if ( $text_area ) : ?>
				<div class="text-widget">
					<p><?php echo wp_kses_post( $text_area ); ?></p>
				</div>
			<?php endif; ?>
	<?php endif; ?>

	<?php if ( in_array( 'phone', $widget_types, true ) ) : ?>
			<?php if ( $phone ) : ?>
				<div class="phone-widget">
					<a href="tel:<?php echo esc_html( $phone['number'] ); ?>">
						<?php if ( in_array( 'yes', $phone['show_phone_icon'], true ) ) : ?>
							<i class="fas fa-mobile-alt"></i>
						<?php endif; ?>
						<h4><?php echo esc_html( $phone['number'] ); ?></h4>
					</a>

					<?php if ( $phone['sub_text'] ) : ?>
						<h5><?php echo esc_html( $phone['sub_text'] ); ?></h5>
					<?php endif; ?>
				</div>
			<?php endif; ?>
	<?php endif; ?>

	<?php if ( in_array( 'address', $widget_types, true ) ) : ?>
		<div class="address-widget">
			<i class="fas fa-map-marker-alt"></i>
			<a href="<?php adapt_dev_the_address_url(); ?>" target="_blank">
				<?php adapt_dev_the_address(); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if ( in_array( 'social', $widget_types, true ) ) : ?>
		<div class="social-widget">
			<?php adapt_dev_the_social_icons(); ?>
		</div>
	<?php endif; ?>

	<?php if ( in_array( 'nav', $widget_types, true ) ) : ?>
		<?php get_template_part( 'template-parts/nav-alt', '', ); ?>
	<?php endif; ?>

	<?php if ( in_array( 'button', $widget_types, true ) ) : ?>
		<?php if ( $cta_button ) : ?>
			<a href="<?php echo esc_html( $cta_button['url'] ); ?>" target="<?php echo esc_html( $cta_button['target'] ? $cta_button['target'] : '_self' ); ?>" class="btn btn-primary">
				<?php echo esc_html( $cta_button['title'] ); ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>

<?php endif; ?>
