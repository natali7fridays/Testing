<?php
/**
 * Image template partial
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$image_id   = isset( $args['id'] ) ? $args['id'] : get_sub_field( 'image' );
$image_size = isset( $args['size'] ) ? $args['size'] : 'medium';

$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
echo wp_get_attachment_image( $image_id, $image_size, false, array( 'alt' => $image_alt ) );

