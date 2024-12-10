<?php

add_action( 'wp_enqueue_scripts', 'add_custom_scripts' );
function add_custom_scripts() {
	wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', [ 'jquery' ], '1.12.1', true );

	wp_enqueue_style( 'site', WW_TEMPLATE_URI . '/dist/css/app.css', [], filemtime( WW_TEMPLATE_DIR . '/dist/css/app.css' ), 'all' );

	wp_enqueue_script( 'header', WW_TEMPLATE_URI . '/dist/js/header.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/header.js' ), true );
//
//	if ( is_front_page() ) {
//		wp_enqueue_script( 'homepage', WW_TEMPLATE_URI . '/dist/js/homepage.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/homepage.js' ), true );
//	}
//
//	if ( is_home() ) {
//		wp_enqueue_script( 'blog-archive', WW_TEMPLATE_URI . '/dist/js/blog-archive.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/blog-archive.js' ), true );
//	}
//
//    if ( is_category() ) {
//        wp_enqueue_script( 'category-term', WW_TEMPLATE_URI . '/dist/js/category-term.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/category-term.js' ), true );
//    }
//
	if ( is_singular( 'event' ) ) {
		wp_enqueue_script( 'blog-single', WW_TEMPLATE_URI . '/dist/js/content-event.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/content-event.js' ), true );
	}
//
//    if ( is_search() || is_page_template( 'page-templates/page-search.php' ) ) {
//        wp_enqueue_script( 'search-page', WW_TEMPLATE_URI . '/dist/js/search.js', [ 'jquery' ], filemtime( WW_TEMPLATE_DIR . '/dist/js/search.js' ), true );
//    }
}