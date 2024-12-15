<a href="<?php the_permalink(); ?>">
    <div class="image-wrapper">
        <?php
        $thumbnail_id = get_post_thumbnail_id( $post->ID );
        $image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
        ?>

        <?php if ($term_name === 'Video' || $term_name === 'Podcast') { ?>
            <button class="play-button" aria-label="Play Video">
                <?php
                if ($term_name === 'Video') {
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
    <div class="content">
        <p class="term"><?php echo $term_name; ?></p>
        <p class="title"><?php the_title(); ?></p>
        <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
    </div>
</a>