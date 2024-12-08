<?php

/**
 * Register Video Type Taxonomy
 */
add_action( 'init', 'video_type_taxonomy', 0 );
function video_type_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'ww' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'ww' ),
		'menu_name'                  => __( 'Type', 'ww' ),
		'all_items'                  => __( 'All types', 'ww' ),
		'parent_item'                => __( 'Parent type', 'ww' ),
		'parent_item_colon'          => __( 'Parent type:', 'ww' ),
		'new_item_name'              => __( 'New type Name', 'ww' ),
		'add_new_item'               => __( 'Add New type', 'ww' ),
		'edit_item'                  => __( 'Edit type', 'ww' ),
		'update_item'                => __( 'Update type', 'ww' ),
		'view_item'                  => __( 'View type', 'ww' ),
		'separate_items_with_commas' => __( 'Separate types with commas', 'ww' ),
		'add_or_remove_items'        => __( 'Add or remove types', 'ww' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'ww' ),
		'popular_items'              => __( 'Popular types', 'ww' ),
		'search_items'               => __( 'Search types', 'ww' ),
		'not_found'                  => __( 'Not Found', 'ww' ),
		'no_terms'                   => __( 'No types', 'ww' ),
		'items_list'                 => __( 'Types list', 'ww' ),
		'items_list_navigation'      => __( 'Types list navigation', 'ww' ),
	);
	$args   = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'meta_box_cb'       => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true,
		'rewrite'           => array(
			'slug'       => 'type',
			'with_front' => false,
		),
		'capabilities'      => array(
			'edit_terms'   => 'do_not_allow',
			'delete_terms' => 'do_not_allow',
			'assign_terms' => 'edit_posts',
		),
	);
	register_taxonomy( 'type', array( 'video'), $args );

	// Register predefined terms
	wp_insert_term( 'Video', 'type' );
	wp_insert_term( 'Podcast', 'type' );
}