<section class="partner-zone">
	<div class="container px-4">
		<div class="row">
			<h3>Partner zone</h3>
			<?php
			// Display posts for positions 6–9
			for ($i = 5; $i < 9; $i++) {
				$post_id = $partner_post_ids[$i];
				if ($post_id) {
					$post = get_post($post_id);
					setup_postdata($post);

                    $tax = 'partner';
					$terms = get_the_terms($post->ID, $tax);
					$term_name = $terms ? $terms[0]->name : '';

					require('standard-article-card.php');
				}
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>