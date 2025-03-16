<?php
/**
 * The template for displaying videos
 *
 */

$post_type    = 'video';
$taxonomy     = 'type';
$terms        = get_the_terms( get_the_ID(), $taxonomy );
$term_name    = $terms[0]->name;

$cat_terms    = get_the_terms(get_the_ID(), 'category');
$cat_term_name = $cat_terms[0]->name ?? '';

$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );

if ($term_name === 'Partner Video' && $cat_term_name === 'Choice words' || $term_name === 'Video' && $cat_term_name === 'Choice words') {
    $term_to_show = 'Choice words';
} else {
    $term_to_show = $term_name;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container px-4">
        <div class="border-top"></div>
		<section class="post-header row">
            <div class="col-lg-8 offset-lg-2">
                <p class="term"><?php echo $term_to_show; ?></p>
                <div class="title-share">
                    <h1 class="title"><?php the_title(); ?></h1>
                    <div class="share">
                        <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/share.svg' ) ?>
                        <div class="share-tooltip">
                            <a class="mail-icon"
                               href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=Check out this <?php echo $term_name; ?> from Wealthwise <?php echo rawurlencode( get_permalink() ); ?>"
                               target="_blank"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/email-share.svg' ) ?> Email this article</a>
                            <a class="linkedin-icon" rel="nofollow"
                               href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( get_permalink() ); ?>&title=<?php echo rawurlencode( get_the_title() ); ?>"
                               target="_blank"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/linkedin-share.svg' ) ?> Share on LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>
		</section>

        <section class="video-container <?php echo strtolower($term_name) ?>">
            <div class="embed-container">
				<?php
				$iframe = get_field('video');
				preg_match('/src="(.+?)"/', $iframe, $matches);
				$src = $matches[1];

				// Build the base YouTube URL with common parameters.
				$base_src = add_query_arg(array(
					'controls' => 1,
					'hd'       => 1,
					'autohide' => 1,
				), $src);
				?>
                <div class="video-cover" style="background-image: url('<?php the_post_thumbnail_url() ?>');">
                    <button class="play-button" aria-label="Play Video">
						<?php
						if ($term_name === 'Partner Video' || $term_name === 'Video') {
							echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/video.svg' );
						} else {
							echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/podcast.svg' );
						}
                        
						?>
                    </button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    // Converts a string timestamp like "1:30" or "01:02:30" to seconds.
                    function parseTimestamp(timestampStr) {
                        var parts = timestampStr.split(':');
                        var seconds = 0;
                        if (parts.length === 2) { // mm:ss
                            seconds = parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
                        } else if (parts.length === 3) { // hh:mm:ss
                            seconds = parseInt(parts[0], 10) * 3600 +
                                parseInt(parts[1], 10) * 60 +
                                parseInt(parts[2], 10);
                        } else {
                            seconds = parseInt(timestampStr, 10);
                        }
                        return seconds;
                    }

                    // Loads the video into the embed container.
                    // If a startSeconds value is provided, it is appended to the YouTube URL.
                    function loadVideo(startSeconds) {
                        var videoSrc = '<?php echo esc_js($base_src); ?>';
                        if (startSeconds !== undefined && startSeconds !== null) {
                            videoSrc += '&start=' + startSeconds;
                        }
                        videoSrc += '&autoplay=1';

                        // Adjust padding-bottom if termName is 'podcast'.
                        if (termName === 'podcast') {
                            embedContainer.style.paddingBottom = '20%';
                        }

                        // Create the iframe element dynamically.
                        var iframe = document.createElement('iframe');
                        iframe.src = videoSrc;
                        iframe.frameBorder = '0';
                        iframe.allowFullscreen = true;
                        iframe.allow = 'autoplay';

                        // Clear existing content and insert the iframe.
                        embedContainer.innerHTML = '';
                        embedContainer.appendChild(iframe);
                    }

                    var videoCover = document.querySelector('.video-cover');
                    var embedContainer = document.querySelector('.embed-container');
                    var termName = '<?php echo strtolower($term_name); ?>';

                    // Check if the URL hash contains a timestamp (e.g. "#timestamp-1:30")
                    var initialStartSeconds = null;
                    if (window.location.hash && window.location.hash.indexOf('#timestamp-') === 0) {
                        var timestampStr = window.location.hash.replace('#timestamp-', '');
                        initialStartSeconds = parseTimestamp(timestampStr);
                    }

                    // When the video cover is clicked, load the video
                    // using the timestamp from the URL hash if present.
                    if (videoCover && embedContainer) {
                        videoCover.addEventListener('click', function () {
                            loadVideo(initialStartSeconds);
                        });
                    }

                    // Listen for hash changes (in case a user clicks a timestamp link after page load)
                    window.addEventListener('hashchange', function () {
                        if (window.location.hash && window.location.hash.indexOf('#timestamp-') === 0) {
                            var timestampStr = window.location.hash.replace('#timestamp-', '');
                            var newStartSeconds = parseTimestamp(timestampStr);
                            loadVideo(newStartSeconds);

                            // Scroll smoothly to the .post-header element.
                            var header = document.querySelector('.post-header');
                            if (header) {
                                header.scrollIntoView({ behavior: 'smooth' });
                            }
                        }
                    });

                    // Additionally, capture clicks on any links with a '#timestamp-' hash.
                    document.querySelectorAll('a[href^="#timestamp-"]').forEach(function(anchor) {
                        anchor.addEventListener('click', function(e) {
                            e.preventDefault(); // Prevent default jump behavior.
                            var hash = this.getAttribute('href');
                            if (hash.indexOf('#timestamp-') === 0) {
                                var timestampStr = hash.replace('#timestamp-', '');
                                var newStartSeconds = parseTimestamp(timestampStr);
                                loadVideo(newStartSeconds);

                                // Scroll smoothly to the .post-header element.
                                var header = document.querySelector('.post-header');
                                if (header) {
                                    header.scrollIntoView({ behavior: 'smooth' });
                                }

                                // Update the URL hash in the browser history without triggering a jump.
                                window.history.pushState(null, null, hash);
                            }
                        });
                    });

                    // If you prefer the video to auto-load when a timestamp is present,
                    // uncomment the following lines:
                    // if (initialStartSeconds !== null) {
                    //     loadVideo(initialStartSeconds);
                    // }
                });
            </script>
        </section>

		<section class="post-content">
			<div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <p class="excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <div class="content"><?php the_field( 'content' ); ?></div>
                </div>
				<?php
				if( have_rows('extra_content') ):
					while ( have_rows('extra_content') ) : the_row();

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

                        elseif( get_row_layout() == 'small_inline_quote' ):
							$quote = get_sub_field('quote');
							?>
                            <div class="small-inline-quote col-lg-8 offset-lg-2">
                                <p>“<?php echo $quote; ?>”</p>
                            </div>
						<?php
						endif;
					endwhile;
				endif;
				?>
            </div>
		</section>

        <section class="related-content">
            <h3>Recommended</h3>
            <div class="row mb-3">
		        <?php
		        $related_posts = new WP_Query(array(
			        'post_type' => $post_type,
			        'posts_per_page' => 4,
			        'post__not_in' => array(get_the_ID()),
		        ));

		        if ($related_posts->have_posts()) :
			        while ($related_posts->have_posts()) : $related_posts->the_post();
				        $type = get_the_terms(get_the_ID(), $taxonomy);
				        $term_name = $type[0]->name;

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
	<?php require get_template_directory() . '/template-parts/section-partner-zone-only-four.php'; ?>
</article>