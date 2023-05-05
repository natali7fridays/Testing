<?php
/**
 * Template for flex content
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( ! empty( $args ) ) :
	$image = [
		'id'   => $args['image'],
		'size' => 'medium',
	];

	$title_and_text = [
		'title' => $args['title'],
		'text'  => $args['text'],
	]; ?>

	<div class="feature">
		<div class="feature__image">
			<?php get_template_part( 'template-parts/partials/image', '', $image ); ?>
		</div>

		<div class="feature__ttx">
			<?php get_template_part( 'template-parts/partials/title-and-text', '', $title_and_text ); ?>
		</div>
	</div>
<?php endif; ?>
