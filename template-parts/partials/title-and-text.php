<?php
/**
 * Editor content template partial
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( ! empty( $args ) ) {
	[
		'pre_title' => $this_pre_title,
		'title'     => $this_title,
		'text'      => $this_text
	] = $args;
} else {
	$this_title = get_sub_field( 'title' );
	$this_text  = get_sub_field( 'text' );
}
?>
<h4 class="ttx__pre_title">
	<?php echo esc_html( $this_pre_title ); ?>
</h4>
<h3 class="ttx__title">
	<?php echo esc_html( $this_title ); ?>
</h3>
<p class="ttx__text">
	<?php echo wp_kses_post( $this_text ); ?>
</p>
