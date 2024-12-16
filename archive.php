<?php
get_header();

if (is_category()) {
    get_template_part( 'template-parts/archive', 'category' );
}

if ( is_tax() ) {
	$taxonomy = get_query_var( 'taxonomy' );
	switch ( $taxonomy ) {
		case 'partner':
			get_template_part( 'template-parts/archive', 'partner-single' );
			break;
		default:
			wp_redirect( home_url() );
			break;
	}
}



if ( is_post_type_archive() ) {
	switch ( get_post_type() ) {
		case 'video':
			get_template_part( 'template-parts/archive', 'video' );
			break;
        case 'event':
            get_template_part( 'template-parts/archive', 'event' );
            break;
        case 'partner_content':
            get_template_part( 'template-parts/archive', 'partner' );
            break;
		default:
			wp_redirect( home_url() );
			break;
	}
}


get_footer();