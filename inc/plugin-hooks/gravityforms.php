<?php
/**
 * Hooks for gravity forms.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( class_exists( 'GFCommon' ) ) :
	// Automatically scroll to form after Gravity Form submission.
	add_filter( 'gform_confirmation_anchor', '__return_true' );

	add_filter(
		'script_loader_tag',
		function( $tag, $handle ) {

			if ( 'gform_recaptcha' === $handle ) {
				$tag = str_replace( ' src', ' data-src', $tag );
			}

			return $tag;
		},
		10,
		2
	);

	add_action(
		'wp_footer',
		function() {
			?>
		<script type="text/javascript" defer="defer">
			(function() {
				var forms = Array.from(document.querySelectorAll('.gform_wrapper form'));

				forms.forEach(function(form) {
					form.addEventListener('focusin', function() {
						var script = document.getElementById('gform_recaptcha-js');

						if (script && !!! script.src) {
							script.src = script.dataset.src;
							document.body.appendChild(script);
						}
					});
				});
			})();
		</script>
			<?php
		}
	);
endif;
