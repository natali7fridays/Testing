<?php
/**
 * Address partial with Google Maps get directions
 *
 * @package adapt_dev
 * @since 1.0.0
 */

$address   = isset( $args['address'] ) ? $args['address'] : false;
$gmaps_dir = isset( $args['get_directions'] ) ? true : false;

if ( $address ) :
	[
		'address_line_1' => $address_line_1,
		'address_line_2' => $address_line_2,
		'city' => $city,
		'state' => $state,
		'zip_code' => $zip_code,
	] = $address;
else :
	/* Fallback information */
	$address = array(
		'address_line_1' => '2300 Cottondale Lane',
		'address_line_2' => 'Suite 300',
		'city'           => 'Little Rock',
		'state'          => 'AR',
		'zip_code'       => '72202',
	);
	[
		'address_line_1' => $address_line_1,
		'address_line_2' => $address_line_2,
		'city' => $city,
		'state' => $state,
		'zip_code' => $zip_code,
	]        = $address;
endif; ?>
<address>
	<?php if ( $gmaps_dir ) : ?>
		<a href="<?php echo esc_url( adapt_dev_gmaps_directions( $address ) ); ?>" target="_blank">
	<?php endif; ?>

		<?php if ( $address_line_1 ) : ?>
			<span class="addr-1"><?php echo esc_html( $address_line_1 ); ?></span>
		<?php endif; ?>

		<?php if ( $address_line_2 ) : ?>
			<span class="addr-2"><?php echo esc_html( $address_line_2 ); ?></span>
		<?php endif; ?>

		<?php if ( $city || $state || $zip_code ) : ?>
			<span class="city-state-zip">
				<?php
				if ( $city ) :
					echo esc_html( $city ) . ', ';
				endif;
				if ( $state ) :
					echo esc_html( $state ) . ' ';
				endif;
				if ( $zip_code ) :
					echo esc_html( $zip_code );
				endif;
				?>
			</span>
		<?php endif; ?>

	<?php if ( $gmaps_dir ) : ?>
		</a>
	<?php endif; ?>
</address>

