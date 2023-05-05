<?php
/**
 * Changes to the post wysiwyg eidtor.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Cta button builder form
 * Update CSS for .btn-preview below to match your theme's button style in admin.
 */
function adapt_dev_load_add_button_form() { ?>
	<div id="add-cta-btn-form" style="display:none;">

		<script>
			(function($) {
				$(document).ready(function(){

					$('#page_id').prepend("<option value='' selected='selected'>-----------------</option>");

					// clear url field if page is selected in dropdown
					$('#page_id').on("change", function() {
						$('#btn-link').val('')
					});

					// clear dropdown selection if text is entered in url field
					$('#btn-link').on("keypress", function() {
						$('#page_id').val('')
					});

					// live update text in preview button
					$('#btn-text').on("keyup", function() {
						btnText = $(this).val();
						$('.btn-preview').text( btnText );
					});

					// apply preview button correct style when selected
					$('input[name=style]').on("change", function() {

						if ( $(this).val() == 'btn-secondary' ) {
							$('.btn-preview').addClass('btn-secondary').removeClass('btn-primary');
						}

						if ( $(this).val() == 'btn-primary' ) {
							$('.btn-preview').addClass('btn-primary').removeClass('btn-secondary');
						}

					});

					// apply preview button correct color when selected
					$('input[name=color]').on("change", function() {

						if ( $(this).val() == 'color-1' ) {
							$('.btn-preview').addClass('color-1').removeClass('color-2');
						}

						if ( $(this).val() == 'color-2' ) {
							$('.btn-preview').addClass('color-2').removeClass('color-1');
						}

					});

					// construct the button and insert it into the text editor
					$('#insert-new-btn').click(function() {
						var btnText = $('#btn-text').val();
						var btnLink = $('#btn-link').val();
						var page_ID = $('#page_id option:selected').val();
						var pageURL = window.location.origin + '/?page_id=' + page_ID;

						if ( btnLink == '' ) {
							btnURL = pageURL;
						} else {
							btnURL = btnLink;
						}

						if ( $('#link-target').is(":checked") ) {
							var btnTarget = '_blank';
						} else {
							var btnTarget = '_self';
						}

						var btnStyle = $('input[name=style]:checked', '#add-cta-btn_form').val();
						var btnColor = $('input[name=color]:checked', '#add-cta-btn_form').val();

						// construct the button
						var newBtn = '<a href="' + btnURL + '" class="btn ' + btnStyle + ' ' + btnColor + '" target="' + btnTarget + '">' + btnText + '</a>';

						// insert the button into text editor
						wp.media.editor.insert(newBtn);
					});

				});
			})( jQuery );
		</script>

		<style type="text/css">
			@import url(<?php echo wp_kses_post( get_theme_file_uri( ltrim( adapt_dev_get_asset_path( 'css/editor-style_media-buttons.css' ), '/' ) ) ); ?>);

			#TB_window {
				height: unset !important;
			}

			#TB_ajaxContent {
				margin: auto;
				width: unset !important;
				display: flex;
				flex-direction: column;
				justify-content: space-evenly;
				min-height: unset !important;
				height: 600px !important;
			}

			#add-cta-btn_form {
				margin: .875rem;
			}

			#add-cta-btn_form input,
			#add-cta-btn_form select {
				margin-top: .25em;
				margin-bottom: .75em;
			}

			#add-cta-btn_form input[type=text],
			#add-cta-btn_form select {
				width: 100%;
				max-width: 100%;
			}

			#add-cta-btn_form input[type=radio],
			#add-cta-btn_form input[type=checkbox] {
				margin-top: 0 !important;
				margin-bottom: 0 !important;
			}

			.link-target-wrap {
				display: flex;
				padding: 15px 0;
				align-items: center;
			}

			.btn-style-color-controls {
				display: flex;
			}

			.btn-style-color-controls .btn-colors {
				margin-left: 1rem;
			}

			.btn-style-color-controls label {
				line-height: 2.25;
			}

			.btn-colors label[for=btn-color-1]::after,
			.btn-colors label[for=btn-color-2]::after {
				content: '';
				padding: 2px 20px;
				border: 1px solid lightgray;
				margin-left: 1rem;
			}

			.btn-colors label[for=btn-color-1]::after {
				background-color: var(--color-1);
			}

			.btn-colors label[for=btn-color-2]::after {
				background-color: var(--color-2);
			}

			.btn-preview-title {
				margin-inline: .875rem;
			}

			.btn-preview--container {
				border: 1px solid #979797;
				padding: 24px 12px;
				text-align: center;
				margin: 0 1em;
				border-radius: 3px;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			input#insert-new-btn {
				margin: 1.5em 0;
			}
		</style>

		<form id="add-cta-btn_form">
			<label for="btn-text">Button Text:</label><br>
			<input type="text" id="btn-text" name="btn-text" placeholder="Call to Action"><br>

			<label for="btn-link">Button URL:</label><br>
			<input type="text" id="btn-link" name="btn-link"><br>

			<label>Or select Page</label><br>
			<?php wp_dropdown_pages(); ?><br>

			<div class="link-target-wrap">
				<input type="checkbox" id="link-target" name="link-target" value="yes">
				<label for="link-target">Open in new window?</label><br>
			</div>

			<div class="btn-style-color-controls">
				<div class="btn-styles">
					<label for="btn-style">Button Style:</label><br>
					<input type="radio" id="primary" name="style" value="btn-primary" checked="checked">
					<label for="primary" class="radio-label">Solid</label><br>
					<input type="radio" id="secondary" name="style" value="btn-secondary">
					<label for="secondary" class="radio-label">Outline</label><br>
				</div>
				<div class="btn-colors">
					<label for="btn-color">Button Color:</label><br>
					<input type="radio" id="btn-color-1" name="color" value="color-1" checked="checked">
					<label for="btn-color-1" class="radio-label">Color 1</label><br>
					<input type="radio" id="btn-color-2" name="color" value="color-2">
					<label for="btn-color-2" class="radio-label">Color 2</label><br>
				</div>
			</div>

			<input type="button" id="insert-new-btn" class="button-primary" value="Insert into page">
		</form>
		<span class="btn-preview-title">Button Preview</span>
		<section class="btn-preview--container">
			<a href="#" class="btn btn-preview btn-primary">Call to Action</a>
		</section>

	</div>
	<?php
}


// load form and media button only on post edit pages in wp admin
global $pagenow;
if ( ( $pagenow == 'post.php' ) || ( get_post_type() == 'post' ) || $pagenow == 'post-new.php' ) {
	add_action( 'admin_footer', 'adapt_dev_load_add_button_form' );
}

/**
 * Media button above post editor that adds a CTA button
 */
function adapt_dev_add_cta_media_button() {
	echo '<a href="#TB_inline?&width=400&height=600&inlineId=add-cta-btn-form" class="button add-cta-btn thickbox">Add Button</a>';
}
add_action( 'media_buttons', 'adapt_dev_add_cta_media_button', 25 );
