<?php
/**
 * Some custom admin functinality
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Localizing wp link script for aria functionality for admin.
 */
function adapt_dev_localize_wp_link_admin() {

	wp_register_style( 'admin-css', get_theme_file_uri( adapt_dev_get_asset_path( 'css/admin.css' ) ), false, '1.0.0' );
	wp_enqueue_style( 'admin-css' );

	wp_deregister_script( 'wplink' );
	wp_register_script( 'wplink', ADAPT_DEV_THEME_URI . '/assets/js/libs/wplink.js', array( 'jquery', 'wpdialogs' ), false, 1 );

	wp_localize_script(
		'wplink',
		'wpLinkL10n',
		array(
			'title'          => __( 'Insert/edit link' ),
			'update'         => __( 'Update' ),
			'save'           => __( 'Add Link' ),
			'noTitle'        => __( '(no title)' ),
			'noMatchesFound' => __( 'No matches found.' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'adapt_dev_localize_wp_link_admin' );

/**
 * Automatically disables the automatic expand feature of the WordPress WYSIWYG
 *
 * @return void
 */
function adapt_dev_turn_off_autoresize() {
	set_user_setting( 'editor_expand', 'off' );
}
add_action( 'after_setup_theme', 'adapt_dev_turn_off_autoresize' );

/**
 * Hides the admin option of turning on the automatic expand feature of the WordPress WYSIWYG
 *
 * @return void
 */
function adapt_dev_turn_off_autoresize_css() {
	echo '<style type="text/css">#adv-settings .editor-expand {display:none !important;}</style>';
}
add_action( 'admin_head', 'adapt_dev_turn_off_autoresize_css' );

// Big ol acf copy/paste block,, disabling sniffing.
//phpcs:disable
if ( class_exists( 'acf_field' ) && ! class_exists( 'acf_field_link' ) ) :

	class acf_field_link extends acf_field {


		/*
		*  __construct
		*
		*  This function will setup the field type data
		*
		*  @type    function
		*  @date    5/03/2014
		*  @since   5.0.0
		*
		*  @param   n/a
		*  @return  n/a
		*/

		function initialize() {

			// vars
			$this->name     = 'link';
			$this->label    = __( 'Link', 'acf' );
			$this->category = 'relational';
			$this->defaults = array(
				'return_format' => 'array',
			);

		}


		/*
		*  get_link
		*
		*  description
		*
		*  @type    function
		*  @date    16/5/17
		*  @since   5.5.13
		*
		*  @param   $post_id (int)
		*  @return  $post_id (int)
		*/

		function get_link( $value = '' ) {

			// vars
			$link = array(
				'title'      => '',
				'url'        => '',
				'target'     => '',
				'aria-label' => '',
			);

			// array (ACF 5.6.0)
			if ( is_array( $value ) ) {

				$link = array_merge( $link, $value );

				// post id (ACF < 5.6.0)
			} elseif ( is_numeric( $value ) ) {

				$link['title'] = get_the_title( $value );
				$link['url']   = get_permalink( $value );

				// string (ACF < 5.6.0)
			} elseif ( is_string( $value ) ) {

				$link['url'] = $value;

			}

			// return
			return $link;

		}


		/*
		*  render_field()
		*
		*  Create the HTML interface for your field
		*
		*  @param   $field - an array holding all the field's data
		*
		*  @type    action
		*  @since   3.6
		*  @date    23/01/13
		*/

		function render_field( $field ) {

			// vars
			$div = array(
				'id'    => $field['id'],
				'class' => $field['class'] . ' acf-link',
			);

			// render scripts/styles
			acf_enqueue_uploader();

			// get link
			$link = $this->get_link( $field['value'] );

			// classes
			if ( $link['url'] ) {
				$div['class'] .= ' -value';
			}

			if ( $link['target'] === '_blank' ) {
				$div['class'] .= ' -external';
			}

			/*
			<textarea id="<?php echo esc_attr($field['id']); ?>-textarea"><?php
			echo esc_textarea('<a href="'.$link['url'].'" target="'.$link['target'].'">'.$link['title'].'</a>');
			?></textarea>*/
			?>
<div <?php acf_esc_attr_e( $div ); ?>>

	<div class="acf-hidden">
		<a class="link-node" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>" aria-label="<?php echo esc_attr( $link['aria-label'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
			<?php foreach ( $link as $k => $v ) : ?>
				<?php
				acf_hidden_input(
					array(
						'class' => "input-$k",
						'name'  => $field['name'] . "[$k]",
						'value' => $v,
					)
				);
				?>
		<?php endforeach; ?>
	</div>

	<a href="#" class="button" data-name="add" target=""><?php _e( 'Select Link', 'acf' ); ?></a>

	<div class="link-wrap">
		<span class="link-title"><?php echo esc_html( $link['title'] ); ?></span>
		<a class="link-url" href="<?php echo esc_url( $link['url'] ); ?>" target="_blank"><?php echo esc_html( $link['url'] ); ?></a>
		<span class="link-aria-label"><?php echo esc_html( $link['aria-label'] ); ?></span>
		<i class="acf-icon -link-ext acf-js-tooltip" title="<?php _e( 'Opens in a new window/tab', 'acf' ); ?>"></i><a class="acf-icon -pencil -clear acf-js-tooltip" data-name="edit" href="#" title="<?php _e( 'Edit', 'acf' ); ?>"></a><a class="acf-icon -cancel -clear acf-js-tooltip" data-name="remove" href="#" title="<?php _e( 'Remove', 'acf' ); ?>"></a>
	</div>

</div>
			<?php

		}


		/*
		*  render_field_settings()
		*
		*  Create extra options for your field. This is rendered when editing a field.
		*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
		*
		*  @type    action
		*  @since   3.6
		*  @date    23/01/13
		*
		*  @param   $field  - an array holding all the field's data
		*/

		function render_field_settings( $field ) {

			// return_format
			acf_render_field_setting(
				$field,
				array(
					'label'         => __( 'Return Value', 'acf' ),
					'instructions'  => __( 'Specify the returned value on front end', 'acf' ),
					'type'          => 'radio',
					'name'          => 'return_format',
					'layout'        => 'horizontal',
					'choices'       => array(
						'array'         => __( 'Link Array', 'acf' ),
						'url'           => __( 'Link URL', 'acf' ),
					),
				)
			);

		}


		/*
		*  format_value()
		*
		*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
		*
		*  @type    filter
		*  @since   3.6
		*  @date    23/01/13
		*
		*  @param   $value (mixed) the value which was loaded from the database
		*  @param   $post_id (mixed) the $post_id from which the value was loaded
		*  @param   $field (array) the field array holding all the field options
		*
		*  @return  $value (mixed) the modified value
		*/

		function format_value( $value, $post_id, $field ) {

			// bail early if no value
			if ( empty( $value ) ) {
				return $value;
			}

			// get link
			$link = $this->get_link( $value );

			// format value
			if ( $field['return_format'] == 'url' ) {

				return $link['url'];

			}

			// return link
			return $link;

		}


		/*
		*  validate_value
		*
		*  description
		*
		*  @type    function
		*  @date    11/02/2014
		*  @since   5.0.0
		*
		*  @param   $post_id (int)
		*  @return  $post_id (int)
		*/

		function validate_value( $valid, $value, $field, $input ) {

			// bail early if not required
			if ( ! $field['required'] ) {
				return $valid;
			}

			// URL is required
			if ( empty( $value ) || empty( $value['url'] ) ) {

				return false;

			}

			// return
			return $valid;

		}


		/*
		*  update_value()
		*
		*  This filter is appied to the $value before it is updated in the db
		*
		*  @type    filter
		*  @since   3.6
		*  @date    23/01/13
		*
		*  @param   $value - the value which will be saved in the database
		*  @param   $post_id - the $post_id of which the value will be saved
		*  @param   $field - the field array holding all the field options
		*
		*  @return  $value - the modified value
		*/

		function update_value( $value, $post_id, $field ) {

			// Check if value is an empty array and convert to empty string.
			if ( empty( $value ) || empty( $value['url'] ) ) {
				$value = '';
			}

			// return
			return $value;
		}
	}

	// initialize
	acf_register_field_type( 'acf_field_link' );

endif; // class_exists check

function my_acf_input_admin_footer() {
	?>
	<script type="text/javascript">
		(function($, undefined){

			var Field = acf.Field.extend({

				type: 'link',

				events: {
					'click a[data-name="add"]': 	'onClickEdit',
					'click a[data-name="edit"]': 	'onClickEdit',
					'click a[data-name="remove"]':	'onClickRemove',
					'change .link-node':			'onChange',
				},

				$control: function(){
					return this.$('.acf-link');
				},

				$node: function(){
					return this.$('.link-node');
				},

				getValue: function(){

					// vars
					var $node = this.$node();

					// return false if empty
					if( !$node.attr('href') ) {
						return false;
					}
					// return
					return {
						title:	$node.html(),
						url:	$node.attr('href'),
						target:	$node.attr('target'),
						"aria-label": $node.attr('aria-label')
					};
				},

				setValue: function( val ){
					// default
					val = acf.parseArgs(val, {
						title:	'',
						url:	'',
						target:	'',
						"aria-label": ''
					});

					// vars
					var $div = this.$control();
					var $node = this.$node();

					// remove class
					$div.removeClass('-value -external');

					// add class
					if( val.url ) $div.addClass('-value');
					if( val.target === '_blank' ) $div.addClass('-external');

					// update text
					this.$('.link-title').html( val.title );
					this.$('.link-url').attr('href', val.url).html( val.url );
					this.$('.link-aria-label').attr('aria-label', val["aria-label"]).html( val['aria-label'] );

					// update node
					$node.html(val.title);
					$node.attr('href', val.url);
					$node.attr('target', val.target);
					$node.attr('aria-label', val['aria-label']);

					// update inputs
					this.$('.input-title').val( val.title );
					this.$('.input-target').val( val.target );
					this.$('.input-aria-label').val( val['aria-label'] );
					this.$('.input-url').val( val.url ).trigger('change');
				},

				onClickEdit: function( e, $el ){
					acf.wpLink.open( this.$node() );
				},

				onClickRemove: function( e, $el ){
					this.setValue( false );
				},

				onChange: function( e, $el ){

					// get the changed value
					var val = this.getValue();

					// update inputs
					this.setValue(val);
				}

			});

			acf.registerFieldType( Field );


			// manager
			acf.wpLink = new acf.Model({

				getNodeValue: function(){
					var $node = this.get('node');
					return {
						title:	acf.decode( $node.html() ),
						url:	$node.attr('href'),
						target:	$node.attr('target'),
						"aria-label": $node.attr('aria-label'),
					};
				},

				setNodeValue: function( val ){
					var $node = this.get('node');
					$node.text( val.title );
					$node.attr('href', val.url);
					$node.attr('target', val.target);
					$node.attr('aria-label', val['aria-label']);
					$node.trigger('change');
				},

				getInputValue: function(){
					return {
						title:	$('#wp-link-text').val(),
						url:	$('#wp-link-url').val(),
						target:	$('#wp-link-target').prop('checked') ? '_blank' : '',
						"aria-label":	$('#wp-aria-label').val()
					};
				},

				setInputValue: function( val ){
					$('#wp-link-text').val( val.title );
					$('#wp-link-url').val( val.url );
					$('#wp-link-aria-label').val( val['aria-label'] );
					$('#wp-link-target').prop('checked', val.target === '_blank' );
				},

				open: function( $node ){
					// add events
					this.on('wplink-open', 'onOpen');
					this.on('wplink-close', 'onClose');

					// set node
					this.set('node', $node);

					// create textarea
					var $textarea = $('<textarea id="acf-link-textarea" style="display:none;"></textarea>');
					$('body').append( $textarea );

					// vars
					var val = this.getNodeValue();

					// open popup
					wpLink.open( 'acf-link-textarea', val.url, val.title, val['aria-label'] );
				},

				onOpen: function(){

					// always show title (WP will hide title if empty)
					$('#wp-link-wrap').addClass('has-text-field');

					// set inputs
					var val = this.getNodeValue();
					this.setInputValue( val );

					// Update button text.
					if( val.url && wpLinkL10n ) {
						$('#wp-link-submit').val( wpLinkL10n.update );
					}
				},

				close: function(){
					wpLink.close();
				},

				onClose: function(){

					// Bail early if no node.
					// Needed due to WP triggering this event twice.
					if( !this.has('node') ) {
						return false;
					}

					// Determine context.
					var $submit = $('#wp-link-submit');
					var isSubmit = ( $submit.is(':hover') || $submit.is(':focus') );

					// Set value
					if( isSubmit ) {
						var val = this.getInputValue();
						this.setNodeValue( val );
					}

					// Cleanup.
					this.off('wplink-open');
					this.off('wplink-close');
					$('#acf-link-textarea').remove();
					this.set('node', null);
				}
			});

		})(jQuery);
	</script>
	<?php

}
add_action( 'acf/input/admin_footer', 'my_acf_input_admin_footer' );
//phpcs:enable

?>
