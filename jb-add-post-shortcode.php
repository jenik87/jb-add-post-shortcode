<?php
/*
Plugin Name: JB Add New Post Shortcode
Plugin URI:
Description: JB Add New Post Shortcode
Author: jb
Version: 1.0
Author URI: https://jb-web.000webhostapp.com/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/jb-add-post-shortcode-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/settings.php';


add_action('wp_enqueue_scripts', 'jb_scripts');
add_action('wp_ajax_jb_post_form', 'jb_send_post');
add_action('wp_ajax_nopriv_jb_post_form', 'jb_send_post');
add_shortcode( 'jb_add_post_form', 'jb_add_post_form_func' );