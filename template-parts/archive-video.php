<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$video_ids = []; // Track all displayed video IDs
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

						// Display 2 featured posts (pinned or fallback)
						if (!empty($acf_videos)) {
							foreach ($acf_videos as $acf_video) {
								if (is_a($acf_video, 'WP_Post') && !in_array($acf_video->ID, $video_ids)) {
									global $post;
									$post = $acf_video;
									setup_postdata($post);

									$post_count++;
									$video_ids[] = $acf_video->ID; // Add to displayed list

									echo '<div class="col-lg-6 mb-4 standard-article-card featured">';
									$terms     = get_the_terms(get_the_ID(), 'type');
									$term_name = $terms[0]->name ?? '';

                                    $cat_terms = get_the_terms(get_the_ID(), 'category');
                                    $is_choice_words = false; // Initialize the variable as false

                                    if ($cat_terms && !is_wp_error($cat_terms)) {
                                        foreach ($cat_terms as $cat_term) {
                                            if ($cat_term->name === 'Choice words') {
                                                $is_choice_words = true;
                                                break;
                                            }
                                        }
                                    }

									require get_template_directory() . '/template-parts/standard-video-card-no-col.php';
									echo '</div>';

									if ($post_count >= 2) {
										break;
									}
									wp_reset_postdata();
								}
							}
						}

						// Fill remaining slots for featured posts
						$remaining_slots = 2 - $post_count;
						if ($remaining_slots > 0) {
							$featured_query = new WP_Query(array(
								'post_type'      => 'video',
								'posts_per_page' => $remaining_slots,
								'post_status'    => 'publish',
								'post__not_in'   => $video_ids, // Exclude already shown
							));

							if ($featured_query->have_posts()) {
								while ($featured_query->have_posts()) {
									$featured_query->the_post();
									$post_count++;
									$video_ids[] = get_the_ID(); // Track displayed post

									echo '<div class="col-lg-6 mb-4 standard-article-card featured">';
									$terms     = get_the_terms(get_the_ID(), 'type');
									$term_name = $terms[0]->name ?? '';

                                    $cat_terms = get_the_terms(get_the_ID(), 'category');
                                    $is_choice_words = false; // Initialize the variable as false

                                    if ($cat_terms && !is_wp_error($cat_terms)) {
                                        foreach ($cat_terms as $cat_term) {
                                            if ($cat_term->name === 'Choice words') {
                                                $is_choice_words = true;
                                                break;
                                            }
                                        }
                                    }
									require get_template_directory() . '/template-parts/standard-video-card-no-col.php';
									echo '</div>';
								}
								wp_reset_postdata();
							}
						}

						// Display 3 posts in the second row
						$second_row_query = new WP_Query(array(
							'post_type'      => 'video',
							'posts_per_page' => 3,
							'post_status'    => 'publish',
							'post__not_in'   => $video_ids,
						));

						if ($second_row_query->have_posts()) {
							while ($second_row_query->have_posts()) {
								$second_row_query->the_post();
								$video_ids[] = get_the_ID(); // Track displayed post

								echo '<div class="col-lg-4 mb-4 standard-article-card second-row">';
								$terms     = get_the_terms(get_the_ID(), 'type');
								$term_name = $terms[0]->name ?? '';

                                $cat_terms = get_the_terms(get_the_ID(), 'category');
                                $is_choice_words = false; // Initialize the variable as false

                                if ($cat_terms && !is_wp_error($cat_terms)) {
                                    foreach ($cat_terms as $cat_term) {
                                        if ($cat_term->name === 'Choice words') {
                                            $is_choice_words = true;
                                            break;
                                        }
                                    }
                                }
								require get_template_directory() . '/template-parts/standard-video-card-no-col.php';
								echo '</div>';
							}
							wp_reset_postdata();
						}
						?>
                    </div>
                </div>

                <div class="col-lg-3 partner-zone-side">
					<?php require get_template_directory() . '/template-parts/partner-zone-sidebar.php'; ?>
                </div>
                <div class="col-12">
                    <div class="row bottom-row">
						<?php
						// Display 4 posts in the bottom row
						$bottom_row_query = new WP_Query(array(
							'post_type'      => 'video',
							'posts_per_page' => 4,
							'post_status'    => 'publish',
							'post__not_in'   => $video_ids,
						));

						if ($bottom_row_query->have_posts()) {
							while ($bottom_row_query->have_posts()) {
								$bottom_row_query->the_post();
								$video_ids[] = get_the_ID(); // Track displayed post

								echo '<div class="col-lg-3 mb-4 standard-article-card">';
								$terms     = get_the_terms(get_the_ID(), 'type');
								$term_name = $terms[0]->name ?? '';

                                $cat_terms = get_the_terms(get_the_ID(), 'category');
                                $is_choice_words = false; // Initialize the variable as false

                                if ($cat_terms && !is_wp_error($cat_terms)) {
                                    foreach ($cat_terms as $cat_term) {
                                        if ($cat_term->name === 'Choice words') {
                                            $is_choice_words = true;
                                            break;
                                        }
                                    }
                                }
								require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
								echo '</div>';
							}
							wp_reset_postdata();
						}
						?>
                    </div>
                </div>
				<?php
                $total_videos = wp_count_posts('video')->publish;

				// Count the posts already shown on page 1 (featured, second row, and bottom row)
				// (Assuming $video_ids holds the IDs of all posts displayed above – normally 2 + 3 + 4 = 9)
				$displayed_posts = count($video_ids);

				// Set how many posts will be shown on subsequent pages (in your "else" block, you use 12)
				$posts_per_page = 12;

				// Calculate how many additional pages are needed for the remaining posts
				if ($total_videos > $displayed_posts) {
					$remaining_posts = $total_videos - $displayed_posts;
					$additional_pages = ceil($remaining_posts / $posts_per_page);
				} else {
					$additional_pages = 0;
				}

				// Total pages = first page + additional pages
				$total_pages = 1 + $additional_pages;

				// Get the current page (should be 1 on the first page)
				$current_page = max(1, get_query_var('paged'));

				if ($total_pages > 1): ?>
                    <div class="col-12">
                        <nav class="pagination">
							<?php
							// Previous page arrow (disabled on first page)
							if ($current_page > 1) {
								echo '<a href="' . get_pagenum_link($current_page - 1) . '" class="pagination-arrow">'
								     . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</a>';
							} else {
								echo '<span class="pagination-arrow disabled">'
								     . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</span>';
							}

							echo '<span class="pagination-text">Page ' . esc_html($current_page) . ' <span>of</span> ' . esc_html($total_pages) . '</span>';

							// Next page arrow (only active if there are additional pages)
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
				// Standard pagination for subsequent pages
				$query = new WP_Query(array(
					'post_type'      => 'video',
					'posts_per_page' => 12,
					'post_status'    => 'publish',
					'paged'          => $paged,
				));

				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						echo '<div class="col-lg-3 mb-4 standard-article-card">';
						$terms     = get_the_terms(get_the_ID(), 'type');
						$term_name = $terms[0]->name ?? '';

                        $cat_terms = get_the_terms(get_the_ID(), 'category');
                        $is_choice_words = false; // Initialize the variable as false

                        if ($cat_terms && !is_wp_error($cat_terms)) {
                            foreach ($cat_terms as $cat_term) {
                                if ($cat_term->name === 'Choice words') {
                                    $is_choice_words = true;
                                    break;
                                }
                            }
                        }
						require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
						echo '</div>';
					}
				} else {
					echo '<div class="col-12"><p>No more posts to show.</p></div>';
				}

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

<?php get_footer(); ?>
