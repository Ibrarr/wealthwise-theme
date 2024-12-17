<?php

/**
 * Update the post author with the one selected from the ACF field
 */
add_action( 'acf/save_post', 'update_author_to_acf_field', 20 );
function update_author_to_acf_field( $post_id ) {
	$user = get_field( 'author', $post_id );
	if ( $user ) {
		wp_update_post( array( 'ID' => $post_id, 'post_author' => $user['ID'] ) );
	}
}

/**
 * Directory to save ACF fields to
 */
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );
function my_acf_json_save_point( $path ) {
	return WW_TEMPLATE_DIR . '/acf-json';
}

/**
 * Make the file save as the name of the field group
 */
add_filter( 'acf/json/save_file_name', 'custom_acf_json_filename', 10, 3 );
function custom_acf_json_filename( $filename, $post, $load_path ) {
	// Generate filename from the field group title
	$filename = str_replace(
		array( ' ', '_' ),
		array( '-', '-' ),
		$post['title']
	);
	$filename = strtolower( $filename ) . '.json';

	return $filename;
}

/**
 * Where to load ACF fields from
 */
add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );
function my_acf_json_load_point( $paths ) {
	// Remove the original path (optional)
	unset( $paths[0] );

	// Append the new path and return it
	$paths[] = WW_TEMPLATE_DIR . '/acf-json';

	return $paths;
}

/**
 * Automatically save/load Option Page field values to the JSON directory
 */
add_action('acf/update_value', 'save_acf_option_page_fields', 10, 3);
function save_acf_option_page_fields( $value, $post_id, $field ) {
	// Check if saving to an options page
	if (strpos($post_id, 'options') === 0) {
		$file_path = WW_TEMPLATE_DIR . '/acf-json/options.json';
		$options = get_fields('options'); // Fetch all options

		if ($options) {
			file_put_contents( $file_path, wp_json_encode( $options, JSON_PRETTY_PRINT ) );
		}
	}
	return $value;
}

/**
 * Load Option Page field values from the JSON file
 */
add_action('acf/init', 'load_acf_option_page_fields');
function load_acf_option_page_fields() {
	$file_path = WW_TEMPLATE_DIR . '/acf-json/options.json';

	if ( file_exists( $file_path ) ) {
		$options = json_decode( file_get_contents( $file_path ), true );

		if ( $options ) {
			foreach ( $options as $key => $value ) {
				update_field( $key, $value, 'options' );
			}
		}
	}
}