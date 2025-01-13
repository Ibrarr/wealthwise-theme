<?php
get_header();
?>
<div class="container px-4 page-content">
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <h1 class="title">The page you are looking for can’t be found</h1>
                <form action="/" method="get">
                    <input type="text" name="s" id="search" placeholder="Search wealthwise.media here" value="<?php the_search_query(); ?>" />
                    <input type="image" src="<?php echo get_template_directory_uri() . '/assets/images/icons/search.svg'; ?>" alt="Search" />
                </form>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();
?>