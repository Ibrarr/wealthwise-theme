<?php

/**
 * Register Videos Post Type
 */
add_action( 'init', 'video_post_type', 0 );
function video_post_type() {

	$labels = array(
		'name'                  => _x( 'Videos', 'Post Type General Name', 'ww' ),
		'singular_name'         => _x( 'Video', 'Post Type Singular Name', 'ww' ),
		'menu_name'             => __( 'Videos', 'ww' ),
		'name_admin_bar'        => __( 'Video', 'ww' ),
		'archives'              => __( 'Video Archives', 'ww' ),
		'attributes'            => __( 'Video Attributes', 'ww' ),
		'parent_item_colon'     => __( 'Parent video:', 'ww' ),
		'all_items'             => __( 'All Videos', 'ww' ),
		'add_new_item'          => __( 'Add New video', 'ww' ),
		'add_new'               => __( 'Add New', 'ww' ),
		'new_item'              => __( 'New video', 'ww' ),
		'edit_item'             => __( 'Edit video', 'ww' ),
		'update_item'           => __( 'Update video', 'ww' ),
		'view_item'             => __( 'View video', 'ww' ),
		'view_items'            => __( 'View Videos', 'ww' ),
		'search_items'          => __( 'Search video', 'ww' ),
		'not_found'             => __( 'Not found', 'ww' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ww' ),
		'featured_image'        => __( 'Featured Image', 'ww' ),
		'set_featured_image'    => __( 'Set featured image', 'ww' ),
		'remove_featured_image' => __( 'Remove featured image', 'ww' ),
		'use_featured_image'    => __( 'Use as featured image', 'ww' ),
		'insert_into_item'      => __( 'Insert into video', 'ww' ),
		'uploaded_to_this_item' => __( 'Uploaded to this video', 'ww' ),
		'items_list'            => __( 'Videos list', 'ww' ),
		'items_list_navigation' => __( 'Videos list navigation', 'ww' ),
		'filter_items_list'     => __( 'Filter Videos list', 'ww' ),
	);
	$args   = array(
		'label'               => __( 'Video', 'ww' ),
		'description'         => __( 'Post Type Description', 'ww' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'excerpt', 'category'),
		'taxonomies'          => array( 'type'),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-video-alt3',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => 'podcasts-videos',
		'rewrite'             => array(
			'slug'       => 'video',
			'with_front' => false,
		),
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
	);
	register_post_type( 'video', $args );
}

/**
 * Register Events Post Type
 */
add_action( 'init', 'event_post_type', 0 );
function event_post_type() {

	$labels = array(
		'name'                  => _x( 'Events', 'Post Type General Name', 'ww' ),
		'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'ww' ),
		'menu_name'             => __( 'Events', 'ww' ),
		'name_admin_bar'        => __( 'Event', 'ww' ),
		'archives'              => __( 'Event Archives', 'ww' ),
		'attributes'            => __( 'Event Attributes', 'ww' ),
		'parent_item_colon'     => __( 'Parent event:', 'ww' ),
		'all_items'             => __( 'All Events', 'ww' ),
		'add_new_item'          => __( 'Add New event', 'ww' ),
		'add_new'               => __( 'Add New', 'ww' ),
		'new_item'              => __( 'New event', 'ww' ),
		'edit_item'             => __( 'Edit event', 'ww' ),
		'update_item'           => __( 'Update event', 'ww' ),
		'view_item'             => __( 'View event', 'ww' ),
		'view_items'            => __( 'View Events', 'ww' ),
		'search_items'          => __( 'Search event', 'ww' ),
		'not_found'             => __( 'Not found', 'ww' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ww' ),
		'featured_image'        => __( 'Featured Image', 'ww' ),
		'set_featured_image'    => __( 'Set featured image', 'ww' ),
		'remove_featured_image' => __( 'Remove featured image', 'ww' ),
		'use_featured_image'    => __( 'Use as featured image', 'ww' ),
		'insert_into_item'      => __( 'Insert into event', 'ww' ),
		'uploaded_to_this_item' => __( 'Uploaded to this event', 'ww' ),
		'items_list'            => __( 'Events list', 'ww' ),
		'items_list_navigation' => __( 'Events list navigation', 'ww' ),
		'filter_items_list'     => __( 'Filter Events list', 'ww' ),
	);
	$args   = array(
		'label'               => __( 'Event', 'ww' ),
		'description'         => __( 'Post Type Description', 'ww' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'excerpt' ),
		'taxonomies'          => array( 'category' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-groups',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => 'events',
		'rewrite'             => array(
			'slug'       => 'event',
			'with_front' => false,
		),
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
	);
	register_post_type( 'event', $args );
}

/**
 * Register Partner Content Post Type
 */
add_action( 'init', 'partner_content_post_type', 0 );
function partner_content_post_type() {

	$labels = array(
		'name'                  => _x( 'Partner content', 'Post Type General Name', 'ww' ),
		'singular_name'         => _x( 'Partner content', 'Post Type Singular Name', 'ww' ),
		'menu_name'             => __( 'Partner content', 'ww' ),
		'name_admin_bar'        => __( 'Partner content', 'ww' ),
		'archives'              => __( 'Partner content Archives', 'ww' ),
		'attributes'            => __( 'Partner content Attributes', 'ww' ),
		'parent_item_colon'     => __( 'Parent partner content:', 'ww' ),
		'all_items'             => __( 'All partner content', 'ww' ),
		'add_new_item'          => __( 'Add New partner content', 'ww' ),
		'add_new'               => __( 'Add New', 'ww' ),
		'new_item'              => __( 'New partner content', 'ww' ),
		'edit_item'             => __( 'Edit partner content', 'ww' ),
		'update_item'           => __( 'Update partner content', 'ww' ),
		'view_item'             => __( 'View partner content', 'ww' ),
		'view_items'            => __( 'View partner content', 'ww' ),
		'search_items'          => __( 'Search partner content', 'ww' ),
		'not_found'             => __( 'Not found', 'ww' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ww' ),
		'featured_image'        => __( 'Featured Image', 'ww' ),
		'set_featured_image'    => __( 'Set featured image', 'ww' ),
		'remove_featured_image' => __( 'Remove featured image', 'ww' ),
		'use_featured_image'    => __( 'Use as featured image', 'ww' ),
		'insert_into_item'      => __( 'Insert into partner content', 'ww' ),
		'uploaded_to_this_item' => __( 'Uploaded to this partner content', 'ww' ),
		'items_list'            => __( 'Partner content list', 'ww' ),
		'items_list_navigation' => __( 'Partner content list navigation', 'ww' ),
		'filter_items_list'     => __( 'Filter partner content list', 'ww' ),
	);
	$args   = array(
		'label'               => __( 'Partner content', 'ww' ),
		'description'         => __( 'Post Type Description', 'ww' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'taxonomies'          => array( 'partner' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-money-alt',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => 'partner_content',
		'rewrite'             => array(
			'slug'       => 'partner-content',
			'with_front' => false,
		),
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
	);
	register_post_type( 'partner_content', $args );
}