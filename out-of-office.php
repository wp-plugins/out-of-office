<?php
/*
Plugin Name: out-of-office
Plugin URI: http://codemarker.co.uk/out-of-office/
Description: Out-of-Office is a simple plugin that allows users to show whether or not they are out of office. We used this widget to display whether we are open of able to reply to enquiries within our 1 hour target.
Version: 1.0.1
Author: Hakim Bensiali
Author URI: http://codemarker.co.uk/out-of-office/
License: GPLv2 or later
Text Domain: out-of-office
*/



DEFINE("PLUGIN_NAME", "out_of_office");
DEFINE("PLUGIN_DIR", plugins_url(__FILE__));
DEFINE("PLUGIN_DIR_PATH", plugin_dir_path( __FILE__ ));
DEFINE("PLUGIN_URL", plugins_url() . "/out-of-office/");
//////////////////////////////

global $wp_version;
$exit_msg = "Out-of_office requires Wordpress 2.7 or newer. <a href='http://codex.wordpress.org/Updating_WordPress' >Please upgrade!</a>";

if(version_compare($wp_version, '2.7', '<')) 
{
	exit($exit_msg);
}

if(is_admin())
{
add_action('admin_menu', 'ooo_create_menu') ;
}

require_once(PLUGIN_DIR_PATH. 'ooo_widget.php');
require_once(PLUGIN_DIR_PATH. 'functions.php');
require_once(PLUGIN_DIR_PATH. 'process_func.php');
require_once(PLUGIN_DIR_PATH. 'front_function.php');

register_uninstall_hook(__FILE__, 'ooo_uninstall_my_plugin');
register_deactivation_hook(__FILE__, 'ooo_uninstall_my_plugin');
register_activation_hook( __FILE__, 'bt_add_my_options' ); 
wp_register_style( "ooo_css_script", PLUGIN_URL . "css/styles.css");
wp_register_style( "ooo_css_script2", PLUGIN_URL . "css/user_style.css");
add_action( 'init', 'register_shortcodes');
add_action('init', 'ooo_register_hooks');
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
//////////////////////START REGISTER THINGS//////////////////
function register_shortcodes()
{
add_shortcode( 'ooo_insert_status', 'ooo_display_widget_tab' );
}

function load_custom_wp_admin_style() 
{
        wp_register_style( 'ooo_custom_wp_admin_css', PLUGIN_URL . '/css/admin_style.css', false, '1.0.0' );
        wp_enqueue_style( 'ooo_custom_wp_admin_css' );
}

function register_mysettings() 
{
	//register our settings
	register_setting( 'ooo-settings-group', 'ooo_widget_values' );
}

function ooo_register_hooks()
{
add_filter('ooo_plugin_display_hook', 'ooo_display_widget', 6, 2);
}
/////////////////END REGISTER////////////////

function ooo_uninstall_my_plugin()
{

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();
delete_option('ooo_widget_values');
}

function ooo_create_menu() 
{
	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
	bt_add_my_options();
	
	$main_menu_slug = 'cm_out_of_office_main';
	$sub_slug1 = 'cm_out_of_office';
	
	add_menu_page('OOO Settings', 'Out Of Office', 'manage_options', $main_menu_slug , 'ooo_settings_page', plugin_dir_url( __FILE__ ) . 'images/green_orb.png');
	add_submenu_page($main_menu_slug, 'OOO about', 'OOO about', 'manage_options', $sub_slug1, 'ooo_about_page' );
	//add_options_page('OOO Settings', 'OOO Settings', 'manage_options', 'cm_out_of_office', 'ooo_settings_page');
	
}

if(function_exists('ooo_update_post_values_hook'))
{
add_action('ooo_process_post_values', 'ooo_update_post_values_hook', 10, 1 );
}

if(is_admin())
{
  if(isset($_POST['ooo_form_show']))
  {
	do_action('ooo_process_post_values');
  }
  add_action( 'admin_menu', 'ooo_create_menu' );
}

///////////////////////////////////
add_action( 'wp_enqueue_scripts', 'add_ooo_script');
function add_ooo_script() 
{
    wp_enqueue_script('ooo_jquery_script', PLUGIN_URL . '/script/my_jquery.js', array('jquery'));
}

?>
