<?php
/*
    Plugin Name: PJ Contact Form (Beta)
    Plugin URI: https://github.com/ProfJava/pj-contact-form
    Description: Contact Form Plugin.
    Version : 0.1
    Author: Prof
    Author URI: https://github.com/ProfJava
    License: GPL2 or later
    Text Domain: pj-contact-form
*/
/**
 * @package PjContactForm
 */

if( ! defined('ABSPATH')) {
    die;
}

//Plugin Version
if ( ! defined( 'PJ_CF_VERSION' ) ) {
    define( 'PJ_CF_VERSION', 0.1 );
}

include plugin_dir_path( __FILE__ ) . 'assets.php'; //plugin helper functionalities
include plugin_dir_path( __FILE__ ) . 'hooks.php';  //plugin css and js files
include plugin_dir_path( __FILE__ ) . 'admin.php';


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

function add_action_links ( $links ) {
    $mylinks = array(
        '<a href="admin.php?page=pj_contact_form">Settings</a>',
    );
    return array_merge( $links, $mylinks );
}
add_action( 'admin_menu', 'add_admin_pages' );
function add_admin_pages() {
    add_menu_page( 'PJ Contact Form','PJ Contact Form','manage_options','pj_contact_form', 'admin_index' , 'dashicons-store', 110 );
}

function admin_index() {
    // Require Template
    require_once plugin_dir_path(__FILE__) . 'templates/pjcf-settings.php';
}

///** Step 2 (from text above). */
//add_action( 'admin_menu', 'my_plugin_menu' );
//
///** Step 1. */
//function my_plugin_menu() {
//    add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
//}
//
///** Step 3. */
//function my_plugin_options() {
//    if ( !current_user_can( 'manage_options' ) )  {
//        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
//    }
//    echo '<div class="wrap">';
//    echo '<p>Here is where the form would go if I actually had options.</p>';
//    echo '</div>';
//}