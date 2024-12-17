<?php
get_header();

$lead_post_top_id     = get_field('lead_post_top', 'option')->ID ?? null;
$second_post_top_id   = get_field('second_post_top', 'option')->ID ?? null;
$third_post_top_id    = get_field('third_post_top', 'option')->ID ?? null;
$fourth_post_top_id   = get_field('fourth_post_top', 'option')->ID ?? null;

$post_ids = [];
$video_ids = [];
$podcast_ids = [];
$event_ids = [];
?>

<section class="hero">
    <div class="container px-4">
        <div class="row">
            <!-- LEFT COLUMN -->
            <div class="col-lg-3 left">
                <?php
                if ($second_post_top_id) {
                    $post = get_post($second_post_top_id);
                    setup_postdata($post);
                    $term_name = get_the_terms(get_the_ID(), 'category')[0]->name;
                    require('template-parts/archive-standard-article-card.php');
                    wp_reset_postdata();
                    $post_ids[] = $second_post_top_id;
                }

                if ($third_post_top_id) {
                    $post = get_post($third_post_top_id);
                    setup_postdata($post);
                    $term_name = get_the_terms(get_the_ID(), 'category')[0]->name;
                    require('template-parts/archive-standard-article-card.php');
                    wp_reset_postdata();
                    $post_ids[] = $third_post_top_id;
                }

                $remaining_left = 2 - count($post_ids);
                if ($remaining_left > 0) {
                    $left_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => $remaining_left,
                        'post_status'    => 'publish',
                        'post__not_in'   => $post_ids,
                    ));

                    if ($left_query->have_posts()) :
                        while ($left_query->have_posts()) : $left_query->the_post();
                            $post_ids[] = get_the_ID();
                            $term_name = get_the_terms(get_the_ID(), 'category')[0]->name;
                            require('template-parts/archive-standard-article-card.php');
                        endwhile;
                    endif;
                    wp_reset_postdata();
                }
                ?>
            </div>

            <!-- MIDDLE COLUMN -->
            <div class="col-lg-6 middle">
                <?php
                if ($lead_post_top_id) {
                    $post = get_post($lead_post_top_id);
                    setup_postdata($post);
                    $term_name = get_the_terms(get_the_ID(), 'category')[0]->name;
                    require('template-parts/archive-standard-article-card.php');
                    wp_reset_postdata();
                    $post_ids[] = $lead_post_top_id;
                }

                if ($fourth_post_top_id) {
                    $post = get_post($fourth_post_top_id);
                    setup_postdata($post);
                    $term_name = get_the_terms(get_the_ID(), 'category')[0]->name;
                    require('template-parts/archive-standard-article-card.php');
                    wp_reset_postdata();
                    $post_ids[] = $fourth_post_top_id;
                }

                $remaining_middle = 2 - count(array_intersect($post_ids, [$lead_post_top_id, $fourth_post_top_id]));
                if ($remaining_middle > 0) {
                    $middle_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => $remaining_middle,
                        'post_status'    => 'publish',
                        'post__not_in'   => $post_ids,
                    ));

                    if ($middle_query->have_posts()) :
                        while ($middle_query->have_posts()) : $middle_query->the_post();
                            $post_ids[] = get_the_ID();
                            $term_name = get_the_terms(get_the_ID(), 'category')[0]->name;
                            require('template-parts/archive-standard-article-card.php');
                        endwhile;
                    endif;
                    wp_reset_postdata();
                }
                ?>
            </div>
            <div class="col-lg-3 right">
                <p class="zone-header">Partner zone</p>
                <?php
                $right_query = new WP_Query(array(
                    'post_type' => 'partner_content',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                ));

                if ($right_query->have_posts()) :
                    while ($right_query->have_posts()) : $right_query->the_post();
                        $post_ids[] = get_the_ID();
                        $terms     = get_the_terms(get_the_ID(), 'partner');
                        $term_name = $terms[0]->name;
                        ?>
                        <?php require('template-parts/archive-partner-card-short.php'); ?>
                    <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>

                <div class="search inline">
                    <br>
                    <div class="search-box">
                        <span>Search</span>
                        <div class="icon"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/search.svg' ) ?></div>
                    </div>
                    <div class="sponsor">
                        <span>Sponsored by:</span>
                        <img src="<?php the_field( 'sponsor_logo_dark', 'option' ); ?>" alt="sponsor-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="analysis">
    <div class="container px-4">
        <div class="row">
            <h3>Analysis</h3>
            <?php
            $acf_analysis_posts = get_field('posts_second', 'option') ?? [];
            $analysis_post_ids = []; // Local array for posts in this section

            if (!empty($acf_analysis_posts)) {
                foreach ($acf_analysis_posts as $acf_post) {
                    // Ensure the post object is valid
                    if (is_a($acf_post, 'WP_Post')) {
                        global $post;
                        $post = $acf_post;
                        setup_postdata($post);

                        $post_ids[] = $post->ID;
                        $analysis_post_ids[] = $post->ID;

                        $terms = get_the_terms($post->ID, 'category');
                        $term_name = $terms[0]->name ?? '';

                        require('template-parts/standard-article-card.php');
                        wp_reset_postdata();

                        if (count($analysis_post_ids) >= 4) {
                            break;
                        }
                    }
                }
            }

            $remaining_posts = 4 - count($analysis_post_ids);

            if ($remaining_posts > 0) {
                $analysis_query = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => $remaining_posts,
                    'post_status'    => 'publish',
                    'post__not_in'   => $post_ids,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'name',
                            'terms'    => 'Analysis',
                        ),
                    ),
                ));

                if ($analysis_query->have_posts()) :
                    while ($analysis_query->have_posts()) : $analysis_query->the_post();
                        $post_ids[] = get_the_ID();
                        $analysis_post_ids[] = get_the_ID();

                        $terms = get_the_terms(get_the_ID(), 'category');
                        $term_name = $terms[0]->name ?? '';

                        require('template-parts/standard-article-card.php');
                    endwhile;
                endif;

                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</section>


<section class="partner-zone">
    <div class="container px-4">
        <div class="row">
            <h3>Partner zone</h3>
            <?php
            $partner_query = new WP_Query(array(
                'post_type' => 'partner_content',
                'posts_per_page' => 4,
                'post_status'    => 'publish',
            ));

            if ($partner_query->have_posts()) :
                while ($partner_query->have_posts()) : $partner_query->the_post();
                    $terms     = get_the_terms(get_the_ID(), 'partner');
                    $term_name = $terms[0]->name;
                    ?>
                    <?php require('template-parts/standard-article-card.php'); ?>
                <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<section class="videos">
    <div class="container px-4">
        <div class="row">
            <h3>Videos</h3>
            <?php
            $acf_videos_posts = get_field('videos_section', 'option') ?? [];
            $video_ids = [];

            if (!empty($acf_videos_posts)) {
                foreach ($acf_videos_posts as $acf_video) {
                    if (is_a($acf_video, 'WP_Post')) {
                        global $post;
                        $post = $acf_video;
                        setup_postdata($post);

                        $video_ids[] = $post->ID;

                        $terms = get_the_terms($post->ID, 'type');
                        $term_name = $terms[0]->name ?? '';

                        echo '<div class="col-lg-4 col-12 mb-4 standard-article-card">';
                        require('template-parts/standard-video-card-no-col.php');
                        echo '</div>';

                        wp_reset_postdata();

                        if (count($video_ids) >= 3) {
                            break;
                        }
                    }
                }
            }

            $remaining_videos = 3 - count($video_ids);

            if ($remaining_videos > 0) {
                $videos_query = new WP_Query(array(
                    'post_type'      => 'video',
                    'posts_per_page' => $remaining_videos,
                    'post_status'    => 'publish',
                    'post__not_in'   => $video_ids,
                ));

                if ($videos_query->have_posts()) :
                    while ($videos_query->have_posts()) : $videos_query->the_post();
                        $video_ids[] = get_the_ID();

                        $terms = get_the_terms(get_the_ID(), 'type');
                        $term_name = $terms[0]->name ?? '';

                        echo '<div class="col-lg-4 col-12 mb-4 standard-article-card">';
                        require('template-parts/standard-video-card-no-col.php');
                        echo '</div>';
                    endwhile;
                endif;

                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</section>

<section class="choice-words">
    <div class="container px-4">
        <div class="row">
            <h3>Choice Words</h3>
            <?php
            $acf_choice_posts = get_field('choice_words_posts', 'option') ?? [];
            $choice_post_ids = [];

            if (!empty($acf_choice_posts)) {
                foreach ($acf_choice_posts as $acf_post) {
                    if (is_a($acf_post, 'WP_Post')) {
                        global $post;
                        $post = $acf_post;
                        setup_postdata($post);

                        $post_ids[] = $post->ID;
                        $choice_post_ids[] = $post->ID;

                        require('template-parts/standard-article-card.php');
                        wp_reset_postdata();

                        if (count($choice_post_ids) >= 3) {
                            break;
                        }
                    }
                }
            }

            $remaining_posts = 3 - count($choice_post_ids);

            if ($remaining_posts > 0) {
                $choice_query = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => $remaining_posts,
                    'post_status'    => 'publish',
                    'post__not_in'   => $post_ids,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'name',
                            'terms'    => 'Choice words',
                        ),
                    ),
                ));

                if ($choice_query->have_posts()) :
                    while ($choice_query->have_posts()) : $choice_query->the_post();
                        $post_ids[] = get_the_ID();
                        $choice_post_ids[] = get_the_ID();
                        require('template-parts/standard-article-card.php');
                    endwhile;
                endif;
                wp_reset_postdata();
            }
            ?>

            <div class="col-lg-3 col-md-6 col-12 mb-4 video-choice">
                <p class="heading-term">More choice words videos</p>
                <?php
                $acf_choice_videos = get_field('choice_words_videos', 'option') ?? [];
                $choice_video_ids = [];

                if (!empty($acf_choice_videos)) {
                    foreach ($acf_choice_videos as $acf_video) {
                        if (is_a($acf_video, 'WP_Post')) {
                            global $post;
                            $post = $acf_video;
                            setup_postdata($post);

                            $video_ids[] = $post->ID;
                            $choice_video_ids[] = $post->ID;

                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <p class="title"><span>Watch: </span><?php the_title(); ?></p>
                            </a>
                            <?php
                            wp_reset_postdata();

                            if (count($choice_video_ids) >= 3) {
                                break;
                            }
                        }
                    }
                }


                $remaining_videos = 3 - count($choice_video_ids);

                if ($remaining_videos > 0) {
                    $choice_videos_query = new WP_Query(array(
                        'post_type'      => 'video',
                        'posts_per_page' => $remaining_videos,
                        'post_status'    => 'publish',
                        'post__not_in'   => $video_ids,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'name',
                                'terms'    => 'Choice words',
                            ),
                        ),
                    ));

                    if ($choice_videos_query->have_posts()) :
                        while ($choice_videos_query->have_posts()) : $choice_videos_query->the_post();
                            $video_ids[] = get_the_ID();
                            $choice_video_ids[] = get_the_ID();
                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <p class="title"><span>Watch: </span><?php the_title(); ?></p>
                            </a>
                        <?php
                        endwhile;
                    endif;
                    wp_reset_postdata();
                }
                ?>
                <div class="sponsor">
                    <span>Sponsored by:</span>
                    <img src="<?php the_field('sponsor_logo_dark', 'option'); ?>" alt="sponsor-logo">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="event-podcast">
    <div class="container px-4">
        <div class="row">
            <div class="col-lg-9">
                <h3 class="col-lg-8 event-heading">Events</h3>
                <div class="row">
                    <div class="col-lg-8 events">
                        <?php
                        $acf_events_posts = get_field('events_posts', 'option') ?? [];
                        $event_ids = [];
                        $main_event_shown = false;

                        if (!empty($acf_events_posts)) {
                            foreach ($acf_events_posts as $acf_event) {
                                if (is_a($acf_event, 'WP_Post')) {
                                    global $post;
                                    $post = $acf_event;
                                    setup_postdata($post);

                                    $event_ids[] = $post->ID;

                                    if (!$main_event_shown) {
                                        echo '<div class="mb-4 main-event-card">';
                                        require('template-parts/main-event-card-no-col.php');
                                        echo '</div>';
                                        $main_event_shown = true;
                                    }

                                    wp_reset_postdata();

                                    if ($main_event_shown) {
                                        break;
                                    }
                                }
                            }
                        }

                        if (!$main_event_shown) {
                            $main_event_query = new WP_Query(array(
                                'post_type'      => 'event',
                                'posts_per_page' => 1,
                                'post_status'    => 'publish',
                                'post__not_in'   => $event_ids,
                                'meta_key'       => 'date',
                                'orderby'        => 'meta_value',
                                'order'          => 'ASC',
                                'meta_type'      => 'DATE',
                            ));

                            if ($main_event_query->have_posts()) :
                                while ($main_event_query->have_posts()) : $main_event_query->the_post();
                                    $event_ids[] = get_the_ID();
                                    echo '<div class="mb-4 main-event-card">';
                                    require('template-parts/main-event-card-no-col.php');
                                    echo '</div>';
                                endwhile;
                            endif;
                            wp_reset_postdata();
                        }
                        ?>
                    </div>

                    <div class="col-lg-4 events">
                        <?php
                        $small_event_count = 0;

                        if (!empty($acf_events_posts)) {
                            foreach ($acf_events_posts as $acf_event) {
                                if (is_a($acf_event, 'WP_Post') && !in_array($acf_event->ID, $event_ids)) {
                                    global $post;
                                    $post = $acf_event;
                                    setup_postdata($post);

                                    $event_ids[] = $post->ID;

                                    echo '<div class="mb-4 small-event-card">';
                                    require('template-parts/small-event-card-no-col.php');
                                    echo '</div>';

                                    $small_event_count++;
                                    wp_reset_postdata();

                                    if ($small_event_count >= 3) {
                                        break;
                                    }
                                }
                            }
                        }

                        if ($small_event_count < 3) {
                            $remaining_small_events = 3 - $small_event_count;

                            $small_event_query = new WP_Query(array(
                                'post_type'      => 'event',
                                'posts_per_page' => $remaining_small_events,
                                'post_status'    => 'publish',
                                'post__not_in'   => $event_ids,
                                'meta_key'       => 'date',
                                'orderby'        => 'meta_value',
                                'order'          => 'ASC',
                                'meta_type'      => 'DATE',
                            ));

                            if ($small_event_query->have_posts()) :
                                while ($small_event_query->have_posts()) : $small_event_query->the_post();
                                    $event_ids[] = get_the_ID();
                                    echo '<div class="mb-4 small-event-card">';
                                    require('template-parts/small-event-card-no-col.php');
                                    echo '</div>';
                                endwhile;
                            endif;
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 podcasts">
                <h3>Podcasts</h3>
	            <div class="row content">
                    <?php
                    $acf_podcast_posts = get_field('podcast_posts', 'option') ?? [];
                    $podcast_ids = [];

                    if (!empty($acf_podcast_posts)) {
                        foreach ($acf_podcast_posts as $acf_podcast) {
                            if (is_a($acf_podcast, 'WP_Post')) {
                                global $post;
                                $post = $acf_podcast;
                                setup_postdata($post);

                                $video_ids[] = $post->ID;
                                $podcast_ids[] = $post->ID;

                                echo '<div class="mb-4 small-podcast-card">';
                                require('template-parts/small-podcast-card-no-col.php');
                                echo '</div>';

                                wp_reset_postdata();

                                if (count($podcast_ids) >= 2) {
                                    break;
                                }
                            }
                        }
                    }

                    $remaining_podcasts = 2 - count($podcast_ids);

                    if ($remaining_podcasts > 0) {
                        $fallback_podcast_query = new WP_Query(array(
                            'post_type'      => 'video',
                            'posts_per_page' => $remaining_podcasts,
                            'post_status'    => 'publish',
                            'post__not_in'   => $video_ids,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'type',
                                    'field'    => 'name',
                                    'terms'    => 'Podcast',
                                ),
                            ),
                        ));

                        if ($fallback_podcast_query->have_posts()) :
                            while ($fallback_podcast_query->have_posts()) : $fallback_podcast_query->the_post();
                                $video_ids[] = get_the_ID();
                                $podcast_ids[] = get_the_ID();

                                echo '<div class="mb-4 small-podcast-card">';
                                require('template-parts/small-podcast-card-no-col.php');
                                echo '</div>';
                            endwhile;
                        endif;
                        wp_reset_postdata();
                    }
                    ?>
                    <div class="word-to-wise">
                        <?php
                        $acf_word_post = get_field('word_to_wise_post', 'option');
                        $word_post_displayed = false;

                        if ($acf_word_post && is_a($acf_word_post, 'WP_Post')) {
                            global $post;
                            $post = $acf_word_post;
                            setup_postdata($post);

                            $post_ids[] = $post->ID;

                            ?>
                            <a href="<?php the_permalink(); ?>">
                                <p class="term">Word to the wise</p>
                                <p class="title"><?php the_title(); ?></p>
                                <p class="click-here">Click here</p>
                                <div class="two-owls"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/two-owls.svg' ); ?></div>
                            </a>
                            <?php
                            wp_reset_postdata();
                            $word_post_displayed = true;
                        }

                        if (!$word_post_displayed) {
                            $videos_query = new WP_Query(array(
                                'post_type'      => 'post',
                                'posts_per_page' => 1,
                                'post_status'    => 'publish',
                                'post__not_in'   => $post_ids,
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'category',
                                        'field'    => 'slug',
                                        'terms'    => 'word-to-the-wise',
                                    ),
                                ),
                            ));

                            if ($videos_query->have_posts()) :
                                while ($videos_query->have_posts()) : $videos_query->the_post();
                                    $post_ids[] = get_the_ID();
                                    ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <p class="term">Word to the wise</p>
                                        <p class="title"><?php the_title(); ?></p>
                                        <p class="click-here">Click here</p>
                                        <div class="two-owls"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/two-owls.svg' ); ?></div>
                                    </a>
                                <?php
                                endwhile;
                            endif;
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>