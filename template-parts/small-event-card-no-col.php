<a href="<?php the_permalink(); ?>">
    <div class="event-card">
        <p class="title"><?php the_title(); ?></p>
        <p class="date-location"><?php echo DateTime::createFromFormat('Ymd', get_post_meta( $post->ID, 'date', true ))->format('jS F Y'); ?> | <?php echo get_post_meta( $post->ID, 'city', true ); ?></p>
        <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
    </div>
</a>