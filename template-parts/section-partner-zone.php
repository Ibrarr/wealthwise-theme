<?php
if ( apply_filters( 'litespeed_esi_status', false ) ) {
    echo apply_filters(
        'litespeed_esi_url',
        'partner_zone_section',
        'Partner zone section',
        array( implode( ',', $partner_post_ids ) )
    );
} else {
    require get_template_directory() . '/template-parts/section-partner-zone-content.php';
}
?>