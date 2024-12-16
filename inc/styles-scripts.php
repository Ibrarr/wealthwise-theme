<?php

add_action( 'wp_enqueue_scripts', 'add_custom_scripts' );
function add_custom_scripts() {
	wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', [ 'jquery' ], '1.12.1', true );

	wp_enqueue_style( 'site', WW_TEMPLATE_URI . '/dist/css/app.css', [], filemtime( WW_TEMPLATE_DIR . '/dist/css/app.css' ), 'all' );

	wp_enqueue_script( 'header', WW_TEMPLATE_URI . '/dist/js/header.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/header.js' ), true );

    wp_enqueue_script( 'global', WW_TEMPLATE_URI . '/dist/js/global.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/global.js' ), true );

    if ( is_singular( 'post' ) ) {
        wp_enqueue_script( 'content-blog', WW_TEMPLATE_URI . '/dist/js/content-blog.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/content-blog.js' ), true );
    }

    if ( is_singular( 'video' ) ) {
        wp_enqueue_script( 'content-blog', WW_TEMPLATE_URI . '/dist/js/content-video.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/content-video.js' ), true );
    }

	if ( is_singular( 'event' ) ) {
		wp_enqueue_script( 'content-event', WW_TEMPLATE_URI . '/dist/js/content-event.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/content-event.js' ), true );
	}
}