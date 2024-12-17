<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$video_ids = [];
get_header();
?>

<?php if ($paged === 1) { ?>
    <section class="main">
        <div class="container px-4">
            <h1><span><?php echo $term->name ?></span></h1>
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <?php
                        $pinned_post = get_field('pinned_post', $term);
                        $pinned_post_id = null;

                        if ($pinned_post && is_array($pinned_post)) {
                            $pinned_post = reset($pinned_post);
                        }

                        if ($pinned_post && is_a($pinned_post, 'WP_Post')) {
                            $pinned_post_id = $pinned_post->ID;
                        }

                        $query = new WP_Query(array(
                            'post_type'      => 'post',
                            'category_name'  => $term->slug,
                            'posts_per_page' => 9,
                            'post_status'    => 'publish',
                            'paged'          => $paged,
                            'post__not_in'   => $pinned_post_id ? [$pinned_post_id] : [],
                        ));

                        if ($query->have_posts()) :
                            $post_count = 0;

                            echo '<div class="col-lg-8">';
                            echo '<div class="row">';

                            if ($pinned_post_id) {
                                global $post;
                                $post = $pinned_post;
                                setup_postdata($post);
                                $terms     = get_the_terms(get_the_ID(), 'category');
                                $term_name = $terms[0]->name;
                                echo '<div class="col-lg-12 mb-4 standard-article-card featured">';
                                require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
                                echo '</div>';

                                $post_count++;
                                wp_reset_postdata();
                            }

                            while ($query->have_posts()) : $query->the_post();
                                $post_count++;
                                $terms     = get_the_terms(get_the_ID(), 'category');
                                $term_name = $terms[0]->name;
                                if ($post_count === 1 && $pinned_post_id) {
                                    continue;
                                }

                                if ($post_count === 1 && !$pinned_post_id) {
                                    echo '<div class="col-lg-12 mb-4 standard-article-card featured">';
                                    require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
                                    echo '</div>';
                                } elseif ($post_count === 2 || $post_count === 3) {
                                    echo '<div class="col-lg-6 mb-4 standard-article-card second-third">';
                                    require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
                                    echo '</div>';
                                }

                                if ($post_count === 3) {
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<div class="col-lg-4">';
                                }

                                if ($post_count === 4 || $post_count === 5) {
                                    echo '<div class="mb-4 standard-article-card">';
                                    require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
                                    echo '</div>';
                                }
                            endwhile;

                            echo '</div>';
                            echo '</div>';
                        endif;
                        wp_reset_postdata();
                        ?>
                </div>
                <div class="col-lg-3 partner-zone-side">
                    <p class="zone-header">Partner zone</p>
                    <?php
                    $right_query = new WP_Query(array(
                        'post_type' => 'partner_content',
                        'posts_per_page' => 4,
                        'post_status'    => 'publish',
                    ));

                    if ($right_query->have_posts()) :
                        while ($right_query->have_posts()) : $right_query->the_post();
                            $terms     = get_the_terms(get_the_ID(), 'partner');
                            $term_name = $terms[0]->name;
                            ?>
                            <?php require get_template_directory() . '/template-parts/archive-partner-card-short.php'; ?>
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
                <div class="col-12">
                    <div class="row bottom-row">
                        <?php
                        $remaining_count = 0;

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post();
                                $terms     = get_the_terms(get_the_ID(), 'category');
                                $term_name = $terms[0]->name;
                                $post_count++;
                                if ($post_count <= 4) {
                                    continue;
                                }

                                if ($remaining_count < 4) {
                                    echo '<div class="col-lg-3 mb-4 standard-article-card">';
                                    require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
                                    echo '</div>';
                                    $remaining_count++;
                                } else {
                                    break;
                                }
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>
                <div class="col-12">
                    <nav class="pagination">
                        <?php
                        // Calculate total pages and current page
                        $total_pages = $query->max_num_pages;
                        $current_page = max(1, get_query_var('paged'));

                        // Display left arrow
                        if ($current_page > 1) {
                            echo '<a href="' . get_pagenum_link($current_page - 1) . '" class="pagination-arrow">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</a>';
                        } else {
                            echo '<span class="pagination-arrow disabled">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</span>';
                        }

                        // Page X of Y
                        echo '<span class="pagination-text">Page ' . esc_html($current_page) . ' of ' . esc_html($total_pages) . '</span>';

                        if ($current_page < $total_pages) {
                            echo '<a href="' . get_pagenum_link($current_page + 1) . '" class="pagination-arrow">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-right.svg') . '</a>';
                        } else {
                            echo '<span class="pagination-arrow disabled">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-right.svg') . '</span>';
                        }
                        ?>
                    </nav>
                </div>
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
                        <?php require get_template_directory() . '/template-parts/standard-article-card.php'; ?>
                    <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>

    <section class="events">
        <div class="container px-4">
            <div class="row">
                <h3>Events</h3>
                <?php
                $acf_event_posts = get_field('event_posts_archive', 'option') ?? [];
                $event_archive_ids = [];

                if (!empty($acf_event_posts)) {
                    foreach ($acf_event_posts as $acf_event) {
                        if (is_a($acf_event, 'WP_Post')) {
                            global $post;
                            $post = $acf_event;
                            setup_postdata($post);

                            $post_ids[] = $post->ID;
                            $event_archive_ids[] = $post->ID;

                            echo '<div class="col-lg-4 main-event-card">';
                            require get_template_directory() . '/template-parts/main-event-card-no-col.php';
                            echo '</div>';

                            wp_reset_postdata();

                            if (count($event_archive_ids) >= 3) {
                                break;
                            }
                        }
                    }
                }

                $remaining_events = 3 - count($event_archive_ids);

                if ($remaining_events > 0) {
                    $fallback_event_query = new WP_Query(array(
                        'post_type'      => 'event',
                        'posts_per_page' => $remaining_events,
                        'post_status'    => 'publish',
                        'meta_key'       => 'date',
                        'orderby'        => 'meta_value',
                        'order'          => 'ASC',
                        'meta_type'      => 'DATE',
                    ));

                    if ($fallback_event_query->have_posts()) :
                        while ($fallback_event_query->have_posts()) : $fallback_event_query->the_post();
                            $post_ids[] = get_the_ID();
                            $event_archive_ids[] = get_the_ID();

                            echo '<div class="col-lg-4 main-event-card">';
                            require get_template_directory() . '/template-parts/main-event-card-no-col.php';
                            echo '</div>';
                        endwhile;
                    endif;
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
    </section>

    <section class="recommended">
        <div class="container px-4">
            <div class="row">
                <h3>Recommended</h3>
                <?php
                $acf_recommended_posts = get_field('recommended_posts', 'option') ?? [];
                $recommended_post_ids = [];

                if (!empty($acf_recommended_posts)) {
                    foreach ($acf_recommended_posts as $acf_post) {
                        if (is_a($acf_post, 'WP_Post')) {
                            global $post;
                            $post = $acf_post;
                            setup_postdata($post);

                            $post_ids[] = $post->ID;
                            $recommended_post_ids[] = $post->ID;
                            $terms     = get_the_terms(get_the_ID(), (get_post_type() === 'video') ? 'type' : 'category');
                            $term_name = $terms[0]->name;
                            require get_template_directory() . '/template-parts/standard-article-card.php';
                            wp_reset_postdata();

                            if (count($recommended_post_ids) >= 4) {
                                break;
                            }
                        }
                    }
                }

                $remaining_posts = 4 - count($recommended_post_ids);

                if ($remaining_posts > 0) {
                    $recommended_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => $remaining_posts,
                        'post_status'    => 'publish',
                        'post__not_in'   => $post_ids,
                    ));

                    if ($recommended_query->have_posts()) :
                        while ($recommended_query->have_posts()) : $recommended_query->the_post();
                            $post_ids[] = get_the_ID();
                            $recommended_post_ids[] = get_the_ID();
                            $terms     = get_the_terms(get_the_ID(), (get_post_type() === 'video') ? 'type' : 'category');
                            $term_name = $terms[0]->name;
                            require get_template_directory() . '/template-parts/standard-article-card.php';
                        endwhile;
                    endif;
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
    </section>
<?php } else { ?>
    <section class="main rest-of-pages">
        <div class="container px-4">
            <h1><span><?php echo $term->name ?></span></h1>
            <div class="row posts">
                <?php
                $query = new WP_Query(array(
                    'post_type' => 'post',
                    'category_name' => $term->slug,
                    'posts_per_page' => 12,
                    'post_status'    => 'publish',
                    'paged' => $paged,
                ));

                if ($query->have_posts()) :
                    $post_count = 0;
                    while ($query->have_posts()) : $query->the_post();
                        $post_count++;
                        $terms     = get_the_terms(get_the_ID(), 'category');
                        $term_name = $terms[0]->name;
                        echo '<div class="col-lg-3 mb-4 standard-article-card">';
                        require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
                        echo '</div>';
                    endwhile;
                    ?>
                <?php
                endif;
                wp_reset_postdata();
                ?>
                <div class="col-12">
                    <nav class="pagination">
                        <?php
                        $total_pages = $query->max_num_pages;
                        $current_page = max(1, get_query_var('paged'));

                        if ($current_page > 1) {
                            echo '<a href="' . get_pagenum_link($current_page - 1) . '" class="pagination-arrow">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</a>';
                        } else {
                            echo '<span class="pagination-arrow disabled">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</span>';
                        }

                        echo '<span class="pagination-text">PAGE ' . esc_html($current_page) . ' <span>of</span> ' . esc_html($total_pages) . '</span>';

                        if ($current_page < $total_pages) {
                            echo '<a href="' . get_pagenum_link($current_page + 1) . '" class="pagination-arrow">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-right.svg') . '</a>';
                        } else {
                            echo '<span class="pagination-arrow disabled">'
                                . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-right.svg') . '</span>';
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="recommended">
        <div class="container px-4">
            <div class="row">
                <h3>Recommended</h3>
                <?php
                $acf_recommended_posts = get_field('recommended_posts', 'option') ?? [];
                $recommended_post_ids = [];

                if (!empty($acf_recommended_posts)) {
                    foreach ($acf_recommended_posts as $acf_post) {
                        if (is_a($acf_post, 'WP_Post')) {
                            global $post;
                            $post = $acf_post;
                            setup_postdata($post);

                            $post_ids[] = $post->ID;
                            $recommended_post_ids[] = $post->ID;
                            $terms     = get_the_terms(get_the_ID(), (get_post_type() === 'video') ? 'type' : 'category');
                            $term_name = $terms[0]->name;
                            require get_template_directory() . '/template-parts/standard-article-card.php';
                            wp_reset_postdata();

                            if (count($recommended_post_ids) >= 4) {
                                break;
                            }
                        }
                    }
                }

                $remaining_posts = 4 - count($recommended_post_ids);

                if ($remaining_posts > 0) {
                    $recommended_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => $remaining_posts,
                        'post_status'    => 'publish',
                        'post__not_in'   => $post_ids,
                    ));

                    if ($recommended_query->have_posts()) :
                        while ($recommended_query->have_posts()) : $recommended_query->the_post();
                            $post_ids[] = get_the_ID();
                            $recommended_post_ids[] = get_the_ID();
                            $terms     = get_the_terms(get_the_ID(), (get_post_type() === 'video') ? 'type' : 'category');
                            $term_name = $terms[0]->name;
                            require get_template_directory() . '/template-parts/standard-article-card.php';
                        endwhile;
                    endif;
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php
get_footer();
?>