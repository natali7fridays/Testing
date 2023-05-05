<?php
/**
 * Contact Information partial
 *
 * Now with microdata!
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$contact_information = isset( $args['contact_information'] ) ? $args['contact_information'] : false;

if ( $contact_information ) :
	[
		'type' => $contact_type,
		'name' => $name,
		'email' => $email,
		'telephone' => $telephone,
		'address' => $address,
		'city' => $city,
		'state' => $state,
		'postal_code' => $postal_code
	] = $contact_information;
	?>

	<div itemscope itemtype="<?php echo $contact_type ? 'https://schema.org/' . esc_attr( $contact_type ) : ''; ?>">
		<?php if ( $name ) : ?>
			<h3><span itemprop="name"><?php echo esc_html( $name ); ?></span></h3>
		<?php endif; ?>

		<?php if ( $address ) : ?>
			<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
				<span itemprop="streetAddress"><?php echo esc_html( $address ); ?></span>

				<br>

				<?php if ( $city ) : ?>
					<span itemprop="addressLocality"><?php echo esc_html( $city ) . ', '; ?></span>
				<?php endif; ?>

				<?php if ( $state ) : ?>
					<span itemprop="addressRegion"><?php echo esc_html( $state ); ?></span>
				<?php endif; ?>

				<?php if ( $postal_code ) : ?>
					<span itemprop="postalCode"><?php echo ' ' . esc_html( $postal_code ); ?></span>
				<?php endif; ?>
			</div><!--address-->
		<?php endif; ?>

		<?php if ( $telephone ) : ?>
			<span itemprop="telephone"><?php echo esc_html( 'telephone' ); ?></span>

			<br>
		<?php endif; ?>

		<?php if ( $email ) : ?>
			<a href="mailto:<?php echo esc_attr( $email ); ?>" itemprop="email"><?php echo esc_html( $email ); ?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>
