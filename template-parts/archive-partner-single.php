<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$video_ids = [];
get_header();
?>

<section class="main">
    <div class="heading">
        <div class="container px-4">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="image-wrapper">
                        <?php
                        $logo_id = get_term_meta($term->term_id, 'logo', true);
                        if ($logo_id) {
                            $image_srcset = wp_get_attachment_image_srcset($logo_id);
                            $image_url = wp_get_attachment_url($logo_id);
                            ?>
                            <img src="<?php echo esc_url($image_url); ?>"
                                 alt="<?php echo esc_attr($term->name); ?>"
                                 srcset="<?php echo esc_attr($image_srcset); ?>"
                                 sizes="(min-width: 391px) 1024px, 100vw">
                            <?php
                        }
                        ?>
                    </div>
                    <p><?php echo $term->description ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-4">
        <div class="row">
            <h3 class="sub-heading"><?php echo $term->name ?> articles / content</h3>
            <div class="row bottom-row">
                <?php
                $query = new WP_Query(array(
                    'post_type' => 'partner_content',
                    'posts_per_page' => 16,
                    'post_status'    => 'publish',
                    'paged' => $paged,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'partner',
                            'field' => 'name',
                            'terms' => $term->name,
                        ),
                    ),
                ));

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $terms     = get_the_terms(get_the_ID(), 'partner');
                        $term_name = $terms[0]->name;

                        echo '<div class="col-lg-3 mb-4 standard-article-card">';
                        require get_template_directory() . '/template-parts/partner-article-card-no-col.php';
                        echo '</div>';
                    endwhile;
                endif;
                ?>
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
        </div>
    </div>
</section>

<?php
get_footer();
?>