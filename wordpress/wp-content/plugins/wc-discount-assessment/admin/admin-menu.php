<?php

if (!defined('ABSPATH')) exit;

class Admin_Menu{

    public static function init() {
        add_menu_page(
            'WC-discount-assessment',
            'WC-Discount-Assessment',
            'manage_options',
            'discount-assessment',
            [__CLASS__, 'render_discount_form'],
            'dashicons-tag',
            56
        );
    }

    public static function render_discount_form(){
        require_once plugin_dir_path(__FILE__) . "views/set-discount-page.php";
    }
}