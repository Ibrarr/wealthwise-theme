<section class="choice-words">
	<div class="container px-4">
		<div class="row">
			<h3>Choice Words</h3>
			<?php
			$acf_choice_posts = get_field('choice_words_posts', 'option') ?? [];
			$choice_post_ids = [];

			if (!empty($acf_choice_posts)) {
				foreach ($acf_choice_posts as $acf_post) {
					if (is_a($acf_post, 'WP_Post')) {
						global $post;
						$post = $acf_post;
						setup_postdata($post);

						$post_ids[] = $post->ID;
						$choice_post_ids[] = $post->ID;

						require('standard-article-card.php');
						wp_reset_postdata();

						if (count($choice_post_ids) >= 3) {
							break;
						}
					}
				}
			}

			$remaining_posts = 3 - count($choice_post_ids);

			if ($remaining_posts > 0) {
				$choice_query = new WP_Query(array(
					'post_type'      => 'post',
					'posts_per_page' => $remaining_posts,
					'post_status'    => 'publish',
					'post__not_in'   => $post_ids,
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field'    => 'name',
							'terms'    => 'Choice words',
						),
					),
				));

				if ($choice_query->have_posts()) :
					while ($choice_query->have_posts()) : $choice_query->the_post();
						$post_ids[] = get_the_ID();
						$choice_post_ids[] = get_the_ID();
						require('standard-article-card.php');
					endwhile;
				endif;
				wp_reset_postdata();
			}
			?>

			<div class="col-lg-3 col-md-6 col-12 mb-4 video-choice">
				<p class="heading-term">More choice words videos</p>
				<?php
				$acf_choice_videos = get_field('choice_words_videos', 'option') ?? [];
				$choice_video_ids = [];

				if (!empty($acf_choice_videos)) {
					foreach ($acf_choice_videos as $acf_video) {
						if (is_a($acf_video, 'WP_Post')) {
							global $post;
							$post = $acf_video;
							setup_postdata($post);

							$video_ids[] = $post->ID;
							$choice_video_ids[] = $post->ID;

							?>
							<a href="<?php the_permalink(); ?>">
								<p class="title"><span>Watch: </span><?php the_title(); ?></p>
							</a>
							<?php
							wp_reset_postdata();

							if (count($choice_video_ids) >= 3) {
								break;
							}
						}
					}
				}


				$remaining_videos = 3 - count($choice_video_ids);

				if ($remaining_videos > 0) {
					$choice_videos_query = new WP_Query(array(
						'post_type'      => 'video',
						'posts_per_page' => $remaining_videos,
						'post_status'    => 'publish',
						'post__not_in'   => $video_ids,
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field'    => 'name',
								'terms'    => 'Choice words',
							),
						),
					));

					if ($choice_videos_query->have_posts()) :
						while ($choice_videos_query->have_posts()) : $choice_videos_query->the_post();
							$video_ids[] = get_the_ID();
							$choice_video_ids[] = get_the_ID();
							?>
							<a href="<?php the_permalink(); ?>">
								<p class="title"><span>Watch: </span><?php the_title(); ?></p>
							</a>
						<?php
						endwhile;
					endif;
					wp_reset_postdata();
				}
				?>
				<div class="sponsor">
					<span>Sponsored by:</span>
					<img src="<?php the_field('sponsor_logo_dark', 'option'); ?>" alt="sponsor-logo">
				</div>
			</div>
		</div>
	</div>
</section>