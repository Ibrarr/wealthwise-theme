<?php
/**
 * The template for displaying videos
 *
 */

$post_type    = 'video';
$taxonomy     = 'type';
$terms        = get_the_terms( get_the_ID(), $taxonomy );
$term_name    = $terms[0]->name;

$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container px-4">
		<section class="post-header row">
            <div class="col-lg-8 offset-lg-2">
                <p class="term"><?php echo $term_name; ?></p>
                <div class="title-share">
                    <h1 class="title"><?php the_title(); ?></h1>
                    <div class="share">
                        <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/share.svg' ) ?>
                        <div class="share-tooltip">
                            <a class="mail-icon"
                               href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=Check out this <?php echo $term_name; ?> from Wealthwise <?php echo rawurlencode( get_permalink() ); ?>"
                               target="_blank"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/email-share.svg' ) ?> Copy Link</a>
                            <a class="linkedin-icon" rel="nofollow"
                               href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( get_permalink() ); ?>&title=<?php echo rawurlencode( get_the_title() ); ?>"
                               target="_blank"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/linkedin-share.svg' ) ?> Share on LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>
		</section>

        <section class="video-container">
            <div class="embed-container">
				<?php
				$iframe = get_field('video');

				preg_match('/src="(.+?)"/', $iframe, $matches);
				$src = $matches[1];

				$base_src = add_query_arg(array(
					'controls' => 1,
					'hd'       => 1,
					'autohide' => 1,
				), $src);
				?>

                <div class="video-cover" style="background-image: url('<?php the_post_thumbnail_url() ?>');">
                    <button class="play-button" aria-label="Play Video">
                        <?php
                        if ($term_name === 'Video') {
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
                    const videoCover = document.querySelector('.video-cover');
                    const embedContainer = document.querySelector('.embed-container');

                    if (videoCover && embedContainer) {
                        videoCover.addEventListener('click', function () {
                            const videoSrc = '<?php echo esc_js($base_src); ?>&autoplay=1';

                            // Create iframe dynamically
                            const iframe = document.createElement('iframe');
                            iframe.src = videoSrc;
                            iframe.frameBorder = '0';
                            iframe.allowFullscreen = true;
                            iframe.allow = 'autoplay';

                            embedContainer.innerHTML = '';
                            embedContainer.appendChild(iframe);
                        });
                    }
                });
            </script>
        </section>


		<section class="post-content">
			<div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <p class="excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <div class="content"><?php the_field( 'content' ); ?></div>
                </div>
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
</article>