<?php
/**
 * Icon List
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

$list       = get_sub_field( 'list_items' );
$icon_color = get_sub_field( 'icon_color' );
?>

<section <?php adapt_dev_section_classes(); ?>>
	<div class="icon-list">
		<?php foreach ( $list as $list_item ) : ?>
			<div class="list-item">
				<div class="list-item--icon <?php echo esc_attr( $icon_color ); ?>">
					<?php echo wp_kses_post( $list_item['icon'] ); ?>
				</div>
				<div class="list-item--text">
					<?php
					if ( $list_item['list_item_type'] == 'text' ) :
						?>
						<?php echo wp_kses_post( $list_item['text'] ); ?>
						<?php
					else :
						?>
						<a href="<?php echo esc_url( $list_item['link']['url'] ); ?>"><?php echo esc_html( $list_item['link']['title'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
