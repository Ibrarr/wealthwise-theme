<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$partner_post_ids = [];
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
	                <?php require get_template_directory() . '/template-parts/partner-zone-sidebar.php'; ?>
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

	<?php require get_template_directory() . '/template-parts/section-partner-zone.php'; ?>

	<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>
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

	<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>
<?php } ?>

<?php
get_footer();
?>