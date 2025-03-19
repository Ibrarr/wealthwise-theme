<?php
/*
Template Name: Analysis & Opinion Archive
*/
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Set consistent values for the structure
$first_page_posts = 8; // Total posts on first page (1 featured + 3 not-main + 4 bottom)
$posts_per_page = 12; // Posts per page for page 2+ (consistent for pagination)
$post_ids = [];
$partner_post_ids = [];

// Count total posts for accurate pagination
$count_query = new WP_Query(array(
	'post_type'      => 'post',
	'category_name'  => 'analysis,opinion',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'fields'         => 'ids', // Only get post IDs for efficiency
));
$total_posts = $count_query->post_count;
$total_pages = ceil(($total_posts - $first_page_posts + $posts_per_page) / $posts_per_page);

get_header();
?>

<?php if ($paged === 1) { ?>
    <section class="main">
        <div class="container px-4">
            <h1><span>Analysis & Opinion</span></h1>
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
						<?php
						$pinned_post = get_field('pinned_post');
						$pinned_post_id = null;

						if ($pinned_post && is_array($pinned_post)) {
							$pinned_post = reset($pinned_post);
						}

						if ($pinned_post && is_a($pinned_post, 'WP_Post')) {
							$pinned_post_id = $pinned_post->ID;
							$post_ids[] = $pinned_post_id; // Track pinned post

							global $post;
							$post = $pinned_post;

							setup_postdata($post);
							$terms     = get_the_terms(get_the_ID(), 'category');
							$term_name = $terms[0]->name;
							echo '<div class="col-lg-12 mb-4 featured-article-card">';
							require get_template_directory() . '/template-parts/featured-article-card-block.php';
							echo '</div>';
							echo '<div class="row gx-1 not-main">';
							wp_reset_postdata();
						}

						// Get posts for the first page display (featured + not-main row)
						// If there's a pinned post, we need to get 3 more posts for the not-main row
						// If no pinned post, we need to get 4 posts (1 featured + 3 for not-main)
						$first_section_count = $pinned_post_id ? 3 : 4;

						$query = new WP_Query(array(
							'post_type'      => 'post',
							'category_name'  => 'analysis,opinion',
							'posts_per_page' => $first_section_count,
							'post_status'    => 'publish',
							'post__not_in'   => $post_ids, // Exclude pinned post
						));

						if ($query->have_posts()) :
						$post_count = $pinned_post_id ? 0 : 0; // Start at 0 in both cases

						while ($query->have_posts()) : $query->the_post();
							$post_count++;
							$post_ids[] = get_the_ID(); // Track displayed posts
							$terms     = get_the_terms(get_the_ID(), 'category');
							$term_name = $terms[0]->name;

							if ($post_count === 1 && !$pinned_post_id) {
								echo '<div class="col-lg-12 mb-4 featured-article-card">';
								require get_template_directory() . '/template-parts/featured-article-card-block.php';
								echo '</div>';
								echo '<div class="row gx-1 not-main">';
							} elseif (($post_count === 2 && !$pinned_post_id) || ($post_count === 1 && $pinned_post_id)) {
								echo '<div class="col-lg-4 mb-4 standard-article-card second">';
								require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
								echo '</div>';
							} elseif (($post_count === 3 && !$pinned_post_id) || ($post_count === 2 && $pinned_post_id)) {
								echo '<div class="col-lg-8 mb-4 other">';
								echo '<div class="standard-article-card">';
								require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
								echo '</div>';
							} elseif (($post_count === 4 && !$pinned_post_id) || ($post_count === 3 && $pinned_post_id)) {
								echo '<div class="standard-article-card">';
								require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
								echo '</div>';
								echo '</div>';
								echo '</div>';
							}
						endwhile;

						// Close the not-main row if it wasn't closed
						if (($post_count < 4 && !$pinned_post_id) || ($post_count < 3 && $pinned_post_id)) {
							if ($post_count >= 1) { // Only close divs if we've started them
								if (($post_count >= 3 && !$pinned_post_id) || ($post_count >= 2 && $pinned_post_id)) {
									echo '</div>'; // Close the "other" div if needed
								}
								echo '</div>'; // Close the not-main row
							}
						}
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
                <div class="col-12">
                    <div class="row bottom-row">
						<?php
						// Always show exactly 4 posts in the bottom row
						$bottom_row_count = 4;

						$query = new WP_Query(array(
							'post_type'      => 'post',
							'category_name'  => 'analysis,opinion',
							'posts_per_page' => $bottom_row_count,
							'post_status'    => 'publish',
							'post__not_in'   => $post_ids, // Exclude already displayed posts
						));

						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								$post_ids[] = get_the_ID(); // Track displayed posts
								$terms     = get_the_terms(get_the_ID(), 'category');
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

	<?php require get_template_directory() . '/template-parts/section-choice-words.php'; ?>

	<?php require get_template_directory() . '/template-parts/section-videos.php'; ?>

	<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>
<?php } else { ?>
    <section class="main rest-of-pages">
        <div class="container px-4">
            <h1><span>Analysis & Opinion</span></h1>
            <div class="row posts">
				<?php
				// Calculate the correct offset to ensure no posts are skipped
				// First page shows 8 posts in total (1 featured + 3 not-main + 4 bottom)
				$offset = $first_page_posts + ($paged - 2) * $posts_per_page;

				$query = new WP_Query(array(
					'post_type'      => 'post',
					'category_name'  => 'analysis,opinion',
					'posts_per_page' => $posts_per_page,
					'post_status'    => 'publish',
					'offset'         => $offset,
				));

				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post();
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