<?php
/**
 * Return *only* future-and-today events, paginated.
 */
function get_future_events_query( $paged = 1 ) {
    $today = current_time( 'Y-m-d' );  // honour WP timezone

    return new WP_Query( array(
        'post_type'      => 'event',
        'posts_per_page' => -1,          // adjust if you prefer page-sized chunks
        'post_status'    => 'publish',
        'paged'          => $paged,
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
        'meta_type'      => 'DATE',
        'meta_query'     => array(
            array(
                'key'     => 'start_date',
                'value'   => $today,
                'compare' => '>=',          // today or later
                'type'    => 'DATE',
            ),
        ),
    ) );
}

/**
 * Return *only* past events.  We don’t paginate here
 * (usually past events are a finite archive), but you can
 * add 'paged' & pagination markup if you want.
 */
function get_past_events_query() {
    $today = current_time( 'Y-m-d' );

    return new WP_Query( array(
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key'       => 'start_date',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',     // newest past event first
        'meta_type'      => 'DATE',
        'meta_query'     => array(
            array(
                'key'     => 'start_date',
                'value'   => $today,
                'compare' => '<',           // strictly before today
                'type'    => 'DATE',
            ),
        ),
    ) );
}

$term  = get_queried_object();
$paged = max( 1, get_query_var( 'paged' ) );

// 1. FUTURE EVENTS
$future_query = get_future_events_query( $paged );

// 2. PAST EVENTS (no pagination in this example)
$past_query   = get_past_events_query();

get_header();
?>
<section class="main">
    <div class="container px-4">
        <h1><span>Events</span></h1>
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <?php if ( $future_query->have_posts() ) :
                        while ( $future_query->have_posts() ) : $future_query->the_post(); ?>
                            <div class="col-lg-6 main-event-card">
                                <?php require get_template_directory() . '/template-parts/main-event-card-no-col.php'; ?>
                            </div>
                        <?php endwhile;
                    endif; ?>
                </div>
                <?php if ( $future_query->max_num_pages > 1 ) : ?>
                    <div class="col-12">
                        <nav class="pagination">
                            <?php
                            // Calculate total pages and current page
                            $total_pages = $future_query->max_num_pages;
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
                <?php
                endif;
                wp_reset_postdata();
                ?>

                <h2><span>Past Events</span></h2>
                <div class="row">
                    <?php if ( $past_query->have_posts() ) :
                        while ( $past_query->have_posts() ) : $past_query->the_post(); ?>
                            <div class="col-lg-6 past-event-card">
                                <?php require get_template_directory() . '/template-parts/main-event-card-no-col.php'; ?>
                            </div>
                        <?php endwhile;
                    else : ?>
                        <p>No past events found.</p>
                    <?php endif;
                    wp_reset_postdata(); ?>
                </div>
            </div>

            <div class="col-lg-3 partner-zone-side">
                <?php require get_template_directory() . '/template-parts/partner-zone-sidebar.php'; ?>
            </div>
        </div>
    </div>
</section>

<!-- PAST EVENTS SECTION -->
<!--<section class="past-events">-->
<!--    <div class="container px-4">-->
<!--        <h2><span>Past Events</span></h2>-->
<!--        <div class="row">-->
<!--            --><?php //if ( $past_query->have_posts() ) :
//                while ( $past_query->have_posts() ) : $past_query->the_post(); ?>
<!--                    <div class="col-lg-4 past-event-card">-->
<!--                        --><?php //require get_template_directory() . '/template-parts/main-event-card-no-col.php'; ?>
<!--                    </div>-->
<!--                --><?php //endwhile;
//            else : ?>
<!--                <p>No past events found.</p>-->
<!--            --><?php //endif;
//            wp_reset_postdata(); ?>
<!--        </div>-->
<!--    </div>-->
<!--</section>-->

<?php
require get_template_directory() . '/template-parts/section-partner-zone.php';
require get_template_directory() . '/template-parts/section-recommended.php';
get_footer();
?>