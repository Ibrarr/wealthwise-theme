<?php
/*
Template Name: About Us
*/
get_header();

$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
?>
<div class="container px-4 page-content">
	<section>
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<h1 class="title"><?php the_title(); ?></h1>
                <p class="intro"><?php the_field('intro'); ?></p>
				<?php the_content(); ?>
			</div>
		</div>
	</section>

    <section>
        <div class="row img">
            <div class="col-lg-10">
                <img
                        src="<?php the_post_thumbnail_url(); ?>"
                        alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>"
                        srcset="<?php echo wp_get_attachment_image_srcset( get_post_thumbnail_id() ); ?>"
                        sizes="(min-width: 1200px) 1200px,
           (min-width: 768px) 768px,
           (min-width: 576px) 576px,
           100vw">

            </div>
        </div>
    </section>

    <section>
        <div class="row justify-content-center team">
            <div class="col-lg-8">
                <div class="row">
	                <?php
	                if( have_rows('team') ):
		                while( have_rows('team') ) : the_row();
			                $name = get_sub_field('name');
			                $title = get_sub_field('title');
			                $description = get_sub_field('description');
			                ?>
                            <div class="col-lg-6">
                                <h3><?php echo $name ?></h3>
                                <p><?php echo $title ?></p>
                                <p><?php echo $description ?></p>
                            </div>
		                <?php
		                endwhile;
	                endif;
	                ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();
?>