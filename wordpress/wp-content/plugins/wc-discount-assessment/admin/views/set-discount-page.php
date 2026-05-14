<?php

if (!defined('ABSPATH')) exit;


if(wp_nonce_field($_POST['custom_discount'], $_POST['discount'])){
    update_option('discount_percentage', $_POST['new_discount']);
    update_option('min_total', $_POST['new_min']);
    update_option('is_active_discount', $_POST['new_active']);
    print('Saved values: ' .$_POST['new_discount'] .'-' .$_POST['new_min']);
}

$discount = floatval(get_option('discount_percentage', 0));
$min_value = floatval(get_option('min_total', 0));
$is_active = boolval(get_option('$is_active_discount', false));
?>

<div class="wrap">
    <form method="post">
        <? wp_nonce_field('custom_discount', 'discount')?>
        <table>
            <tr><th>Descuento a aplicar</th><th>Mínimo Total</th><th>Activo</th></tr>
            <input type="number" name="new_discount" value= <? echo esc_attr($discount)?>>
            <input type="number" name="new_min" value= <? echo esc_attr($min_value)?>>
            <input type="checkbox" name="new_active" value= <? echo esc_attr($min_value)?>>
        </table>
        <? submit_button('Actualizar')?>
    </form>
</div>