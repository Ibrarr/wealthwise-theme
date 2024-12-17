<section class="videos">
	<div class="container px-4">
		<div class="row">
			<h3>Videos</h3>
			<?php
			$acf_videos_posts = get_field('videos_section', 'option') ?? [];
			$video_ids = [];

			if (!empty($acf_videos_posts)) {
				foreach ($acf_videos_posts as $acf_video) {
					if (is_a($acf_video, 'WP_Post')) {
						global $post;
						$post = $acf_video;
						setup_postdata($post);

						$video_ids[] = $post->ID;

						$terms = get_the_terms($post->ID, 'type');
						$term_name = $terms[0]->name ?? '';

						echo '<div class="col-lg-4 col-12 mb-4 standard-article-card">';
						require('standard-video-card-no-col.php');
						echo '</div>';

						wp_reset_postdata();

						if (count($video_ids) >= 3) {
							break;
						}
					}
				}
			}

			$remaining_videos = 3 - count($video_ids);

			if ($remaining_videos > 0) {
				$videos_query = new WP_Query(array(
					'post_type'      => 'video',
					'posts_per_page' => $remaining_videos,
					'post_status'    => 'publish',
					'post__not_in'   => $video_ids,
				));

				if ($videos_query->have_posts()) :
					while ($videos_query->have_posts()) : $videos_query->the_post();
						$video_ids[] = get_the_ID();

						$terms = get_the_terms(get_the_ID(), 'type');
						$term_name = $terms[0]->name ?? '';

						echo '<div class="col-lg-4 col-12 mb-4 standard-article-card">';
						require('standard-video-card-no-col.php');
						echo '</div>';
					endwhile;
				endif;

				wp_reset_postdata();
			}
			?>
		</div>
	</div>
</section>