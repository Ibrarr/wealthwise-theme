<?php
function get_custom_event_query($paged) {
	$today = date('Y-m-d');

	// First query: Future events
	$future_events = new WP_Query(array(
		'post_type' => 'event',
		'posts_per_page' => -1, // Retrieve all future events
		'post_status' => 'publish',
		'meta_key' => 'start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_type' => 'DATE',
		'meta_query' => array(
			array(
				'key' => 'start_date',
				'value' => $today,
				'compare' => '>=', // Events on or after today
				'type' => 'DATE',
			),
		),
	));

	// Second query: Past events
	$past_events = new WP_Query(array(
		'post_type' => 'event',
		'posts_per_page' => -1, // Retrieve all past events
		'post_status' => 'publish',
		'meta_key' => 'start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_type' => 'DATE',
		'meta_query' => array(
			array(
				'key' => 'start_date',
				'value' => $today,
				'compare' => '<', // Events before today
				'type' => 'DATE',
			),
		),
	));

	// Combine results: Future first, then past
	$events = array_merge($future_events->posts, $past_events->posts);

	// Create a new WP_Query object for pagination
	return new WP_Query(array(
		'post_type' => 'event',
		'posts_per_page' => 6, // Adjust to your desired pagination
		'post_status' => 'publish',
		'paged' => $paged,
		'post__in' => wp_list_pluck($events, 'ID'), // Order by merged IDs
		'orderby' => 'post__in',
	));
}

$term = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$query = get_custom_event_query($paged);
$partner_post_ids = [];
get_header();
?>

    <section class="main">
        <div class="container px-4">
            <h1><span>Events</span></h1>
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
						<?php
						if ($query->have_posts()) :
						$post_count = 0;
						while ($query->have_posts()) : $query->the_post();
							$post_count++;
							echo '<div class="col-lg-6 main-event-card">';
							require get_template_directory() . '/template-parts/main-event-card-no-col.php';
							echo '</div>';
						endwhile;
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

<?php require get_template_directory() . '/template-parts/section-recommended.php'; ?>

<?php
get_footer();
?>