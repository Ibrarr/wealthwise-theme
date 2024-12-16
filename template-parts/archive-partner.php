<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$query = get_terms(array(
    'taxonomy'   => 'partner',
    'hide_empty' => false,
    'meta_query' => array(
        array(
            'key'     => 'active',
            'value'   => '1',
            'compare' => '=',
        ),
    ),
));

// Split terms into two sections
$first_section = array_slice($query, 0, 6); // First 6 terms
$second_section = array_slice($query, 6);  // Remaining terms

get_header();
?>

<section class="main">
    <div class="container px-4">
        <h1>Partner Zone</h1>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <?php
                    foreach ($first_section as $partner) {
                        ?>
                        <div class="col-lg-4 mb-4 standard-article-card">
                            <a href="<?php echo esc_url(get_term_link($partner)); ?>">
                                <div class="image-wrapper">
                                    <?php
                                    $logo_id = get_term_meta($partner->term_id, 'logo', true);
                                    if ($logo_id) {
                                        $image_srcset = wp_get_attachment_image_srcset($logo_id);
                                        $image_url = wp_get_attachment_url($logo_id);
                                        ?>
                                        <img src="<?php echo esc_url($image_url); ?>"
                                             alt="<?php echo esc_attr($partner->name); ?>"
                                             srcset="<?php echo esc_attr($image_srcset); ?>"
                                             sizes="(min-width: 391px) 1024px, 100vw">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <p class="term"><?php echo esc_html($partner->name); ?></p>
                                <p class="title"><?php echo esc_html(get_term_meta($partner->term_id, 'archive_heading', true)); ?></p>
                                <p class="excerpt"><?php echo esc_html(wp_trim_words(get_term_meta($partner->term_id, 'archive_description', true))); ?></p>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
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
                    $query = get_terms(array(
                        'taxonomy'   => 'partner',
                        'hide_empty' => false,
                        'meta_query' => array(
                            array(
                                'key'     => 'active',
                                'value'   => '1',
                                'compare' => '=',
                            ),
                        ),
                    ));

                    foreach ($second_section as $partner) {
                        ?>
                        <div class="col-lg-3 mb-4 standard-article-card">
                            <a href="<?php echo esc_url(get_term_link($partner)); ?>">
                                <div class="image-wrapper">
                                    <?php
                                    $logo_id = get_term_meta($partner->term_id, 'logo', true);
                                    if ($logo_id) {
                                        $image_srcset = wp_get_attachment_image_srcset($logo_id);
                                        $image_url = wp_get_attachment_url($logo_id);
                                        ?>
                                        <img src="<?php echo esc_url($image_url); ?>"
                                             alt="<?php echo esc_attr($partner->name); ?>"
                                             srcset="<?php echo esc_attr($image_srcset); ?>"
                                             sizes="(min-width: 391px) 1024px, 100vw">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <p class="term"><?php echo esc_html($partner->name); ?></p>
                                <p class="title"><?php echo esc_html(get_term_meta($partner->term_id, 'archive_heading', true)); ?></p>
                                <p class="excerpt"><?php echo esc_html(wp_trim_words(get_term_meta($partner->term_id, 'archive_description', true))); ?></p>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
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

<?php
get_footer();
?>