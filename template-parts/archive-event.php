<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
get_header();
?>

<?php if ($paged === 1) { ?>
    <section class="main">
        <div class="container px-4">
            <h1><span>Events</span></h1>
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <?php
                        $query = new WP_Query(array(
                            'post_type' => 'event',
                            'posts_per_page' => 6,
                            'post_status'    => 'publish',
                            'paged' => $paged,
                        ));

                        if ($query->have_posts()) :
                        $post_count = 0;
                        while ($query->have_posts()) : $query->the_post();
                            $post_count++;
                            echo '<div class="col-lg-6 main-event-card">';
                                require get_template_directory() . '/template-parts/main-event-card-no-col.php';
                            echo '</div>';
                        endwhile;
                        ?>
                    </div>
                    <?php
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

    <section class="recommended">
        <div class="container px-4">
            <div class="row">
                <h3>Recommended</h3>
                <?php
                $analysis_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                ));

                if ($analysis_query->have_posts()) :
                    while ($analysis_query->have_posts()) : $analysis_query->the_post();
                        $post_ids[] = get_the_ID();
                        $terms     = get_the_terms(get_the_ID(), 'category');
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
<?php } else { ?>
    <section class="main rest-of-pages">
        <div class="container px-4">
            <h1><span>Events</span></h1>
            <div class="row posts">
                <?php
                $query = new WP_Query(array(
                    'post_type' => 'event',
                    'posts_per_page' => 12,
                    'post_status'    => 'publish',
                    'paged' => $paged,
                ));

                if ($query->have_posts()) :
                    $post_count = 0;
                    while ($query->have_posts()) : $query->the_post();
                        $post_count++;
                        echo '<div class="col-lg-4 main-event-card">';
                        require get_template_directory() . '/template-parts/main-event-card-no-col.php';
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
                $analysis_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                ));

                if ($analysis_query->have_posts()) :
                    while ($analysis_query->have_posts()) : $analysis_query->the_post();
                        $post_ids[] = get_the_ID();
                        $terms     = get_the_terms(get_the_ID(), 'category');
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
<?php } ?>

<?php
get_footer();
?>