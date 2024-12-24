<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$video_ids = [];
$partner_post_ids = [];
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
	                <?php require get_template_directory() . '/template-parts/partner-zone-sidebar.php'; ?>
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
                <?php if ($query->max_num_pages > 1): ?>
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
                        echo '<span class="pagination-text">Page ' . esc_html($current_page) . ' <span>of</span> ' . esc_html($total_pages) . '</span>';

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
                <?php endif; ?>
            </div>
        </div>
    </section>

	<?php require get_template_directory() . '/template-parts/section-partner-zone.php'; ?>

	<?php require get_template_directory() . '/template-parts/section-events.php'; ?>

	<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>
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
                <?php if ($query->max_num_pages > 1): ?>
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
                <?php endif; ?>
            </div>
        </div>
    </section>

	<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>
<?php } ?>

<?php
get_footer();
?>