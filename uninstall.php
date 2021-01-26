<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (!defined('WP_UNINSTALL_PLUGIN')) exit;

// delete options
delete_option('jb_options');