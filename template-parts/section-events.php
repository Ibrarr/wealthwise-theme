<section class="events">
    <div class="container px-4">
        <div class="row">
            <h3>Events</h3>
			<?php
			$acf_event_posts = get_field('event_posts_archive', 'option') ?? [];
			$event_archive_ids = [];

			if (!empty($acf_event_posts)) {
				foreach ($acf_event_posts as $acf_event) {
					if (is_a($acf_event, 'WP_Post')) {
						global $post;
						$post = $acf_event;
						setup_postdata($post);

						$post_ids[] = $post->ID;
						$event_archive_ids[] = $post->ID;

						echo '<div class="col-lg-4 main-event-card">';
						require get_template_directory() . '/template-parts/main-event-card-no-col.php';
						echo '</div>';

						wp_reset_postdata();

						if (count($event_archive_ids) >= 3) {
							break;
						}
					}
				}
			}

			$remaining_events = 3 - count($event_archive_ids);

			if ($remaining_events > 0) {
				$fallback_event_query = new WP_Query(array(
					'post_type'      => 'event',
					'post__not_in'   => $event_archive_ids, // Exclude already displayed events
					'posts_per_page' => $remaining_events,
					'post_status'    => 'publish',
					'meta_key'       => 'start_date',
					'orderby'        => 'meta_value',
					'order'          => 'ASC',
					'meta_type'      => 'DATE',
				));

				if ($fallback_event_query->have_posts()) :
					while ($fallback_event_query->have_posts()) : $fallback_event_query->the_post();
						$post_ids[] = get_the_ID();
						$event_archive_ids[] = get_the_ID();

						echo '<div class="col-lg-4 main-event-card">';
						require get_template_directory() . '/template-parts/main-event-card-no-col.php';
						echo '</div>';
					endwhile;
				endif;
				wp_reset_postdata();
			}
			?>
        </div>
    </div>
</section>