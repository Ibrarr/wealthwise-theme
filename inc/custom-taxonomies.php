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
	wp_insert_term( 'Partner Video', 'type' );
}

/**
 * Register Partner Taxonomy
 */
add_action( 'init', 'partner_taxonomy', 0 );
function partner_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Partners', 'Taxonomy General Name', 'ww' ),
		'singular_name'              => _x( 'Partner', 'Taxonomy Singular Name', 'ww' ),
		'menu_name'                  => __( 'Partner', 'ww' ),
		'all_items'                  => __( 'All partners', 'ww' ),
		'parent_item'                => __( 'Parent partner', 'ww' ),
		'parent_item_colon'          => __( 'Parent partner:', 'ww' ),
		'new_item_name'              => __( 'New partner Name', 'ww' ),
		'add_new_item'               => __( 'Add New partner', 'ww' ),
		'edit_item'                  => __( 'Edit partner', 'ww' ),
		'update_item'                => __( 'Update partner', 'ww' ),
		'view_item'                  => __( 'View partner', 'ww' ),
		'separate_items_with_commas' => __( 'Separate partners with commas', 'ww' ),
		'add_or_remove_items'        => __( 'Add or remove partners', 'ww' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'ww' ),
		'popular_items'              => __( 'Popular partners', 'ww' ),
		'search_items'               => __( 'Search partners', 'ww' ),
		'not_found'                  => __( 'Not Found', 'ww' ),
		'no_terms'                   => __( 'No partners', 'ww' ),
		'items_list'                 => __( 'Partners list', 'ww' ),
		'items_list_navigation'      => __( 'Partners list navigation', 'ww' ),
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
			'slug'       => 'partner',
			'with_front' => false,
		),
	);
	register_taxonomy( 'partner', array( 'partner_content'), $args );
}