<?php
/**
 * Video template partial
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( ! empty( $args ) ) {
	[
		'video' => $video_url,
		'embed' => $embed_url,
		'video-width' => $width,
		'video-height' => $height,
		'loop-video' => $loop,
		'autoplay' => $autoplay,
		'poster' => $poster,
		'starting_frame' => $starting_frame,
		'playsinline' => $playsinline,
		'muted' => $muted,
		'controlbar-hide' => $controlbar_hide,
	] = $args;
} else {
	$video_url       = get_sub_field( 'video' );
	$embed_url       = get_sub_field( 'embed' );
	$width           = get_sub_field( 'video-width' );
	$height          = get_sub_field( 'video-height' );
	$loop            = get_sub_field( 'loop-video' );
	$autoplay        = get_sub_field( 'autoplay' );
	$poster          = get_sub_field( 'poster' );
	$starting_frame  = get_sub_field( 'starting_frame' );
	$playsinline     = get_sub_field( 'playsinline' );
	$muted           = get_sub_field( 'muted' );
	$controlbar_hide = get_sub_field( 'controlbar-hide' );
}

if ( empty( $width ) ) {
	$width = '640';
}

if ( empty( $height ) ) {
	$height = $width / ( '16' / '9' );
}

if ( empty( $video_url ) ) {
	$video_src = $embed_url;
} else {
	$video_src = $video_url;
	if ( ! empty( $starting_frame ) ) {
		$video_src = $video_src . '#t=' . $starting_frame;
	}
}

$attr = array(
	'src'            => $video_src,
	'width'          => $width,
	'height'         => $height,
	'autoplay'       => $autoplay,
	'loop'           => $loop,
	'poster'         => $poster,
	'starting_frame' => $starting_frame,
	'playsinline'    => $playsinline,
	'muted'          => $muted,
);
?>

<div class="wp-video-wrap <?php echo $controlbar_hide && in_array( 'yes', $controlbar_hide, true ) ? 'hide-controls' : ''; ?>">
	<?php echo adapt_dev_video_shortcode( $attr );//phpcs:ignore ?>
</div>
