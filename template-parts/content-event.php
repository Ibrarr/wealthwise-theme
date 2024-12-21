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
<div class="event-registration-popup">
    <div class="close"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/menu-cross.svg' ) ?></div>
    <h3>Event registration</h3>
    <p class="date">Date: <?php the_field( 'date' ); ?></p>
    <p class="location">Location: <?php the_field( 'full_address' ); ?></p>
    <?php echo do_shortcode( '[gravityform id="' . get_field( 'event_signup_form' ) . '" title="false" description="false" ajax="true"]' ); ?>
    <img src="<?php the_post_thumbnail_url() ?>" alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>"
         srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(min-width: 391px) 1024px, 100vw">
</div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container px-4">
		<section class="post-header row">
            <div class="info col-lg-5">
                <p class="term">Event</p>
                <h1 class="title"><?php the_title(); ?></h1>
                <p class="date">Date: <?php the_field( 'date' ); ?></p>
                <p class="location">Location: <?php the_field( 'full_address' ); ?></p>
            </div>
            <div class="image col-lg-7">
                <img src="<?php the_post_thumbnail_url() ?>" alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>"
                     srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(min-width: 391px) 1024px, 100vw">
            </div>
		</section>

		<section class="post-content">
			<div class="top-section row">
                <div class="register col-lg-2">
                    <button>Register</button>
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
                </div>
				<div class="excerpt-intro col-lg-8">
					<p class="excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
					<?php the_field( 'intro' ); ?>
                </div>
                <div class="share col-lg-2">
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
            </div>

            <div class="agenda col-lg-8 offset-lg-2">
                <div class="content">
                    <h3><?php the_field( 'agenda_heading' ); ?></h3>
                    <div class="accordion-container">
	                    <?php
	                    if( have_rows('agenda') ):
		                    while( have_rows('agenda') ) : the_row();
			                    $heading = get_sub_field('heading');
			                    echo '<div class="accordion">';
                                    echo '<h5>'.$heading.' <span class="open" style="display: none;">'.file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/event-minus.svg' ).'</span> <span class="closed">'.file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/event-plus.svg' ).'</span></h5>';
                                    echo '<div class="accordion-content">';
                                        if( have_rows('item') ):
                                            while( have_rows('item') ) : the_row();
                                                $time_slot = get_sub_field('time_slot');
                                                $heading = get_sub_field('heading');
                                                echo '<div class="slot"><p class="time">'.$time_slot.'</p><p class="heading">'.$heading.'</p></div>';
                                            endwhile;
                                        endif;
                                    echo '</div>';
			                    echo '</div>';
		                    endwhile;
	                    endif;
	                    ?>
                    </div>
                </div>
            </div>

            <div class="sponsor-logos col-lg-8 offset-lg-2">
                <div class="splide" id="sponsorLogosSlider">
                    <div class="splide__track">
                        <ul class="splide__list">
							<?php
							$images = get_field('sponsor_logos');
							if( $images ):
								foreach( $images as $image ): ?>
                                    <li class="splide__slide">
                                        <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                    </li>
								<?php endforeach;
							endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="content-speakers col-lg-8 offset-lg-2">
                <h3>Content & Speakers</h3>
                <?php the_field( 'content_speakers_intro' ); ?>
                <div class="content-speakers-items">
	                <?php
	                if( have_rows('content_speakers') ):
		                while( have_rows('content_speakers') ) : the_row();
                            echo '<div class="content-speakers-item">';
                                $heading_one = get_sub_field('heading_one');
                                $heading_two = get_sub_field('heading_two');
                                $content = get_sub_field('content');
                                $speaker_image = get_sub_field('speaker_image');
                                $speaker_name = get_sub_field('speaker_name');
                                $speaker_job_title = get_sub_field('speaker_job_title');
                                $speaker_company = get_sub_field('speaker_company');
                                $speaker_about = get_sub_field('speaker_about');
                                ?>
                                <h4><?php echo $heading_one; ?></h4>
                                <h4 class="heading-two"><?php echo $heading_two; ?></h4>
                                <p class="content"><?php echo $content; ?></p>
                                <div class="speaker">
                                    <div class="img-container">
                                        <img src="<?php echo $speaker_image; ?>" alt="<?php echo $speaker_name; ?>">
                                    </div>
                                    <div class="speaker-info">
                                        <p class="speaker-job-title"><?php echo $speaker_job_title; ?></p>
                                        <p class="speaker-name"><?php echo $speaker_name; ?></p>
                                        <p class="speaker-company"><?php echo $speaker_company; ?></p>
                                        <p class="speaker-about"><?php echo $speaker_about; ?></p>
                                    </div>
                                </div>
                                <?php
			                echo '</div>';
		                endwhile;
	                endif;
	                ?>
                </div>
            </div>

            <div class="location col-lg-10 offset-lg-2">
                <h3>Location</h3>
	            <p><?php the_field( 'full_address' ); ?>, <?php the_field( 'postcode' ); ?></p>
	            <p>For Sat Navs use: <?php the_field( 'postcode' ); ?></p>
                <div class="img-container">
                    <img src="<?php the_field( 'map_location' ); ?>" alt="<?php the_field( 'postcode' ); ?>">
                </div>
            </div>

            <div class="faq col-lg-8 offset-lg-2">
                <h3>Frequently asked questions</h3>
                <p><?php the_field( 'contact_intro' ); ?></p>
                <div class="accordion-container">
		            <?php
		            if( have_rows('faq') ):
			            while( have_rows('faq') ) : the_row();
				            $heading = get_sub_field('question');
				            $answer = get_sub_field('answer');
				            echo '<div class="accordion">';
				            echo '<h5>'.$heading.' <span class="open" style="display: none;">'.file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/event-minus.svg' ).'</span> <span class="closed">'.file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/event-plus.svg' ).'</span></h5>';
				            echo '<div class="accordion-content">';
				            echo '<p>'.$answer.'</p>';
				            echo '</div>';
				            echo '</div>';
			            endwhile;
		            endif;
		            ?>
                </div>
            </div>

            <div class="contact col-lg-8 offset-lg-2">
                <h3>Contact us</h3>
                <p><?php the_field( 'contact_intro' ); ?></p>
                <div class="contact-person">
                    <div class="img-container">
                        <img src="<?php the_field( 'contact_image' ); ?>" alt="<?php the_field( 'contact_name' ); ?>">
                    </div>
                    <div class="speaker-info">
                        <p class="name"><?php the_field( 'contact_name' ); ?></p>
                        <p class="job-title"><?php the_field( 'contact_job_title' ); ?></p>
                        <p class="email"><a href="mailto:<?php the_field( 'contact_email' ); ?>"><?php the_field( 'contact_email' ); ?></a></p>
                        <p class="phone"><a href="tel:<?php the_field( 'contact_phone' ); ?>"><?php the_field( 'contact_phone' ); ?></a></p>
                    </div>
                </div>
            </div>
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