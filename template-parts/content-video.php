<?php
/**
 * The template for displaying videos
 *
 */

$post_type    = 'video';
$taxonomy     = 'type';
$terms        = get_the_terms( get_the_ID(), $taxonomy );
$term_name    = $terms[0]->name;

$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container px-4">
		<section class="post-header row">
            <div class="col-lg-8 offset-lg-2">
                <p class="term"><?php echo $term_name; ?></p>
                <div class="title-share">
                    <h1 class="title"><?php the_title(); ?></h1>
                    <div class="share">
                        <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/share.svg' ) ?>
                    </div>
                </div>
            </div>
		</section>

        <section class="video">
            <div class="embed-container">
		        <?php the_field('video'); ?>
            </div>
        </section>

		<section class="post-content">
			<div class="row">
                <div class="col-lg-10 offset-lg-2">
                    <p class="excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <div class="content"><?php the_field( 'content' ); ?></div>
                </div>
            </div>
		</section>

        <section class="related-content">
            <h3>Recommended</h3>
            <div class="row mb-3">
		        <?php
		        $related_posts = new WP_Query(array(
			        'post_type' => $post_type,
			        'posts_per_page' => 4,
			        'post__not_in' => array(get_the_ID()),
			        'tax_query' => array(
				        array(
					        'taxonomy' => $taxonomy,
					        'field' => 'name',
					        'terms' => $term_name,
				        ),
			        ),
		        ));

		        if ($related_posts->have_posts()) :
			        while ($related_posts->have_posts()) : $related_posts->the_post();
				        require('standard-article-card.php');
			        endwhile;
			        wp_reset_postdata();
		        else :
			        echo '<p>No related posts available at the moment.</p>';
		        endif;
		        ?>
            </div>
        </section>
	</div>
</article>