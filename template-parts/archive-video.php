<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$video_ids = []; // Track all displayed video IDs
$partner_post_ids = [];
get_header();
?>

<?php if ($paged === 1) { ?>
    <section class="main">
        <div class="container px-4">
            <h1><span>Podcasts & Videos</span></h1>
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
						<?php
						$acf_videos = get_field('video_posts_archive', 'option') ?? [];
						$post_count = 0;

						if (!empty($acf_videos)) {
							foreach ($acf_videos as $acf_video) {
								if (is_a($acf_video, 'WP_Post') && !in_array($acf_video->ID, $video_ids)) {
									global $post;
									$post = $acf_video;
									setup_postdata($post);

									$post_count++;
									$video_ids[] = $acf_video->ID; // Add ID to tracked list
									$terms     = get_the_terms(get_the_ID(), 'type');
									$term_name = $terms[0]->name ?? '';

									echo '<div class="col-lg-6 mb-4 standard-article-card featured">';
									require get_template_directory() . '/template-parts/standard-video-card-no-col.php';
									echo '</div>';

									if ($post_count >= 2) {
										break;
									}
									wp_reset_postdata();
								}
							}
						}

						$remaining_slots = 2 - $post_count;
						$query = new WP_Query(array(
							'post_type'      => 'video',
							'posts_per_page' => 9,
							'post_status'    => 'publish',
							'paged'          => $paged,
							'post__not_in'   => $video_ids, // Exclude already shown videos
						));

						if ($remaining_slots > 0 && $query->have_posts()) {
							while ($query->have_posts() && $remaining_slots > 0) {
								$query->the_post();
								$post_count++;
								$remaining_slots--;
								$video_ids[] = get_the_ID(); // Add ID to tracked list
								$terms     = get_the_terms(get_the_ID(), 'type');
								$term_name = $terms[0]->name ?? '';

								echo '<div class="col-lg-6 mb-4 standard-article-card featured">';
								require get_template_directory() . '/template-parts/standard-video-card-no-col.php';
								echo '</div>';
							}
						}

						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								if (in_array(get_the_ID(), $video_ids)) continue; // Skip duplicates
								$post_count++;
								$video_ids[] = get_the_ID(); // Add ID to tracked list

								$terms     = get_the_terms(get_the_ID(), 'type');
								$term_name = $terms[0]->name ?? '';

								if ($post_count === 3 || $post_count === 4 || $post_count === 5) {
									echo '<div class="col-lg-4 mb-4 standard-article-card second-row">';
									require get_template_directory() . '/template-parts/standard-video-card-no-col.php';
									echo '</div>';
								}
							endwhile;
						endif;

						wp_reset_postdata();
						?>
                    </div>
                </div>

                <div class="col-lg-3 partner-zone-side">
					<?php require get_template_directory() . '/template-parts/partner-zone-sidebar.php'; ?>
                </div>
                <div class="col-12">
                    <div class="row bottom-row">
						<?php
						$remaining_count = 0;

						$query = new WP_Query(array(
							'post_type'      => 'video',
							'posts_per_page' => 4,
							'post_status'    => 'publish',
							'paged'          => $paged,
							'post__not_in'   => $video_ids, // Exclude already shown videos
						));

						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								if (in_array(get_the_ID(), $video_ids)) continue; // Skip duplicates
								$video_ids[] = get_the_ID(); // Add ID to tracked list

								$terms     = get_the_terms(get_the_ID(), 'type');
								$term_name = $terms[0]->name;
								$post_count++;

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
            <h1><span>Podcasts & Videos</span></h1>
            <div class="row posts">
                <?php
                $query = new WP_Query(array(
                    'post_type' => 'video',
                    'posts_per_page' => 12,
                    'post_status'    => 'publish',
                    'paged' => $paged,
                ));

                if ($query->have_posts()) :
                    $post_count = 0;
                    while ($query->have_posts()) : $query->the_post();
                        $post_count++;
                        $terms     = get_the_terms(get_the_ID(), 'type');
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