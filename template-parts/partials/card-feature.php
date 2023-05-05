<?php
/**
 * Feature/benefit card layout
 *
 * @package adaptdev/base
 * @since 3.0.0
 */

[
	'heading' => $card_heading,
	'subheading' => $card_subheading,
	'icon_format' => $card_icon_format,
	'icon' => $card_icon_id,
	'icon_fa' => $card_icon_fa,
	'image' => $card_image_id,
	'text' => $card_text,
	'link' => $card_link,
	'layout' => $card_layout
] = $args;
?>

<div class="text-center card card--<?php echo esc_attr( $card_layout ); ?>">
	<?php
	if ( ! empty( $card_icon_id ) && $card_icon_format == 'image' ) :
		echo wp_get_attachment_image( $card_icon_id, [ 84, 84 ], true, [ 'class' => 'card__icon-img' ] );
	endif;
	?>

	<?php
	if ( ! empty( $card_icon_fa ) && $card_icon_format == 'fa-icon' ) :
		echo '<div class="card__icon">' . wp_kses_post( $card_icon_fa ) . '</div>';
	endif;
	?>

	<?php if ( ! empty( $card_heading ) ) : ?>
		<h3 class="card__heading text-uppercase"><?php echo esc_html( $card_heading ); ?></h3>
	<?php endif; ?>

	<?php if ( ! empty( $card_text ) ) : ?>
		<div class="card__text">
			<?php echo apply_filters( 'the_content', $card_text ); //phpcs:ignore ?>
		</div><!--.card__text-->
	<?php endif; ?>
</div><!--.card-->
