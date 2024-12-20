<?php
get_header();
$term = get_search_query();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
	's' => $term,
	'posts_per_page' => 8,
	'paged' => $paged,
	'post_type' => ['post', 'video'],
);
$query = new WP_Query($args);
?>

<section class="top-search">
	<div class="container px-4">
		<div class="row search-box">
			<div class="col-lg-6 offset-lg-3">
				<div class="search">
					<h1>Search results</h1>
					<form action="/" method="get">
						<input type="text" name="s" id="search" placeholder="Enter search" value="<?php echo $term; ?>" />
						<input type="image" src="<?php echo get_template_directory_uri() . '/assets/images/icons/search.svg'; ?>" alt="Search" />
					</form>
				</div>
			</div>
			<div class="col-lg-2 offset-lg-1">
				<div class="sponsor">
					<span>Sponsored by:</span>
					<img src="<?php the_field( 'sponsor_logo_dark', 'option' ); ?>" alt="sponsor-logo">
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h3>Results for: <span><?php echo $term; ?></span></h3>
            </div>
        </div>
	</div>
</section>

<section class="search-results">
	<div class="container px-4">
		<div class="row">
			<?php
			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();
					$terms     = get_the_terms(get_the_ID(), (get_post_type() === 'video') ? 'type' : 'category');
					$term_name = $terms[0]->name;
					echo '<div class="col-lg-3 mb-4 standard-article-card">';
					require get_template_directory() . '/template-parts/standard-article-card-no-col.php';
					echo '</div>';
				endwhile;
			else :
				echo '<p>No results found for your query.</p>';
			endif;

			wp_reset_postdata();
			?>

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
		</div>
	</div>
</section>

<?php
get_footer();
?>