<?php

if (!defined('ABSPATH')) exit;

class Admin_Menu{

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'register_menu_discount']);
    }

    public static function register_menu_discount(){
        // Plugin Main menu
        add_menu_page(
            'WC-discount-assessment',
            'WC-Discount-Assessment',
            'manage_options',
            'discount-assessment',
            [__CLASS__, 'render_discount_form'],
            'dashicons-tag',
            56
        );

        // Plugin Submenu for log list
        add_submenu_page(
            'discount-assessment',
            'Discount Logs',
            'Logs',
            'manage_options',
            'discount-assessment-logs',
            [__CLASS__, 'render_log_page']
        );
    }

    public static function render_discount_form(){
        require_once plugin_dir_path(__FILE__) . "views/set-discount-page.php";
    }

    public static function render_log_page(){
        require_once plugin_dir_path(__FILE__) . "views/log-page.php";
    }
}