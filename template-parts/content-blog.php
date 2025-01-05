<?php
/**
 * The template for displaying posts
 *
 */

$post_type    = 'post';
$taxonomy     = 'category';
$terms        = get_the_terms( get_the_ID(), $taxonomy );
$term_name    = $terms[0]->name;

$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container px-4">
        <div class="border-top"></div>
		<section class="post-header row">
            <div class="col-lg-8 offset-lg-2">
                <p class="term"><?php echo $term_name; ?></p>
                <h1 class="title"><?php the_title(); ?></h1>
                <p class="excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                <div class="share-author">
                    <div class="share">
                        <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/share.svg' ) ?>
                        <div class="share-tooltip">
                            <a class="mail-icon"
                               href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=Check out this <?php echo $term_name; ?> post from Wealthwise <?php echo rawurlencode( get_permalink() ); ?>"
                               target="_blank"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/email-share.svg' ) ?> Copy Link</a>
                            <a class="linkedin-icon" rel="nofollow"
                               href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( get_permalink() ); ?>&title=<?php echo rawurlencode( get_the_title() ); ?>"
                               target="_blank"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/linkedin-share.svg' ) ?> Share on LinkedIn</a>
                        </div>
                    </div>
                    <div class="author">
                        <p>By <?php the_author(); ?> -
			                <?php
			                if (get_the_modified_date() !== get_the_date()) {
				                echo 'Updated ' . get_the_modified_date('jS F Y');
			                } else {
				                echo get_the_date('jS F Y');
			                }
			                ?>
                        </p>
                    </div>

                </div>
            </div>
		</section>

        <section class="header-image">
            <img src="<?php the_post_thumbnail_url() ?>" alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>"
                 srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(min-width: 391px) 1024px, 100vw">
        </section>

		<section class="post-content">
			<div class="top-section row">
                <div class="img-cred col-lg-2"><p><?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?></p></div>
				<div class="content col-lg-8">
					<?php the_field( 'first_section' ); ?>
                </div>
                <?php if ( get_field( 'side_quote' )) { ?>
                    <div class="side-quote col-lg-2">
                        <p>“<?php the_field( 'side_quote' ); ?></p>
                        <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/quote.svg' ) ?>
                    </div>
                <?php } ?>
            </div>

           <div class="rest-of-content row">
	           <?php
	           if( have_rows('content') ):
		           while ( have_rows('content') ) : the_row();

			           if( get_row_layout() == 'regular_content' ):
				           $content = get_sub_field('content');
				           ?>
                           <div class="regular-content col-lg-8 offset-lg-2">
					           <?php echo $content; ?>
                           </div>
                       <?php

                       elseif( get_row_layout() == 'single_image' ):
				           $image = get_sub_field('image');
	                       ?>
                           <div class="single-image col-lg-10 offset-lg-2">
                               <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                               <p><?php echo esc_attr($image['alt']); ?></p>
                           </div>
                       <?php
                           
                       elseif( get_row_layout() == 'block_content' ):
				           $content = get_sub_field('content');
	                       ?>
                           <div class="block-content col-lg-10 offset-lg-2">
		                       <div class="content"><?php echo $content; ?></div>
                           </div>
                       <?php

                       elseif( get_row_layout() == 'two_image' ):
				           $image_one = get_sub_field('image_one');
				           $image_two = get_sub_field('image_two');
	                       ?>
                           <div class="double-image col-md-6">
                               <img src="<?php echo esc_url($image_one['url']); ?>" alt="<?php echo esc_attr($image_one['alt']); ?>">
                               <p><?php echo esc_attr($image_one['alt']); ?></p>
                           </div>
                           <div class="double-image col-md-6">
                               <img src="<?php echo esc_url($image_two['url']); ?>" alt="<?php echo esc_attr($image_two['alt']); ?>">
                               <p><?php echo esc_attr($image_two['alt']); ?></p>
                           </div>

                       <?php

                       elseif( get_row_layout() == 'inline_quote' ):
				           $quote = get_sub_field('quote');
	                       ?>
                           <div class="inline-quote col-lg-8 offset-lg-2">
                               <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/quote-two.svg' ) ?>
                               <p><?php echo $quote; ?>”</p>
                           </div>
                       <?php
			           endif;
		           endwhile;
	           endif;
	           ?>
           </div>

            <div class="col-lg-8 offset-lg-2 owl"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/logos/owl.svg' ) ?></div>
		</section>

        <section class="related-content">
            <h3>More <?php echo $term_name; ?></h3>
            <div class="row mb-3">
		        <?php
		        $related_posts = new WP_Query(array(
			        'post_type' => $post_type,
			        'posts_per_page' => 4,
			        'post__not_in' => array(get_the_ID()),
			        'tax_query' => array(
				        array(
					        'taxonomy' => $taxonomy,
					        'field' => 'name',
					        'terms' => $term_name,
				        ),
			        ),
		        ));

		        if ($related_posts->have_posts()) :
			        while ($related_posts->have_posts()) : $related_posts->the_post();
				        require('standard-article-card.php');
			        endwhile;
			        wp_reset_postdata();
		        else :
			        echo '<p>No related posts available at the moment.</p>';
		        endif;
		        ?>
            </div>
        </section>
	</div>
</article>