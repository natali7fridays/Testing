<?php
/**
 * Profile card layout
 *
 * @package adaptdev/base
 * @since 3.0.0
 */

[
	'heading' => $card_heading,
	'subheading' => $card_subheading,
	'icon' => $card_icon_id,
	'image' => $card_image_id,
	'text' => $card_text,
	'link' => $card_link,
	'layout' => $card_layout
] = $args;
?>

<div class="card card--<?php echo esc_attr( $card_layout ); ?>">
	<div class="card__header">
		<?php
		if ( ! empty( $card_image_id ) ) :
			echo wp_get_attachment_image(
				$card_image_id,
				[ 358, 193 ],
				false,
				[
					'class' => 'card__img',
					'sizes' => '(min-width: 748px) 100%, 100vw',
				]
			);
		endif;
		?>

		<?php
		if ( ! empty( $card_icon_id ) ) :
			echo wp_get_attachment_image( $card_icon_id, [ 66, 66 ], true, [ 'class' => 'card__icon' ] );
		endif;
		?>
	</div><!--.card__header-->

	<div class="card__content">
		<?php if ( ! empty( $card_heading ) ) : ?>
			<?php if ( empty( $card_link ) ) : ?>
				<h3 class="card__heading"><?php echo esc_html( $card_heading ); ?></h3>
			<?php else : ?>
				<h3 class="card__heading"><a href="<?php echo esc_attr( $card_link['url'] ); ?>"><?php echo esc_html( $card_heading ); ?></a></h3>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! empty( $card_text ) ) : ?>
			<div class="card__text">
				<?php echo apply_filters( 'the_content', $card_text ); //phpcs:ignore ?>
			</div><!--.card__text-->
		<?php endif; ?>

		<?php if ( ! empty( $card_link ) ) : ?>
			<a class="bg-shade text-uppercase card__link" href="<?php echo esc_attr( $card_link['url'] ); ?>" target="<?php echo esc_attr( $card_link['target'] ); ?>"><?php echo esc_html( $card_link['title'] ); ?></a>
		<?php endif; ?>
	</div><!--card__content-->
</div><!--.card-->
