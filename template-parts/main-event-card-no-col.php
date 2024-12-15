<a href="<?php the_permalink(); ?>">
    <div class="event-card">
        <div class="image-wrapper">
		    <?php
		    $thumbnail_id = get_post_thumbnail_id( $post->ID );
		    $image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
		    ?>
            <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title(); ?>"
                 srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(min-width: 391px) 1024px, 100vw">
        </div>
        <div class="content">
            <p class="term">Events</p>
            <p class="title"><?php the_title(); ?></p>
            <p class="date-location"><?php echo DateTime::createFromFormat('Ymd', get_post_meta( $post->ID, 'date', true ))->format('jS F Y'); ?> | <?php echo get_post_meta( $post->ID, 'city', true ); ?></p>
            <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
        </div>
    </div>
</a>