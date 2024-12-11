<?php
get_header();
?>
<div class="container px-4 page-content">
	<section>
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<h1 class="title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
		</div>
	</section>
</div>
<?php
get_footer();
?>