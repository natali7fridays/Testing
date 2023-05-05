<?php
/**
 * Cards flexible content layout
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

$cards       = get_sub_field( 'cards' );
$card_layout = get_sub_field( 'layout' );

if ( ! empty( $cards ) ) : ?>
	<section <?php adapt_dev_section_classes(); ?>>
		<?php adapt_dev_section_heading(); ?>
		<div class="rows">
			<?php
			foreach ( $cards as $card ) :
				$card['layout'] = $card_layout;
				get_template_part( 'template-parts/partials/card', $card_layout, $card );
			endforeach;
			?>
		</div>
	</section>
	<?php
endif;
