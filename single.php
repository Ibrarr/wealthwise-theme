<?php
get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();

		switch ( get_post_type() ) {
			case 'work':
				get_template_part( 'template-parts/content', 'work' );
				break;
			default:
				get_template_part( 'template-parts/content', 'blog' );
				break;
		}

	endwhile;
endif;

get_footer();