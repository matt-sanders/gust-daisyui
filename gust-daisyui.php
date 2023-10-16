<?php
/**
 * Plugin Name: Gust Daisy UI
 * Description: Gust support for the Daisy UI component library.
 * Version: 0.0.1
 * Author: Gust
 * Author URI: https://www.getgust.com
 * License: GPL2
 * Text Domain: gust-daisyui
 * 
 * @package GustDaisyui
 */

defined( 'ABSPATH' ) || exit;

define( 'GUST_DAISYUI_PLUGIN_VERSION', '0.0.1' );

if ( ! defined( 'GUST_DAISYUI_PLUGIN_FILE' ) ) {
	define( 'GUST_DAISYUI_PLUGIN_FILE', __FILE__ );
}

if ( ! class_exists( 'Gust_Daisyui' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-gust-daisyui.php';
}
