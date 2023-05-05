<?php
/**
 * Polaroid card layout
 *
 * @package adaptdev/base
 * @since 3.0.0
 */

[
	'heading' => $card_heading,
	'background_image' => $card_bg,
	'icon' => $card_icon_id,
	'icon_fa' => $card_icon_fa,
	'icon_format' => $card_icon_format,
	'link' => $card_link,
	'layout' => $card_layout
] = $args;

$card_bg_url = wp_get_attachment_image_url( $card_bg, 'postcard-bg', false );
?>

<div class="bg-off-light text-center card card--<?php echo esc_attr( $card_layout ); ?>" style="<?php echo $card_bg ? 'background-image: url( ' . esc_attr( $card_bg_url ) . ');' : ''; ?>">

	<?php if ( ! empty( $card_heading ) ) : ?>
		<?php if ( empty( $card_link ) ) : ?>
			<h2 class="card__heading"><?php echo esc_html( $card_heading ); ?></h2>
		<?php else : ?>
			<h2 class="card__heading"><a href="<?php echo esc_attr( $card_link['url'] ); ?>"><?php echo esc_html( $card_heading ); ?></a></h2>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! empty( $card_link ) ) : ?>
		<a class="text-uppercase card__link" href="<?php echo esc_attr( $card_link['url'] ); ?>" target="<?php echo esc_attr( $card_link['target'] ? $card_link['target'] : '_self' ); ?>">
	<?php endif; ?>

	<?php
	if ( ! empty( $card_icon_id ) && $card_icon_format == 'image' ) :
		echo wp_get_attachment_image( $card_icon_id, [ 66, 66 ], true, [ 'class' => 'card__icon-img' ] );
	endif;
	?>

	<?php
	if ( ! empty( $card_icon_fa ) && $card_icon_format == 'fa-icon' ) :
		echo '<div class="card__icon">' . wp_kses_post( $card_icon_fa ) . '</div>';
	endif;
	?>

	<?php if ( ! empty( $card_link ) ) : ?>
		</a>
	<?php endif; ?>

</div><!--.card-->
