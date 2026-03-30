<?php
if ( apply_filters( 'litespeed_esi_status', false ) ) {
    echo apply_filters(
        'litespeed_esi_url',
        'partner_zone_sidebar',
        'Partner zone sidebar'
    );
} else {
    require get_template_directory() . '/template-parts/partner-zone-sidebar-content.php';
}
?>