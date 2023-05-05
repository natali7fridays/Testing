<?php
/**
 * Sign up form layout for flex content
 *
 * @package base_teamsi
 * @since 1.0.0
 */

$form_id      = get_sub_field( 'gf_widget_form_id' );
$form_options = get_sub_field( 'form_options' );

$form_title = in_array( 'title', $form_options['title_description'], true ) ? true : false;
$form_desc  = in_array( 'description', $form_options['title_description'], true ) ? true : false;

?>

<section <?php adapt_dev_section_classes(); ?>>
		<?php adapt_dev_section_heading(); ?>
		<div class="layout--gravity-form--form-wrap">
			<?php gravity_form( $form_id, $form_title, $form_desc, false, '', true ); ?>
		</div>
</section>
