<?php
/**
 * Billboard flexible content layout
 *
 * @package adaptdev/base
 * @since 2.0.0
 */

$media            = get_sub_field( 'media' );
$billboard_layout = get_sub_field( 'layout' );
$image_shape      = get_sub_field( 'shape' );

$added_classnames[] = 'billboard--' . $media;
$added_classnames[] = $billboard_layout;
$added_classnames[] = in_array( 'circle', $image_shape, true ) && $media === 'image' ? 'image-shape-circle' : '';

$headline   = get_sub_field( 'headline' );
$subheading = get_sub_field( 'subheading' );
$message    = get_sub_field( 'message' );

$button_link = get_sub_field( 'button_link' );
$button_file = get_sub_field( 'button_file' );
$button_args = array(
	'button_type'          => get_sub_field( 'button_type' ),
	'button_link'          => $button_link,
	'button_file'          => $button_file,
	'button_download_file' => get_sub_field( 'button_download_file' ),
	'button_style'         => get_sub_field( 'button_style' ),
	'button_color'         => get_sub_field( 'button_color' ),
	'button_label'         => get_sub_field( 'button_label' ),
);
?>

<section <?php adapt_dev_section_classes( $added_classnames ); ?>>
	<?php adapt_dev_section_heading(); ?>
	<div class="billboard-container">
		<div class="billboard__content">
			<?php if ( ! empty( $headline ) ) : ?>
				<h2 class="billboard__headline"><?php echo esc_html( $headline ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $subheading ) ) : ?>
				<h5 class="billboard__subheading"><?php echo esc_html( $subheading ); ?></h5>
			<?php endif; ?>

			<?php if ( ! empty( $message ) ) : ?>
				<div class="billboard__message entry-content"><?php echo $message; ?></div>
			<?php endif; ?>

			<?php if ( ! empty( $button_link ) || ! empty( $button_file ) ) : ?>
				<div class="billboard__cta-container">
					<?php get_template_part( 'template-parts/partials/button', '', $button_args ); ?>
				</div>
			<?php endif; ?>
		</div><!--.billboard__content-->
		<div class="billboard__media">
		<?php
		if ( 'video' === $media ) :
			$video = get_sub_field( 'video' );
			get_template_part( 'template-parts/partials/video', '', $video );
		elseif ( 'image' === $media ) :
			$image = get_sub_field( 'image' );
			get_template_part(
				'template-parts/partials/image',
				'',
				[
					'id'   => $image,
					'size' => 'large',
				]
			);
		endif;
		?>
		</div>
	</div>
</section>
