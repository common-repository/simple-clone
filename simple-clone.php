<?php
/**
 * Plugin Name: Simple Clone
 * Plugin URI: https://pixelpylon.com/plugins/simpleclone/
 * Description: A simple cloning plugin that allows duplicating of posts, pages, and custom post types.
 * Version: 1.0.1
 * Author: pixelpylon
 * Author URI: https://pixelpylon.com/
 * License: GPL-2.0-or-later
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// define plugin version
define( 'SIMPLE_CLONE_VERSION', '1.0.0' );

// include core functionality
require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-clone.php';

// activation and deactivation hooks
register_activation_hook( __FILE__, 'simple_clone_activate' );
register_deactivation_hook( __FILE__, 'simple_clone_deactivate' );

// function to run on activation
function simple_clone_activate() {
    // add activation logic here if needed
}

// function to run on deactivation
function simple_clone_deactivate() {
    // add deactivation logic here if needed
}

// initialize the plugin
function run_simple_clone() {
    $plugin = new Simple_Clone();
    $plugin->run();
}
run_simple_clone();
