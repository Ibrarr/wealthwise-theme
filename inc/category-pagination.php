<?php
/**
 * Fix for category archive pagination with custom posts-per-page setup
 */
function fix_category_pagination($query) {
	// Only run on main category archives on frontend
	if (!is_admin() && $query->is_main_query() && $query->is_category()) {
		$paged = max(1, $query->get('paged'));

		// Our pagination structure constants
		$first_page_count = 9;
		$posts_per_page = 12;

		// Only need to work on page 2+
		if ($paged > 1) {
			// Count posts to check if this is a valid page
			$term = get_queried_object();
			$total_posts = get_posts([
				'category_name' => $term->slug,
				'numberposts' => -1,
				'fields' => 'ids',
				'post_status' => 'publish',
			]);
			$total_posts = count($total_posts);

			// Calculate if current page is valid
			$total_pages = ($total_posts <= $first_page_count) ? 1 :
				1 + ceil(($total_posts - $first_page_count) / $posts_per_page);

			// Prevent 404 on valid pages and set proper offset
			if ($paged <= $total_pages) {
				$query->is_404 = false;
				$query->set('posts_per_page', $posts_per_page);

				// Calculate offset - simpler formula works for all pages
				$offset = $first_page_count + ($paged - 2) * $posts_per_page;
				$query->set('offset', $offset);
			}
		}
	}
}
add_action('pre_get_posts', 'fix_category_pagination', 1);

/**
 * Fix pagination when using custom offset
 */
function fix_offset_pagination($found_posts, $query) {
	if (!is_admin() && $query->is_main_query() && $query->is_category() && $query->get('offset')) {
		return $found_posts + $query->get('offset');
	}
	return $found_posts;
}
add_filter('found_posts', 'fix_offset_pagination', 10, 2);