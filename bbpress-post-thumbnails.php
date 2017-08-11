<?php
/*
Plugin Name: bbPress Topic Thumbnails
Plugin URI: http://shanegowland.com/wordpress/
Description: Gets the first image from each bbPress topic and displays it as a thumbnail.
Author: Shane Gowland
Version: 1.2
Author URI: http://shanegowland.com	
License: GPL2
*/

/*Display a warning if bbPress not installed*/
add_action( 'admin_notices', 'bee_thumbs_admin_notice' );
function bee_thumbs_admin_notice(){
	if (!is_plugin_active('bbpress/bbpress.php')) {
	 echo '<div class="updated"><p>bbPress has not been activated. Please disable <em>bbPress Topic Thumbnails</em>.</p></div>';
	}
}

/*Hooks into the loop-topic.php output to print image*/
add_action( 'bbp_theme_before_topic_title', 'bee_insert_thumbnail' );
function bee_insert_thumbnail() {

	if((!bee_catch_image() == '')){
	echo('<a href="'); 
    echo(bbp_topic_permalink() . '"><img class="bbp-topic-thumbnail"  width="100%" style="max-width: ' . get_option('thumbnail_size_w') . 'px; max-height: ' . get_option('thumbnail_size_h'). 'px; vertical-align:middle;" src="' . bee_catch_image() . '"/>' .'</a>');
	}
}

/*Function that retrieves the first image associated with the topic*/
function bee_catch_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];
  return $first_img;
}