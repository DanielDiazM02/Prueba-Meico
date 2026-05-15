<?php

if (!defined('ABSPATH')) exit;

function log_discount($order_id){

    $order = wc_get_order($order_id);
    foreach ($order->get_fees() as $fee) {
        if ($fee->get_name() === 'Descuento Especial') {
            global $wpdb;
            $wpdb->insert(
                $wpdb->prefix . "discount_log",
                [
                    "user_id" => intval($order->get_user_id()),
                    "order_id" => $order_id,
                    "discount_amount" => $fee->get_total()
                ]
            );
        }
    }
}

// This hook is chosen to include cash on delivery orders
add_action('woocommerce_thankyou', 'log_discount');