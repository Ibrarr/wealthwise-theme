<?php
$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$post_ids = [];
$partner_post_ids = [];

// Define consistent post counts
$main_section_count = 5; // Posts in main section (including pinned post if present)
$bottom_row_count = 4; // Posts in bottom row
$first_page_count = 9; // Total posts on first page (5+4)
$posts_per_page = 12; // Posts per page for page 2+

// Count total posts for accurate pagination
$count_query = new WP_Query(array(
	'post_type'      => 'post',
	'category_name'  => $term->slug,
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'fields'         => 'ids', // Only get post IDs for efficiency
));
$total_posts = $count_query->post_count;

// Fix pagination calculation - adjust for first page showing 9 posts
if ($total_posts <= $first_page_count) {
	$total_pages = 1;
} else {
	$remaining_posts = $total_posts - $first_page_count;
	$total_pages = 1 + ceil($remaining_posts / $posts_per_page);
}

get_header();
?>

<?php if ($paged === 1) { ?>
    <!-- First page layout -->
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
							$post_ids[] = $pinned_post_id;
						}

						// Adjust the main section count if we have a pinned post
						$adjusted_main_section_count = $main_section_count;
						if ($pinned_post_id) {
							$adjusted_main_section_count = $main_section_count - 1;
						}

						$query = new WP_Query(array(
							'post_type'      => 'post',
							'category_name'  => $term->slug,
							'posts_per_page' => $adjusted_main_section_count,
							'post_status'    => 'publish',
							'post__not_in'   => $post_ids,
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
								$post_ids[] = get_the_ID();
								$terms     = get_the_terms(get_the_ID(), 'category');
								$term_name = $terms[0]->name;

								// Skip the first post if we already displayed a pinned post
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
							// Calculate how many more posts we need to reach the first_page_count
							$remaining_posts_needed = $first_page_count - count($post_ids);

							$query = new WP_Query(array(
								'post_type'      => 'post',
								'category_name'  => $term->slug,
								'posts_per_page' => $remaining_posts_needed,
								'post_status'    => 'publish',
								'post__not_in'   => $post_ids,
							));

							if ($query->have_posts()) :
								while ($query->have_posts()) : $query->the_post();
									$post_ids[] = get_the_ID();
									$terms = get_the_terms(get_the_ID(), 'category');
									$term_name = $terms[0]->name;

									echo '<div class="col-lg-3 mb-4 standard-article-card">';
									require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
									echo '</div>';
								endwhile;
							endif;
							wp_reset_postdata();
							?>
                        </div>
                    </div>
                    <div class="col-12">
                        <nav class="pagination">
							<?php
							$current_page = max(1, get_query_var('paged'));

							if ($current_page > 1) {
								echo '<a href="' . get_pagenum_link($current_page - 1) . '" class="pagination-arrow">'
								     . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</a>';
							} else {
								echo '<span class="pagination-arrow disabled">'
								     . file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/arrow-left.svg') . '</span>';
							}

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

	<?php require get_template_directory() . '/template-parts/section-partner-zone.php'; ?>

	<?php require get_template_directory() . '/template-parts/section-events.php'; ?>

	<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>
<?php } else { ?>
    <!-- Page 2+ layout -->
    <section class="main rest-of-pages">
        <div class="container px-4">
            <h1><span><?php echo $term->name ?></span></h1>
            <div class="row posts">
				<?php
				// Get IDs of all posts to skip (those shown on page 1)
				$first_page_ids_query = new WP_Query(array(
					'post_type'      => 'post',
					'category_name'  => $term->slug,
					'posts_per_page' => $first_page_count,
					'post_status'    => 'publish',
					'fields'         => 'ids',
				));
				$skip_ids = $first_page_ids_query->posts;

				// Now get posts for page 2+, excluding those on page 1
				$query = new WP_Query(array(
					'post_type'      => 'post',
					'category_name'  => $term->slug,
					'posts_per_page' => $posts_per_page,
					'post_status'    => 'publish',
					'post__not_in'   => $skip_ids,
				));

				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
						$terms = get_the_terms(get_the_ID(), 'category');
						$term_name = $terms[0]->name;
						echo '<div class="col-lg-3 mb-4 standard-article-card">';
						require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
						echo '</div>';
					endwhile;
				endif;
				wp_reset_postdata();
				?>
                <div class="col-12">
                    <nav class="pagination">
						<?php
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