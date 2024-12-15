<a href="<?php the_permalink(); ?>">
    <p class="title"><?php the_title(); ?></p>
    <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
    <p class="length"><span><?php  echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/podcast.svg' ); ?></span><?php echo get_post_meta( $post->ID, 'video_length', true ); ?> min listen</p>
</a>