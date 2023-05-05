<?php
/**
 * Template header part for acf widget area.
 *
 * @package adaptdev/base
 */

global $adapt_dev_config;

$top_bar_content = (array) $adapt_dev_config['header_top_bar_content'];

$top_bar_text  = $adapt_dev_config['header_top_bar_text'];
$top_bar_phone = $adapt_dev_config['header_top_bar_phone'];

$top_bar_address_1 = $adapt_dev_config['address_1'];
$top_bar_address_2 = $adapt_dev_config['address_2'];
?>

<?php if ( $top_bar_content ) : ?>
	<?php if ( in_array( 'social', $top_bar_content, true ) ) : ?>
		<?php adapt_dev_the_social_icons(); ?>
	<?php endif; ?>

	<?php if ( in_array( 'text', $top_bar_content, true ) ) : ?>
			<?php if ( $top_bar_text ) : ?>
				<div class="top-bar__text">
					<p><?php echo wp_kses_post( $top_bar_text ); ?></p>
				</div>
			<?php endif; ?>
	<?php endif; ?>

	<?php if ( in_array( 'phone', $top_bar_content, true ) ) : ?>
			<?php if ( $top_bar_phone ) : ?>
				<div class="top-bar__phone">
					<a href="tel:<?php echo esc_html( $top_bar_phone ); ?>">
						<i class="fas fa-phone-alt"></i>
						<p><?php echo esc_html( $top_bar_phone ); ?></p>
					</a>
				</div>
			<?php endif; ?>
	<?php endif; ?>

	<?php if ( in_array( 'address', $top_bar_content, true ) ) : ?>
		<div class="top-bar__address">
			<i class="fas fa-map-marker-alt"></i>
			<a href="<?php adapt_dev_the_address_url(); ?>" target="_blank">
				<address class="address" itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
					<span class="street-address" itemprop="streetAddress">
						<?php echo esc_html( $top_bar_address_1 ); ?><?php echo $top_bar_address_2 ? ', ' . esc_html( $top_bar_address_2 ) : ''; ?>
					</span>
				</address>
			</a>
		</div>
	<?php endif; ?>
<?php endif; ?>
