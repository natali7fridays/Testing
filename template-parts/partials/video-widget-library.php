<?php
/**
 * Video template partial for widget library template page.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$video_url       = '';
$embed_url       = $args['embed_url'] ? $args['embed_url'] : 'https://www.youtube.com/watch?v=RzVvThhjAKw';
$width           = '';
$height          = '';
$loop            = '';
$autoplay        = '';
$poster          = $args['poster_url'] ? $args['poster_url'] : ADAPT_DEV_IMAGES . '/widget-library/video-poster.jpeg';
$starting_frame  = '';
$playsinline     = '';
$muted           = '';
$controlbar_hide = '';


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

<div class="wp-video-wrap hide-controls">
	<?php echo wp_video_shortcode( $attr );//phpcs:ignore ?>
</div>
