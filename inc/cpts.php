<?php
/**
 * Custom Post Types
 *
 * Register custom post types for theme.
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( ! function_exists( 'adapt_dev_custom_post_type' ) ) :

	/**
	 * Register Custom Post Types.
	 */
	function adapt_dev_custom_post_type() {
		$adapt_dev_cpts_team_members = get_option( 'options_adapt_dev_custom_post_types_team_members' );
		$adapt_dev_cpts_prices       = get_option( 'options_adapt_dev_custom_post_types_prices' );
		$adapt_dev_cpts_locations    = get_option( 'options_adapt_dev_custom_post_types_locations' );

		/* Get field group with all CPT options as an array */
		$adapt_dev_cpts_options = get_field( 'adapt_dev_custom_post_types_options', 'options' );
		$adapt_dev_cpts_team_members_options = $adapt_dev_cpts_options['team_members'];
		$adapt_dev_cpts_prices_options = $adapt_dev_cpts_options['prices'];
		$adapt_dev_cpts_locations_options = $adapt_dev_cpts_options['locations'];
		
		//$adapt_dev_cpts_prices_options = get_option( 'options_adapt_dev_custom_post_types_options_prices' );
		//$adapt_dev_cpts_locations_options = get_option( 'options_adapt_dev_custom_post_types_options_locations' );
		

		/**
		 * An array of labels for this post type.
		 *
		 * @link https://developer.wordpress.org/reference/functions/get_post_type_labels/
		 */
		$labels = [
			'name'                     => _x( 'FAQs', 'FAQ general name', 'adapt_dev' ),
			'singular_name'            => _x( 'FAQ', 'FAQ singular name', 'adapt_dev' ),
			'menu_name'                => _x( 'FAQs', 'FAQ menu name', 'adapt_dev' ),
			'add_new'                  => _x( 'Add New', 'FAQ post', 'adapt_dev' ),
			'add_new_item'             => __( 'Add New FAQ', 'adapt_dev' ),
			'edit_item'                => __( 'Edit FAQ', 'adapt_dev' ),
			'new_item'                 => __( 'New FAQ', 'adapt_dev' ),
			'view_item'                => __( 'View FAQ', 'adapt_dev' ),
			'view_items'               => __( 'View FAQs', 'adapt_dev' ),
			'search_items'             => __( 'Search FAQs', 'adapt_dev' ),
			'not_found'                => __( 'No FAQs found.', 'adapt_dev' ),
			'not_found_in_trash'       => __( 'Not found in trash.', 'adapt_dev' ),
			'parent_item_colon'        => __( 'Parent FAQ:', 'adapt_dev' ),
			'all_items'                => __( 'All FAQs', 'adapt_dev' ),
			'archives'                 => __( 'FAQs Archives', 'adapt_dev' ),
			'attributes'               => __( 'Post Attributes', 'adapt_dev' ),
			'insert_into_item'         => __( 'Insert into post', 'adapt_dev' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this post', 'adapt_dev' ),
			'featured_image'           => _x( 'Featured Image', 'FAQ post', 'adapt_dev' ),
			'set_featured_image'       => _x( 'Set featured image', 'FAQ post', 'adapt_dev' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'FAQ post', 'adapt_dev' ),
			'use_featured_image'       => _x( 'Use as featured image', 'FAQ post', 'adapt_dev' ),
			'filter_items_list'        => __( 'Filter FAQs list', 'adapt_dev' ),
			'items_list_navigation'    => __( 'FAQs list navigation', 'adapt_dev' ),
			'items_list'               => __( 'FAQs list', 'adapt_dev' ),
			'item_published'           => __( 'Post published.', 'adapt_dev' ),
			'item_published_privately' => __( 'Post published privately.', 'adapt_dev' ),
			'item_reverted_to_draft'   => __( 'Post reverted to draft.', 'adapt_dev' ),
			'item_scheduled'           => __( 'Post scheduled.', 'adapt_dev' ),
			'item_updated'             => __( 'Post updated.', 'adapt_dev' ),
		];

		/**
		 * Arguments for registering this post type.
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_post_type/
		 */
		$args = [
			'labels'        => $labels,
			'description'   => 'Frequently Asked Questions',
			'public'        => true,
			'menu_icon'     => 'dashicons-format-status',
			'menu_position' => 10,
			'supports'      => [ 'title', 'editor', 'page-attributes' ],
		];

		register_post_type( 'adapt_dev_faq', $args );

		if ( $adapt_dev_cpts_team_members && $adapt_dev_cpts_team_members == 1 ) :
			/**
			 * An array of labels for Team post type.
			 *
			 * @link https://developer.wordpress.org/reference/functions/get_post_type_labels/
			 */
			$labels = [
				'name'                     => _x( 'Team Members', 'Team members general name', 'adapt_dev' ),
				'singular_name'            => _x( 'Team Member', 'Team Member singular name', 'adapt_dev' ),
				'menu_name'                => _x( 'Team Members', 'Team member menu name', 'adapt_dev' ),
				'add_new'                  => _x( 'Add New', 'Team Member post', 'adapt_dev' ),
				'add_new_item'             => __( 'Add New Team', 'adapt_dev' ),
				'edit_item'                => __( 'Edit Team Member', 'adapt_dev' ),
				'new_item'                 => __( 'New Team Member', 'adapt_dev' ),
				'view_item'                => __( 'View Team Member', 'adapt_dev' ),
				'view_items'               => __( 'View Team Member', 'adapt_dev' ),
				'search_items'             => __( 'Search Team Members', 'adapt_dev' ),
				'not_found'                => __( 'No Team Member found.', 'adapt_dev' ),
				'not_found_in_trash'       => __( 'Not found in trash.', 'adapt_dev' ),
				'parent_item_colon'        => __( 'Parent Team Member:', 'adapt_dev' ),
				'all_items'                => __( 'All Team Members', 'adapt_dev' ),
				'archives'                 => __( 'Team Member Archives', 'adapt_dev' ),
				'attributes'               => __( 'Post Attributes', 'adapt_dev' ),
				'insert_into_item'         => __( 'Insert into post', 'adapt_dev' ),
				'uploaded_to_this_item'    => __( 'Uploaded to this post', 'adapt_dev' ),
				'featured_image'           => _x( 'Team Member Portrait', 'Team Member post', 'adapt_dev' ),
				'set_featured_image'       => _x( 'Set member portrait', 'Team Member post', 'adapt_dev' ),
				'remove_featured_image'    => _x( 'Remove member portrait', 'Team Member post', 'adapt_dev' ),
				'use_featured_image'       => _x( 'Use as team member portrait', 'Team Member post', 'adapt_dev' ),
				'filter_items_list'        => __( 'Filter Team Member list', 'adapt_dev' ),
				'items_list_navigation'    => __( 'Team Member list navigation', 'adapt_dev' ),
				'items_list'               => __( 'Team Member list', 'adapt_dev' ),
				'item_published'           => __( 'Post published.', 'adapt_dev' ),
				'item_published_privately' => __( 'Post published privately.', 'adapt_dev' ),
				'item_reverted_to_draft'   => __( 'Post reverted to draft.', 'adapt_dev' ),
				'item_scheduled'           => __( 'Post scheduled.', 'adapt_dev' ),
				'item_updated'             => __( 'Post updated.', 'adapt_dev' ),
			];

			/**
			 * Arguments for registering this post type.
			 *
			 * @link https://developer.wordpress.org/reference/functions/register_post_type/
			 */
			$args = [
				'labels'              => $labels,
				'description'         => 'Team Members',
				'public'              => $adapt_dev_cpts_team_members_options['permalinks'],
				'show_ui'		      => true,
				'show_in_rest'		  => true,
				'menu_icon'           => 'dashicons-groups',
				'menu_position'       => 10,
				'supports'            => [ 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ],
				'has_archive'         => ( $adapt_dev_cpts_team_members_options['permalinks'] ) ? $adapt_dev_cpts_team_members_options['archive'] : false,
				'exclude_from_search' => ( $adapt_dev_cpts_team_members_options['permalinks'] ) ? ! $adapt_dev_cpts_team_members_options['show_in_search'] : true,
				'rewrite'             => [
					'slug'      => ( ! empty( $adapt_dev_cpts_team_members_options['archive_rewrite'] )) ? $adapt_dev_cpts_team_members_options['archive_rewrite'] : 'team-members', 
				],
			];

			register_post_type( 'adaptdev_team_member', $args );
		endif; // end check for if acf option is toggled to show Team Member CPT.

		if ( $adapt_dev_cpts_prices && $adapt_dev_cpts_prices == 1 ) :
			/**
			 * An array of labels for Prices.
			 *
			 * @link https://developer.wordpress.org/reference/functions/get_post_type_labels/
			 */
			$labels = [
				'name'                     => _x( 'Prices', 'Price general name', 'adapt_dev' ),
				'singular_name'            => _x( 'Price', 'Price singular name', 'adapt_dev' ),
				'menu_name'                => _x( 'Prices', 'Price menu name', 'adapt_dev' ),
				'add_new'                  => _x( 'Add New', 'Price post', 'adapt_dev' ),
				'add_new_item'             => __( 'Add New Price', 'adapt_dev' ),
				'edit_item'                => __( 'Edit Price', 'adapt_dev' ),
				'new_item'                 => __( 'New Price', 'adapt_dev' ),
				'view_item'                => __( 'View Price', 'adapt_dev' ),
				'view_items'               => __( 'View Prices', 'adapt_dev' ),
				'search_items'             => __( 'Search Prices', 'adapt_dev' ),
				'not_found'                => __( 'No Prices found.', 'adapt_dev' ),
				'not_found_in_trash'       => __( 'Not found in trash.', 'adapt_dev' ),
				'parent_item_colon'        => __( 'Parent Price:', 'adapt_dev' ),
				'all_items'                => __( 'All Prices', 'adapt_dev' ),
				'archives'                 => __( 'Prices Archives', 'adapt_dev' ),
				'attributes'               => __( 'Post Attributes', 'adapt_dev' ),
				'insert_into_item'         => __( 'Insert into post', 'adapt_dev' ),
				'uploaded_to_this_item'    => __( 'Uploaded to this post', 'adapt_dev' ),
				'featured_image'           => _x( 'Featured Image', 'Price post', 'adapt_dev' ),
				'set_featured_image'       => _x( 'Set featured image', 'Price post', 'adapt_dev' ),
				'remove_featured_image'    => _x( 'Remove featured image', 'Price post', 'adapt_dev' ),
				'use_featured_image'       => _x( 'Use as featured image', 'Price post', 'adapt_dev' ),
				'filter_items_list'        => __( 'Filter Prices list', 'adapt_dev' ),
				'items_list_navigation'    => __( 'Prices list navigation', 'adapt_dev' ),
				'items_list'               => __( 'Prices list', 'adapt_dev' ),
				'item_published'           => __( 'Post published.', 'adapt_dev' ),
				'item_published_privately' => __( 'Post published privately.', 'adapt_dev' ),
				'item_reverted_to_draft'   => __( 'Post reverted to draft.', 'adapt_dev' ),
				'item_scheduled'           => __( 'Post scheduled.', 'adapt_dev' ),
				'item_updated'             => __( 'Post updated.', 'adapt_dev' ),
			];

			/**
			 * Arguments for registering this post type.
			 *
			 * @link https://developer.wordpress.org/reference/functions/register_post_type/
			 */
			$args = [
				'labels'              => $labels,
				'description'         => 'Prices of offered services.',
				'public'              => $adapt_dev_cpts_prices_options['permalinks'],
				'menu_icon'           => 'dashicons-money-alt',
				'menu_position'       => 10,
				'show_in_rest'		  => true,
				'supports'            => [ 'title', 'editor', 'page-attributes' ],
				'has_archive'         => ( $adapt_dev_cpts_prices_options['permalinks'] ) ? $adapt_dev_cpts_prices_options['archive'] : false,
				'exclude_from_search' => ( $adapt_dev_cpts_prices_options['permalinks'] ) ? ! $adapt_dev_cpts_prices_options['show_in_search'] : true,
				'rewrite'             => [
					'slug'      => ( ! empty( $adapt_dev_cpts_prices_options['archive_rewrite'] )) ? $adapt_dev_cpts_prices_options['archive_rewrite'] : 'price',
				],
			];

			register_post_type( 'adapt_dev_prices', $args );
		endif; // end check for if acf option is toggled to show Prices CPT.

		if ( $adapt_dev_cpts_locations && $adapt_dev_cpts_locations == 1 ) :
			/**
			 * An array of labels for this post type.
			 *
			 * @link https://developer.wordpress.org/reference/functions/get_post_type_labels/
			 */
			$labels = [
				'name'                     => _x( 'Locations', 'Location general name', 'adapt_dev' ),
				'singular_name'            => _x( 'Location', 'Location singular name', 'adapt_dev' ),
				'menu_name'                => _x( 'Locations', 'Location menu name', 'adapt_dev' ),
				'add_new'                  => _x( 'Add New', 'Location post', 'adapt_dev' ),
				'add_new_item'             => __( 'Add New Location', 'adapt_dev' ),
				'edit_item'                => __( 'Edit Location', 'adapt_dev' ),
				'new_item'                 => __( 'New Location', 'adapt_dev' ),
				'view_item'                => __( 'View Location', 'adapt_dev' ),
				'view_items'               => __( 'View Locations', 'adapt_dev' ),
				'search_items'             => __( 'Search Locations', 'adapt_dev' ),
				'not_found'                => __( 'No Locations found.', 'adapt_dev' ),
				'not_found_in_trash'       => __( 'Not found in trash.', 'adapt_dev' ),
				'parent_item_colon'        => __( 'Parent Location:', 'adapt_dev' ),
				'all_items'                => __( 'All Locations', 'adapt_dev' ),
				'archives'                 => __( 'Locations Archives', 'adapt_dev' ),
				'attributes'               => __( 'Post Attributes', 'adapt_dev' ),
				'insert_into_item'         => __( 'Insert into post', 'adapt_dev' ),
				'uploaded_to_this_item'    => __( 'Uploaded to this post', 'adapt_dev' ),
				'featured_image'           => _x( 'Featured Image', 'Location post', 'adapt_dev' ),
				'set_featured_image'       => _x( 'Set featured image', 'Location post', 'adapt_dev' ),
				'remove_featured_image'    => _x( 'Remove featured image', 'Location post', 'adapt_dev' ),
				'use_featured_image'       => _x( 'Use as featured image', 'Location post', 'adapt_dev' ),
				'filter_items_list'        => __( 'Filter Locations list', 'adapt_dev' ),
				'items_list_navigation'    => __( 'Locations list navigation', 'adapt_dev' ),
				'items_list'               => __( 'Locations list', 'adapt_dev' ),
				'item_published'           => __( 'Post published.', 'adapt_dev' ),
				'item_published_privately' => __( 'Post published privately.', 'adapt_dev' ),
				'item_reverted_to_draft'   => __( 'Post reverted to draft.', 'adapt_dev' ),
				'item_scheduled'           => __( 'Post scheduled.', 'adapt_dev' ),
				'item_updated'             => __( 'Post updated.', 'adapt_dev' ),
			];

			/**
			 * Arguments for registering this post type.
			 *
			 * @link https://developer.wordpress.org/reference/functions/register_post_type/
			 */
			$args = [
				'labels'              => $labels,
				'description'         => 'Our Locations',
				'public'              => $adapt_dev_cpts_locations_options['permalinks'],
				'menu_icon'           => 'dashicons-location-alt',
				'menu_position'       => 10,
				'show_in_rest'		  => true,
				'supports'            => [ 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ],
				'has_archive'         => ( $adapt_dev_cpts_locations_options['permalinks'] ) ? $adapt_dev_cpts_locations_options['archive'] : false,
				'exclude_from_search' => ( $adapt_dev_cpts_locations_options['permalinks'] ) ? ! $adapt_dev_cpts_locations_options['show_in_search'] : true,
				'rewrite'             => [
					'slug'      => ( ! empty( $adapt_dev_cpts_locations_options['archive_rewrite'] )) ? $adapt_dev_cpts_locations_options['archive_rewrite'] : 'location',
				],
			];

			register_post_type( 'adapt_dev_locations', $args );
		endif; // end check for if acf option is toggled to show Locations CPT.
	}
endif;

// Hook into the 'init' action.
add_action( 'init', 'adapt_dev_custom_post_type', 0 );

if ( ! function_exists( 'adapt_dev_custom_taxonomy' ) ) :

	/**
	 * Register Custom Taxonomies.
	 */
	function adapt_dev_custom_taxonomy() {
		
		$labels = [
			'name'              => _x( 'Teams', 'taxonomy general name' ),
			'singular_name'     => _x( 'Team', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Teams' ),
			'all_items'         => __( 'All Teams' ),
			'parent_item'       => __( 'Parent Teams' ),
			'parent_item_colon' => __( 'Parent Team:' ),
			'edit_item'         => __( 'Edit Team' ),
			'update_item'       => __( 'Update Team' ),
			'add_new_item'      => __( 'Add New Team' ),
			'new_item_name'     => __( 'New Team Name' ),
			'menu_name'         => __( 'Teams' ),
		];
		$args   = [
			'hierarchical'      => true, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		];
		register_taxonomy( 'adapt_dev_team_tax', [ 'adaptdev_team_member' ], $args );
	}
endif;

// Hook into the 'init' action.
add_action( 'init', 'adapt_dev_custom_taxonomy', 0 );

/**
 * Runs only when the theme is set up.
 */
function adapt_dev_custom_flush_rules() {

	adapt_dev_custom_post_type();
	flush_rewrite_rules();

}

add_action( 'after_switch_theme', 'adapt_dev_custom_flush_rules' );
