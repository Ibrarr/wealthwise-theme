<div class="col-lg-3 col-md-6 col-12 mb-4 standard-article-card">
	<a href="<?php the_permalink(); ?>">
		<div class="image-wrapper">
			<?php
			$thumbnail_id = get_post_thumbnail_id( $post->ID );
			$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
			?>

            <?php if ($term_name === 'Partner Video' || $term_name === 'Podcast' || $term_name === 'Video') { ?>
                <button class="play-button <?php echo strtolower($term_name) ?>" aria-label="Play Video">
                    <?php
                    if ($term_name === 'Partner Video' || $term_name === 'Video') {
                        echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/video.svg' );
                    } else {
                        echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/podcast.svg' );
                    }
                    ?>
                </button>
			<?php } ?>
			<img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title(); ?>"
			     srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(min-width: 391px) 1024px, 100vw">
		</div>
		<p class="term">Choice words</p>
		<p class="title"><?php the_title(); ?></p>
        <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
		<?php if ($term_name === 'Partner Video' || $term_name === 'Podcast' || $term_name === 'Video') { ?>
            <p class="length"><?php echo get_post_meta( $post->ID, 'video_length', true ); ?> min</p>
		<?php } ?>
	</a>
</div>