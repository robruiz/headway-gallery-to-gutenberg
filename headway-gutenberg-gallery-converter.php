<?php
/*
Plugin Name: Headway to Gutenberg Gallery Converter
Plugin URI: https://github.com/robruiz/headway-gallery-to-gutenberg
Description: Convert Headway HWR Galleries to Gutenberg Galleries
Version: 1.0
Requires PHP: 7.0
Requires at least: 4.5
Author: Rob Ruiz
Author URI: https://www.linkedin.com/in/robcruiz/
License: GPLv3 or later
 */

function convert_headway_gallery_mb() {
    $screens = [ 'page' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'amfence_convert_headway_gallery',                 // Unique ID
            'Convert Headway Gallery',      // Box title
            'convert_headway_gallery_script',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'convert_headway_gallery_mb' );

function convert_headway_gallery_script($post){

    $galleries_args = array(
        'post_type' => 'hwr_gallery',
        'posts_per_page' => -1
    );
    $hw_galleries = get_posts($galleries_args);
    if(isset($_GET['loadGallery'])){
        $gallery_image_ids = get_post_meta($_GET['loadGallery'], 'hwr_gallery_image', true);
        $redirect_uri = str_replace('&loadGallery='.$_GET['loadGallery'], '', $_SERVER['REQUEST_URI']);
        $gallery_content = build_gallery_html($gallery_image_ids);
        wp_update_post(  array(
            'ID' => $_GET['post'],
            'post_content' => $gallery_content,
        ) );
        wp_redirect($redirect_uri);
    }
    $base_link = str_replace('&loadGallery', '', $_SERVER['REQUEST_URI']);
    echo '<h4>Headway Galleries in the DB</h4>';
    echo '<p>Select a gallery below to load it into this post\'s content as a Gutenberg Gallery<br /><em>Note: This replaces all existing content in the post!</em></p>';
    if(count($hw_galleries)){
        echo '<ul style="height: 250px;overflow-y: scroll;border: 2px solid #cccccc;padding: 10px;">';
        foreach($hw_galleries as $hw_gallery){
            echo '<li><a href="'.$base_link.'&loadGallery='.$hw_gallery->ID.'">'.$hw_gallery->post_title.'</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p><strong>No Headway Galleries in the database</strong></p>';
    }
}

function build_gallery_comment_top($gallery_image_ids){
    $array_str = '['.implode( ',', $gallery_image_ids).']';
    return '<!-- wp:gallery {"ids":'.$array_str.',"linkTo":"file"} -->';
}
function build_gallery_html($gallery_image_ids){
    $html = build_gallery_comment_top($gallery_image_ids).'<figure class="wp-block-gallery columns-3 is-cropped"><ul class="blocks-gallery-grid">';
    foreach($gallery_image_ids as $gallery_image_id){
        $gallery_img = wp_get_attachment_image($gallery_image_id, 'full');
        $img_meta = wp_get_attachment_metadata($gallery_image_id);
        $imgs_base = wp_upload_dir()["baseurl"];
        $med_img_url = wp_get_attachment_image_url($gallery_image_id, "medium");
        $img_url = $imgs_base.'/'.$img_meta["file"];
        $html .= '<li class="blocks-gallery-item"><figure><a href="'.$img_url.'"><img src="'.$med_img_url.'" alt="" data-id="3005" data-full-url="'.$img_url.'" data-link="'.$img_url.'" class="wp-image-'.$gallery_image_id.'"/></a></figure></li>';
    }
    $html .= '</ul></figure>-->';
    return $html;
}