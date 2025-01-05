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
	        <?php
	        $start_date = get_post_meta( $post->ID, 'start_date', true );
	        $end_date = get_post_meta( $post->ID, 'end_date', true );

	        if ($start_date === $end_date) {
		        echo '<p class="date-location">' . date('jS F Y', strtotime($start_date)) . ' | '.get_post_meta( $post->ID, 'city', true ).'</p>';
	        } else {
		        echo '<p class="date-location">' . date('jS', strtotime($start_date)) . ' - ' . date('jS F Y', strtotime($end_date)) . ' | '.get_post_meta( $post->ID, 'city', true ).'</p>';
	        }
	        ?>
            <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
        </div>
    </div>
</a>