<?php
/**
 * Hooks for Advanced Custom Fields Pro.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

/**
 * Admin style options.
 */
function adapt_dev_acf_admin_styles() {
	wp_enqueue_style( 'admin-acf-styles', get_theme_file_uri( adapt_dev_get_asset_path( 'css/wp-admin-acf.css' ) ), [], '' );
}
add_action( 'acf/input/admin_enqueue_scripts', 'adapt_dev_acf_admin_styles' );

/**
 * Enueue wp admin scripts for ACF.
 */
function adapt_dev_acf_admin_enqueue_script() {
	wp_enqueue_script( 'admin-acf-js', get_theme_file_uri( adapt_dev_get_asset_path( 'js/wp-admin-acf.js' ) ), [ 'jquery' ], '', true );
}
add_action( 'acf/input/admin_enqueue_scripts', 'adapt_dev_acf_admin_enqueue_script' );

/**
 * Populate Gravity Form widget with Gravity Forms form list.
 *
 * @param string $field function field output.
 * @link https://gist.github.com/psaikali/2b29e6e83f50718625af27c2958c828f
 */
function adapt_dev_acf_populate_gf_forms_ids( $field ) {
	if ( class_exists( 'GFFormsModel' ) ) {
		$choices   = [];
		$choices[] = '-------------';

		foreach ( \GFFormsModel::get_forms() as $form ) {
			$choices[ $form->id ] = $form->title;
		}

		$field['choices'] = $choices;
	} else {
		$field['choices'] = 'Please activate Gravity Forms plugin to retrieve form list';
	}

	return $field;
}
add_filter( 'acf/load_field/name=gf_widget_form_id', 'adapt_dev_acf_populate_gf_forms_ids' );

/**
 * Adds ability to name flexible content fields.
 *
 * @param string $title = The layout title text. Defaults to the layout name.
 * @param array  $field = The field array containing all settings.
 * @param array  $layout = The layout array containing all settings.
 * @param int    $i = The layout index beginning at 0.
 */
function adapt_dev_acf_fields_flexible_content_layout_title( $title, $field, $layout, $i ) {
	$title = '<span class=acf-fc-layout-title>' . $title . '</span>';
	$text  = get_sub_field( 'widget_title' );

	// load text sub field
	if ( $text ) {
		// Remove layout name from title.
		$title  = '';
		$title .= '<span class=acf-fc-layout-title><b>' . esc_html( $text ) . '</b></span>';
	}
	return $title;
}
add_filter( 'acf/fields/flexible_content/layout_title', 'adapt_dev_acf_fields_flexible_content_layout_title', 10, 4 );

/**
 * Removes widgets associated with CPTs if they are not enabled.
 *
 * @param array $field The field.
 */
function adapt_dev_remove_page_sections( $field ) {
	$team      = get_option( 'options_adapt_dev_custom_post_types_team_members' );
	$prices    = get_option( 'options_adapt_dev_custom_post_types_prices' );
	$locations = get_option( 'options_adapt_dev_custom_post_types_locations' );

	if ( ! isset( $field['layouts'] ) || empty( $field['layouts'] ) ) {
		return $field;
	}

	foreach ( $field['layouts'] as $layout_key => $layout ) {

		if ( $layout['name'] === 'team' && $team == 0 ) {
			unset( $field['layouts'][ $layout_key ] );
		}

		if ( $layout['name'] === 'prices' && $prices == 0 ) {
			unset( $field['layouts'][ $layout_key ] );
		}

		if ( $layout['name'] === 'locations' && $locations == 0 ) {
			unset( $field['layouts'][ $layout_key ] );
		}
	}

	return $field;
}
add_filter( 'acf/prepare_field/name=page-sections', 'adapt_dev_remove_page_sections' );

/**
 * Removes widgets associated with CPTs if they are not enabled.
 *
 * @param array $field The field.
 */
function adapt_dev_sort_page_sections( $field ) {
	if ( $field && isset( $field['layouts'] ) ) {
		uasort(
			$field['layouts'],
			function( $a, $b ) {
				return strcasecmp( $a['label'], $b['label'] );
			}
		);
	}

	return $field;
}
add_filter( 'acf/load_field/name=page-sections', 'adapt_dev_sort_page_sections', 99 );

if ( ! function_exists( 'adapt_dev_top_bar_allow_2' ) ) :
	/**
	 * Limits top header content elements to a max of 2.

	 * @param mixed  $valid Whether or not the value is valid (boolean) or a custom error message (string).
	 * @param mixed  $value The field value.
	 * @param array  $field  The field array containing all settings.
	 * @param string $input The field DOM element name attribute.
	 */
	function adapt_dev_top_bar_allow_2( $valid, $value, $field, $input ) {
		if ( count( $value ) > 2 ) :
			$valid = 'Limit of 2 selected content elements.';
		endif;
		return $valid;
	}
endif;
add_filter( 'acf/validate_value/key=field_61241682bb33c', 'adapt_dev_top_bar_allow_2', 20, 4 );

if ( ! function_exists( 'adapt_dev_header_widget_allow_2' ) ) :
	/**
	 * Limits header widgets to a max of 2.

	 * @param mixed  $valid Whether or not the value is valid (boolean) or a custom error message (string).
	 * @param mixed  $value The field value.
	 * @param array  $field  The field array containing all settings.
	 * @param string $input The field DOM element name attribute.
	 */
	function adapt_dev_header_widget_allow_2( $valid, $value, $field, $input ) {
		if ( is_array( $value ) && count( $value ) > 2 ) :
			$valid = 'Limit of 2 selected header widgets.';
		endif;
		return $valid;
	}
endif;
add_filter( 'acf/validate_value/name=header_widget_type', 'adapt_dev_header_widget_allow_2', 20, 4 );

if ( ! function_exists( 'adapt_dev_unpack_theme_fonts' ) ) :
	/**
	 * Unzip and cleanup font files when theme settings are updated.
	 */
	function adapt_dev_unpack_theme_fonts( $post ) {
		if ( 'options' === $post && class_exists( 'ZipArchive' ) ) {
			global $wp_filesystem; 
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();

			$font_options = get_field( 'font_options', $post );
			$local_fonts = $font_options['local_fonts'] ?: array();
			$zip = new ZipArchive;

			$font_uploads = adapt_dev_get_font_dir();

			/**
			 * Ensure theme font directory exists.
			 */
			if ( false === is_dir( $font_uploads ) ) {
				mkdir( $font_uploads );
			}

			$existing_fonts = glob( $font_uploads . '/*', GLOB_ONLYDIR );

			$fonts = array_filter(
				array_map(
					function( $array ) {
						if ( empty( $array['archive'] ) ) {
							return null; // Invalid field value.
						}

						$archive_path = get_attached_file( $array['archive'] );
						$path = adapt_dev_get_font_dir( $array['archive'] );
						
						return array(
							'archive' => $archive_path,
							'path' => $path
						);
					},
					$local_fonts
				)
			);

			/**
			 * Remove font paths no longer configured as options.
			 */
			foreach( $existing_fonts as $dir ) {
				foreach( $fonts as $font ) {
					if ( $dir === $font['path'] ) {
						continue 2;
					}
				}

				$wp_filesystem->rmdir( $dir, true );
			}

			foreach( $fonts as $font ) {
				if ( false === is_dir( $font['path'] ) ) {
					if ( empty( $font['archive'] ) ) {
						continue;
					}

					mkdir( $font['path'] );
					$zip->open( $font['archive'] );
					$zip->extractTo( $font['path'] );
					$zip->close();
				}
			}
		}
	}
endif;
add_action( 'acf/save_post', 'adapt_dev_unpack_theme_fonts' );
