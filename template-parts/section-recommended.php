<section class="recommended">
	<div class="container px-4">
		<div class="row">
			<h3>Recommended</h3>
			<?php
			$acf_recommended_posts = get_field('recommended_posts', 'option') ?? [];
			$recommended_post_ids = [];
			$post_ids = [];

			if (!empty($acf_recommended_posts)) {
				foreach ($acf_recommended_posts as $acf_post) {
					if (is_a($acf_post, 'WP_Post')) {
						global $post;
						$post = $acf_post;
						setup_postdata($post);

						$post_ids[] = $post->ID;
						$recommended_post_ids[] = $post->ID;
						$terms     = get_the_terms(get_the_ID(), (get_post_type() === 'video') ? 'type' : 'category');
						$term_name = $terms[0]->name;
						require get_template_directory() . '/template-parts/standard-article-card.php';
						wp_reset_postdata();

						if (count($recommended_post_ids) >= 4) {
							break;
						}
					}
				}
			}

			$remaining_posts = 4 - count($recommended_post_ids);

			if ($remaining_posts > 0) {
				$recommended_query = new WP_Query(array(
					'post_type'      => 'post',
					'posts_per_page' => $remaining_posts,
					'post_status'    => 'publish',
					'post__not_in'   => $post_ids,
				));

				if ($recommended_query->have_posts()) :
					while ($recommended_query->have_posts()) : $recommended_query->the_post();
						$post_ids[] = get_the_ID();
						$recommended_post_ids[] = get_the_ID();
						$terms     = get_the_terms(get_the_ID(), (get_post_type() === 'video') ? 'type' : 'category');
						$term_name = $terms[0]->name;
						require get_template_directory() . '/template-parts/standard-article-card.php';
					endwhile;
				endif;
				wp_reset_postdata();
			}
			?>
		</div>
	</div>
</section>