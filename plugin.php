<?php 
/**
 * @package     WordPress.Plugin
 * plugin name: February Option Framework 
 * plugin URI: http://www.appdets.com/february-framework
 * description: A tiny minimal robust WordPress Option Framework made with TailwindCSS and Alpine.js
 * version: 1.0.0
 * author: appdets
 * author URI: http://www.appdets.com
 * license: GPLv2 or later
 * text domain: february-framework
 * domain path: /languages
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// load the plugin class
require_once( plugin_dir_path( __FILE__ ) . '/test/option.php' );