<?php
get_header();

$post_ids = [];
$video_ids = [];
$event_ids = [];
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

<section class="analysis">
    <div class="container px-4">
        <div class="row">
            <h3>Analysis</h3>
	        <?php
	        $analysis_query = new WP_Query(array(
		        'post_type' => 'post',
		        'posts_per_page' => 4,
		        'post_status'    => 'publish',
		        'post__not_in'   => $post_ids,
		        'tax_query' => array(
			        array(
				        'taxonomy' => 'category',
				        'field' => 'name',
				        'terms' => 'Analysis',
			        ),
		        ),
	        ));

	        if ($analysis_query->have_posts()) :
		        while ($analysis_query->have_posts()) : $analysis_query->the_post();
			        $post_ids[] = get_the_ID();
			        $terms     = get_the_terms(get_the_ID(), 'category');
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
            $videos_query = new WP_Query(array(
                'post_type' => 'video',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ));

            if ($videos_query->have_posts()) :
                while ($videos_query->have_posts()) : $videos_query->the_post();
	                $video_ids[] = get_the_ID();
                    $terms     = get_the_terms(get_the_ID(), 'type');
                    $term_name = $terms[0]->name;
                    echo '<div class="col-lg-4 col-12 mb-4 standard-article-card">';
                    require('template-parts/standard-video-card-no-col.php');
                    echo '</div>';
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<section class="choice-words">
    <div class="container px-4">
        <div class="row">
            <h3>Choice words</h3>
            <?php
            $choice_query = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'post__not_in'   => $post_ids,
                'tax_query' => array(
	                array(
		                'taxonomy' => 'category',
		                'field' => 'name',
		                'terms' => 'Choice words',
	                ),
                ),
            ));

            if ($choice_query->have_posts()) :
                while ($choice_query->have_posts()) : $choice_query->the_post();
                    $post_ids[] = get_the_ID();
                    $terms     = get_the_terms(get_the_ID(), 'category');
                    $term_name = $terms[0]->name;
                    ?>
                    <?php require('template-parts/standard-article-card.php'); ?>
                <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
            <div class="col-lg-3 col-md-6 col-12 mb-4 video-choice">
                <p class="heading-term">More choice words videos</p>
	            <?php
	            $choice_query = new WP_Query(array(
		            'post_type' => 'video',
		            'posts_per_page' => 3,
		            'post_status'    => 'publish',
		            'post__not_in'   => $video_ids,
		            'tax_query' => array(
			            array(
				            'taxonomy' => 'category',
				            'field' => 'name',
				            'terms' => 'Choice words',
			            ),
		            ),
	            ));

	            if ($choice_query->have_posts()) :
		            while ($choice_query->have_posts()) : $choice_query->the_post();
			            $video_ids[] = get_the_ID();
			            ?>
                        <a href="<?php the_permalink(); ?>">
                            <p class="title"><span>Watch: </span><?php the_title(); ?></p>
                        </a>
		            <?php
		            endwhile;
	            endif;
	            wp_reset_postdata();
	            ?>
                <div class="sponsor">
                    <span>Sponsored by:</span>
                    <img src="<?php the_field( 'sponsor_logo', 'option' ); ?>" alt="sponsor-logo">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="event-podcast">
    <div class="container px-4">
        <div class="row">
            <div class="col-lg-6 events">
                <h3>Events</h3>
                <?php
                $event_query = new WP_Query(array(
                    'post_type' => 'event',
                    'posts_per_page' => 1,
                    'post_status'    => 'publish',
                    'post__not_in'   => $event_ids,
                ));

                if ($event_query->have_posts()) :
                    while ($event_query->have_posts()) : $event_query->the_post();
                        $event_ids[] = get_the_ID();
                        echo '<div class="mb-4 main-event-card">';
                        require('template-parts/main-event-card-no-col.php');
                        echo '</div>';
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
            <div class="col-lg-3 events">
<!--                <p class="heading-term">Events</p>-->
	            <?php
	            $event_query = new WP_Query(array(
		            'post_type' => 'event',
		            'posts_per_page' => 3,
		            'post_status'    => 'publish',
		            'post__not_in'   => $event_ids,
	            ));

	            if ($event_query->have_posts()) :
		            while ($event_query->have_posts()) : $event_query->the_post();
			            $event_ids[] = get_the_ID();
			            echo '<div class="mb-4 small-event-card">';
			            require('template-parts/small-event-card-no-col.php');
			            echo '</div>';
		            endwhile;
	            endif;
	            wp_reset_postdata();
	            ?>
            </div>
            <div class="col-lg-3 podcasts">
                <h3>Podcasts</h3>
	            <?php
	            $videos_query = new WP_Query(array(
		            'post_type' => 'video',
		            'posts_per_page' => 2,
		            'post_status'    => 'publish',
		            'post__not_in'   => $video_ids,
		            'tax_query' => array(
			            array(
				            'taxonomy' => 'type',
				            'field' => 'name',
				            'terms' => 'Podcast',
			            ),
		            ),
	            ));

	            if ($videos_query->have_posts()) :
		            while ($videos_query->have_posts()) : $videos_query->the_post();
			            $video_ids[] = get_the_ID();
			            echo '<div class="mb-4 small-podcast-card">';
			            require('template-parts/small-podcast-card-no-col.php');
			            echo '</div>';
		            endwhile;
	            endif;
	            wp_reset_postdata();
	            ?>
                <div class="word-to-wise">
	                <?php
	                $videos_query = new WP_Query(array(
		                'post_type' => 'post',
		                'posts_per_page' => 1,
		                'post_status'    => 'publish',
		                 // 'post__not_in'   => $post_ids,
		                'tax_query' => array(
			                array(
				                'taxonomy' => 'category',
				                'field' => 'slug',
				                'terms' => 'word-to-the-wise',
			                ),
		                ),
	                ));

	                if ($videos_query->have_posts()) :
		                while ($videos_query->have_posts()) : $videos_query->the_post();
			                ?>
                            <a href="<?php the_permalink(); ?>">
                                <p class="term">Word to the wise</p>
                                <p class="title"><?php the_title(); ?></p>
                                <p class="click-here">Click here</p>
                            </a>
                        <?php
		                endwhile;
	                endif;
	                wp_reset_postdata();
	                ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>