<?php
/*
    Plugin Name: PJ Contact Form
    Plugin URI: https://github.com/ProfJava/pj-contact-form
    Description: Contact Form Plugin.
    Version: 0.1
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
    define( 'PJCF_VERSION', 0.1 );
}

include plugin_dir_path( __FILE__ ) . 'assets.php'; //plugin helper functionalities
include plugin_dir_path( __FILE__ ) . 'hooks.php';  //plugin css and js files
include plugin_dir_path( __FILE__ ) . 'admin.php';


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'pjcf_add_action_links' );

function pjcf_add_action_links ( $links ) {
    $mylinks = array(
        '<a href="admin.php?page=pj_contact_form">Settings</a>',
    );
    return array_merge( $links, $mylinks );
}
add_action( 'admin_menu', 'pjcf_add_admin_pages' );
function pjcf_add_admin_pages() {
    add_menu_page( 'PJ Contact Form','PJ Contact Form','manage_options','pj_contact_form', 'pjcf_admin_index' , 'dashicons-store', 110 );
}

function pjcf_admin_index() {
    // Require Template
    require_once plugin_dir_path(__FILE__) . 'templates/pjcf-settings.php';
}