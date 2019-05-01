<?php
if (!defined('ABSPATH')) {
    die;
}

//plugin assets url
//define( 'PJ_CF_ADMIN_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/admin/' );
define( 'PJ_CF_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/front-end/' );

add_action('wp_enqueue_scripts','pj_cf_scripts');

function pj_cf_scripts() {
    // Style Css
    wp_enqueue_style( 'pj-cf-style', PJ_CF_ASSETS . 'css/style.css', false, PJ_CF_VERSION );
    // Main JS
    wp_enqueue_script( 'pj-cf-main', PJ_CF_ASSETS . 'js/main.js', array( 'jquery' ), PJ_CF_VERSION, true );
}