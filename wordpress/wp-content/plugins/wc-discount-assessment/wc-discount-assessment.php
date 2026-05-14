<?php

/**
 * Plugin Name: WC-Discount-Assessment 
 * Description: An ecommerce toolkit that helps you with discounts. Beautifully.
 * Version: 1.0.0
 * Author: Daniel Diaz
 * Text Domain: woocommerce
 */


if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . "include/class-activator.php";
require_once plugin_dir_path(__FILE__) . "include/class-discount-engine.php";
require_once plugin_dir_path(__FILE__) . "include/class-discount-logger.php";
require_once plugin_dir_path(__FILE__) . "admin/admin-menu.php";

Admin_Menu::init();
register_activation_hook(__FILE__,['Discount_Assesment_Activator', 'activar']);