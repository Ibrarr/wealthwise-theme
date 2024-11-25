<?php
/**
 * The template for displaying posts
 *
 */

$post_type    = 'post';
$taxonomy     = 'category';
$terms        = get_the_terms( get_the_ID(), $taxonomy );
$term_name    = $terms[0]->name;

$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$image_srcset = wp_get_attachment_image_srcset( $thumbnail_id );
?>
