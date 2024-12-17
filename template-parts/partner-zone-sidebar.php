<p class="zone-header">Partner zone</p>
<?php
// Step 1: Fetch manually set partner positions
$position_fields = array(
	'first_position_partner',
	'second_position_partner',
	'third_position_partner',
	'fourth_position_partner',
	'fifth_position_partner',
	'sixth_position_partner',
	'seventh_position_partner',
	'eighth_position_partner',
);

$partner_positions = []; // Array to hold partner IDs per position

foreach ($position_fields as $index => $field) {
	$partner_id = get_field($field, 'option'); // Get term ID
	$partner_positions[$index] = $partner_id ?: null; // Null if not set
}

// Step 2: Get all active partners for randomness
$all_active_partners = get_terms(array(
	'taxonomy'   => 'partner',
	'hide_empty' => true,
	'meta_query' => array(
		array(
			'key'     => 'active',
			'value'   => '1',
			'compare' => '==',
		),
	),
	'cache_results' => false,
));

// Step 3: Shuffle and exclude manually set partners
$random_partners = [];
if (!empty($all_active_partners) && !is_wp_error($all_active_partners)) {
	$used_partners = array_filter($partner_positions); // Get manually set partners
	$random_partners = array_filter($all_active_partners, function ($partner) use ($used_partners) {
		return !in_array($partner->term_id, $used_partners);
	});

	shuffle($random_partners); // Randomize
}

// Step 4: Fill empty positions with random partners
foreach ($partner_positions as $index => $partner_id) {
	if (!$partner_id && !empty($random_partners)) {
		$partner = array_shift($random_partners);
		$partner_positions[$index] = $partner->term_id;
	}
}

// Step 5: Fetch posts for each position
$partner_post_ids = []; // To store post IDs
foreach ($partner_positions as $partner_id) {
	$post_id = null;

	// Check for pinned post
	$pinned_post = get_field('pinned_post_partner_content', 'partner_' . $partner_id);
	if ($pinned_post) {
		if (is_array($pinned_post)) {
			$pinned_post = reset($pinned_post);
		}
		if (is_object($pinned_post)) {
			$post_id = $pinned_post->ID;
		}
	}

	// Fallback to most recent post
	if (!$post_id) {
		$recent_post_query = new WP_Query(array(
			'post_type'      => 'partner_content',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'tax_query'      => array(
				array(
					'taxonomy' => 'partner',
					'field'    => 'term_id',
					'terms'    => $partner_id,
				),
			),
		));

		if ($recent_post_query->have_posts()) {
			$recent_post_query->the_post();
			$post_id = get_the_ID();
			wp_reset_postdata();
		}
	}

	if ($post_id) {
		$partner_post_ids[] = $post_id;
	}
}

// Step 6: Display posts for positions 1–4
for ($i = 0; $i < 4; $i++) {
	$post_id = $partner_post_ids[$i];
	if ($post_id) {
		$post = get_post($post_id);
		setup_postdata($post);

		$terms = get_the_terms($post->ID, 'partner');
		$term_name = $terms ? $terms[0]->name : '';

		require('archive-partner-card-short.php');
	}
}
wp_reset_postdata();
?>
<!-- Sponsor Search Box -->
<div class="search inline">
	<br>
	<div class="search-box">
		<span>Search</span>
		<div class="icon"><?php echo file_get_contents(WW_TEMPLATE_DIR . '/assets/images/icons/search.svg'); ?></div>
	</div>
	<div class="sponsor">
		<span>Sponsored by:</span>
		<img src="<?php the_field('sponsor_logo_dark', 'option'); ?>" alt="sponsor-logo">
	</div>
</div>