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

$partner_post_ids = [];
get_header();
?>

<section class="main">
    <div class="container px-4">
        <h1><span>Partner Zone</span></h1>
        <div class="row">
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

                    foreach ($query as $partner) {
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

<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>

<?php
get_footer();
?>