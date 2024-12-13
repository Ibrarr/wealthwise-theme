<?php
get_header();

$post_ids = [];
?>

<section class="hero">
    <div class="container px-4">
        <div class="row">
            <div class="col-lg-3 left">
                <?php
                $left_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 2,
                    'post_status'    => 'publish',
                ));

                if ($left_query->have_posts()) :
                    while ($left_query->have_posts()) : $left_query->the_post();
                        $post_ids[] = get_the_ID();
                        $terms     = get_the_terms(get_the_ID(), 'category');
                        $term_name = $terms[0]->name;
                        ?>
                        <?php require('template-parts/archive-standard-article-card.php'); ?>
                    <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <div class="col-lg-6 middle">
                <?php
                $middle_query = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 2,
                    'post_status'    => 'publish',
                    'post__not_in'   => $post_ids,
                ));

                if ($middle_query->have_posts()) :
                    while ($middle_query->have_posts()) : $middle_query->the_post();
                        $post_ids[] = get_the_ID();
                        $terms     = get_the_terms(get_the_ID(), 'category');
                        $term_name = $terms[0]->name;
                        ?>
                        <?php require('template-parts/archive-standard-article-card.php'); ?>
                    <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <div class="col-lg-3 right">
                <p class="zone-header">Partner zone</p>
                <?php
                $middle_query = new WP_Query(array(
                    'post_type' => 'partner_content',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'post__not_in'   => $post_ids,
                ));

                if ($middle_query->have_posts()) :
                    while ($middle_query->have_posts()) : $middle_query->the_post();
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

                <div class="search">
                    <br>
                    <div class="search-box">
                        <span>Search</span>
                        <div class="icon"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/search.svg' ) ?></div>
                    </div>
                    <div class="sponsor">
                        <span>Sponsored by:</span>
                        <img src="<?php the_field( 'sponsor_logo', 'option' ); ?>" alt="sponsor-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
get_footer();
?>