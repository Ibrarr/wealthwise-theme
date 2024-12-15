<?php
/*
Template Name: Analysis & Opinion Archive
*/
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$video_ids = [];
get_header();
?>

<?php if ($paged === 1) { ?>
	<section class="main">
		<div class="container px-4">
			<h1>Analysis & Opinion</h1>
			<div class="row">
				<div class="col-lg-9">
					<div class="row">
						<?php
						$query = new WP_Query(array(
							'post_type' => 'post',
							'category_name' => 'analysis,opinion',
							'posts_per_page' => 8,
							'post_status'    => 'publish',
							'paged' => $paged,
						));

						if ($query->have_posts()) :
							$post_count = 0;
							while ($query->have_posts()) : $query->the_post();
								$post_count++;
								$terms     = get_the_terms(get_the_ID(), 'category');
								$term_name = $terms[0]->name;
								if ($post_count === 1) {
									echo '<div class="col-lg-12 mb-4 featured-article-card">';
									require get_template_directory() . '/template-parts/featured-article-card-block.php';
									echo '</div>';
									echo '<div class="row not-main">';
								} elseif ($post_count === 2) {
									echo '<div class="col-lg-4 mb-4 standard-article-card second">';
									require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
									echo '</div>';
								} elseif ($post_count === 3) {
									echo '<div class="col-lg-8 mb-4 other">';
									echo '<div class="standard-article-card">';
									require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
									echo '</div>';
								} elseif ($post_count === 4) {
									echo '<div class="standard-article-card">';
									require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
									echo '</div>';
									echo '</div>';
									echo '</div>';
								}
							endwhile;
							?>
						</div>
					<?php
					endif;
					wp_reset_postdata();
					?>
				</div>
				<div class="col-lg-3 partner-zone-side">
					<p class="zone-header">Partner zone</p>
					<?php
					$right_query = new WP_Query(array(
						'post_type' => 'partner_content',
						'posts_per_page' => 4,
						'post_status'    => 'publish',
					));

					if ($right_query->have_posts()) :
						while ($right_query->have_posts()) : $right_query->the_post();
							$terms     = get_the_terms(get_the_ID(), 'partner');
							$term_name = $terms[0]->name;
							?>
							<?php require get_template_directory() . '/template-parts/archive-partner-card-short.php'; ?>
						<?php
						endwhile;
					endif;
					wp_reset_postdata();
					?>

					<div class="search">
						<br>
						<div class="search-box">
							<span>Search</span>
							<div class="icon"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/search.svg' ) ?></div>
						</div>
						<div class="sponsor">
							<span>Sponsored by:</span>
							<img src="<?php the_field( 'sponsor_logo', 'option' ); ?>" alt="sponsor-logo">
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="row bottom-row">
						<?php
						$remaining_count = 0;

						if ($query->have_posts()) :
							while ($query->have_posts()) : $query->the_post();
								$post_count++;
								if ($post_count <= 4) {
									continue;
								}

								if ($remaining_count < 4) {
									echo '<div class="col-lg-3 mb-4 standard-article-card">';
									require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
									echo '</div>';
									$remaining_count++;
								} else {
									break;
								}
							endwhile;
						endif;
						?>
					</div>
				</div>
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
						echo '<span class="pagination-text">Page ' . esc_html($current_page) . ' of ' . esc_html($total_pages) . '</span>';

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

    <section class="partner-zone">
        <div class="container px-4">
            <div class="row">
                <h3>Partner zone</h3>
				<?php
				$partner_query = new WP_Query(array(
					'post_type' => 'partner_content',
					'posts_per_page' => 4,
					'post_status'    => 'publish',
				));

				if ($partner_query->have_posts()) :
					while ($partner_query->have_posts()) : $partner_query->the_post();
						$terms     = get_the_terms(get_the_ID(), 'partner');
						$term_name = $terms[0]->name;
						?>
						<?php require get_template_directory() . '/template-parts/standard-article-card.php'; ?>
					<?php
					endwhile;
				endif;
				wp_reset_postdata();
				?>
            </div>
        </div>
    </section>

    <section class="videos">
        <div class="container px-4">
            <div class="row">
                <h3>Videos</h3>
				<?php
				$videos_query = new WP_Query(array(
					'post_type' => 'video',
					'posts_per_page' => 3,
					'post_status'    => 'publish',
				));

				if ($videos_query->have_posts()) :
					while ($videos_query->have_posts()) : $videos_query->the_post();
						$video_ids[] = get_the_ID();
						$terms     = get_the_terms(get_the_ID(), 'type');
						$term_name = $terms[0]->name;
						echo '<div class="col-lg-4 col-12 mb-4 standard-article-card">';
						require get_template_directory() . '/template-parts/standard-video-card-no-col.php';
						echo '</div>';
					endwhile;
				endif;
				wp_reset_postdata();
				?>
            </div>
        </div>
    </section>

    <section class="choice-words">
        <div class="container px-4">
            <div class="row">
                <h3>Choice words</h3>
				<?php
				$choice_query = new WP_Query(array(
					'post_type' => 'post',
					'posts_per_page' => 3,
					'post_status'    => 'publish',
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'name',
							'terms' => 'Choice words',
						),
					),
				));

				if ($choice_query->have_posts()) :
					while ($choice_query->have_posts()) : $choice_query->the_post();
						$post_ids[] = get_the_ID();
						$terms     = get_the_terms(get_the_ID(), 'category');
						$term_name = $terms[0]->name;
						?>
						<?php require get_template_directory() . '/template-parts/standard-article-card.php'; ?>
					<?php
					endwhile;
				endif;
				wp_reset_postdata();
				?>
                <div class="col-lg-3 col-md-6 col-12 mb-4 video-choice">
                    <p class="heading-term">More choice words videos</p>
					<?php
					$choice_query = new WP_Query(array(
						'post_type' => 'video',
						'posts_per_page' => 3,
						'post_status'    => 'publish',
						'post__not_in'   => $video_ids,
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'name',
								'terms' => 'Choice words',
							),
						),
					));

					if ($choice_query->have_posts()) :
						while ($choice_query->have_posts()) : $choice_query->the_post();
							$video_ids[] = get_the_ID();
							?>
                            <a href="<?php the_permalink(); ?>">
                                <p class="title"><span>Watch: </span><?php the_title(); ?></p>
                            </a>
						<?php
						endwhile;
					endif;
					wp_reset_postdata();
					?>
                    <div class="sponsor">
                        <span>Sponsored by:</span>
                        <img src="<?php the_field( 'sponsor_logo', 'option' ); ?>" alt="sponsor-logo">
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
	<section class="main rest-of-pages">
		<div class="container px-4">
			<h1>Analysis & Opinion</h1>
			<div class="row posts">
				<?php
				$query = new WP_Query(array(
					'post_type' => 'post',
					'category_name' => 'analysis,opinion',
					'posts_per_page' => 12,
					'post_status'    => 'publish',
					'paged' => $paged,
				));

				if ($query->have_posts()) :
				$post_count = 0;
				while ($query->have_posts()) : $query->the_post();
					$post_count++;
					$terms     = get_the_terms(get_the_ID(), 'category');
					$term_name = $terms[0]->name;
					echo '<div class="col-lg-3 mb-4 standard-article-card">';
					require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
					echo '</div>';
				endwhile;
				?>
			</div>
			<?php
			endif;
			wp_reset_postdata();
			?>

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
		</div>
	</section>
<?php } ?>

<?php
get_footer();
?>