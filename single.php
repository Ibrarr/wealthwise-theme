<?php
get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();

		switch ( get_post_type() ) {
			case 'video':
				get_template_part( 'template-parts/content', 'video' );
				break;
			case 'event':
				get_template_part( 'template-parts/content', 'event' );
				break;
			default:
				get_template_part( 'template-parts/content', 'blog' );
				break;
		}

	endwhile;
endif;

get_footer();