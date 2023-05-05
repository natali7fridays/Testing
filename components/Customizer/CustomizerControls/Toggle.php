<?php
/**
 * A TinyMCE instance setting control
 *
 * @link https://github.com/WordPress/WordPress/blob/master/wp-includes/class-wp-customize-control.php
 * @package adaptdev/base
 */

namespace AdaptDevBase\Components\Customizer\CustomizerControls;

use WP_Customize_Control;

/**
 * Customizer Toggle Class
 */
class Toggle extends WP_Customize_Control {

	/**
	 * Toggle type
	 *
	 * @var string $type The current link attributes.
	 */
	public $type = 'adapt_dev-toggle';

	/**
	 * Enqueueing function
	 */
	public function enqueue() {
		parent::enqueue();

		wp_enqueue_script(
			'adapt_dev-toggle-control-script',
			get_theme_file_uri( adapt_dev_get_asset_path( 'js/Toggle.js' ) ),
			[ 'customize-controls' ],
			wp_get_theme()->get( 'Version' ),
			false
		);

		wp_enqueue_style(
			'adapt_dev-toggle-control-style',
			get_theme_file_uri( adapt_dev_get_asset_path( 'css/Toggle.css' ) ),
			[],
			wp_get_theme()->get( 'Version' ),
			false
		);
	}

	/**
	 * To json function
	 */
	public function to_json() {
		parent::to_json();

		$this->json['id']           = $this->id;
		$this->json['value']        = $this->value();
		$this->json['link']         = $this->get_link();
		$this->json['defaultValue'] = $this->setting->default;
	}

	/**
	 * Render pass through
	 */
	public function render_content() {}

	/**
	 * Template for conet output
	 */
	protected function content_template() {
		?>
		<div class="components-base-control components-toggle-control">
			<div class="components-base-control__field">
				<# if ( data.label ) { #>
				<label for="inspector-toggle-control-{{ data.id }}" class="components-toggle-control__label">{{ data.label }}</label>
				<# } #>
				<span class="adapt_dev-customize-toggle <# if ( data.value ) { #>is-checked<# } #>">
					<input class="adapt_dev-customize-toggle__input" id="inspector-toggle-control-{{ data.id }}" type="checkbox" value="{{ data.value }}" {{{ data.link }}} <# if ( data.value ) { #> checked="checked" <# } #> />
					<span class="adapt_dev-customize-toggle__track"></span>
					<span class="adapt_dev-customize-toggle__thumb"></span>
					<# if ( data.value ) { #>
						<svg class="adapt_dev-customize-toggle__off" width="2" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 6">
							<path d="M0 0h2v6H0z"></path>
						</svg>
					<# } else { #>
						<svg class="adapt_dev-customize-toggle__on" width="6" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6">
							<path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
						</svg>
					<# } #>
				</span>
			</div>
			<# if ( data.description ) { #>
			<p id="inspector-toggle-control-{{ data.id }}__help" class="components-base-control__help">{{ data.description }}</p>
			<# } #>
		</div>
		<?php
	}
}
