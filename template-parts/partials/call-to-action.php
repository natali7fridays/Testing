<?php
/**
 * Call To Action partial
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( isset( $args['call-to-action'] ) ) :
	[
		'pre_title' => $cta_pre_title,
		'title' => $cta_title,
		'text' => $cta_text,
		'button' => $button,
	] = $args['call-to-action']; ?>

	<div class="cta">
		<?php if ( $cta_pre_title ) : ?>

			<?php if ( $args['hero'] ) : ?>
				<h2 class="cta__pre_title"><?php echo esc_html( $cta_pre_title ); ?></h2>
			<?php else : ?>
				<h4 class="cta__pre_title"><?php echo esc_html( $cta_pre_title ); ?></h4>
			<?php endif; ?>

		<?php endif; ?>
		<?php if ( $cta_title ) : ?>

			<?php if ( $args['hero'] ) : ?>
				<h1 class="cta__title"><?php echo esc_html( $cta_title ); ?></h1>
			<?php else : ?>
				<h3 class="cta__title"><?php echo esc_html( $cta_title ); ?></h3>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( $cta_text ) : ?>
			<div class="entry-content cta__content">
				<p><?php echo wp_kses_post( $cta_text ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( $button ) : ?>
			<div class="cta__button">
				<?php get_template_part( 'template-parts/partials/button', '', $button ); ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
