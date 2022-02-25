<?php 
/**
 * @package     WordPress.Plugin
 * plugin name: February Demo Option Page
 * plugin URI: http://www.appdets.com/february-framework
 * description: A tiny minimal robust WordPress Option Framework made with TailwindCSS and Alpine.js
 * version: 1.0.0
 * author: appdets
 * author URI: http://www.appdets.com
 * license: GPLv2 or later
 * text domain: february 
 * 
 */

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die('No script kiddies please!');


require_once( plugin_dir_path( __FILE__ ) . '/february/class.february.php' );

// load the plugin class
require_once( plugin_dir_path( __FILE__ ) . '/test/dummy-options.php' );