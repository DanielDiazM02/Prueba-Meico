<?php

if (!defined('ABSPATH')) exit;

function register_discount($cart){

    $user = wp_get_current_user();
    if (!in_array('cliente_vip', Array($user->roles))) return;

    $discount = floatval(get_option('discount_percentage', 0));
    $min_total = floatval(get_option('min_total', 0));
    $is_active = boolval(get_option('is_active_discount', false));

    if ($discount <= 0 || $min_total <= 0 || !$is_active) return;

    $cart_total = floatval($cart->total);
    if ($min_total > $cart_total) return;

    $total_discount = $cart_total * $discount / 100;
    $cart->add_fee('Descuento Especial', -$total_discount, false);
}

add_action('woocommerce_after_calculate_totals', 'register_discount');