<?php

if (!defined('ABSPATH')) exit;

// Logic to save discount values
if(isset($_POST['custom_discount_nonce']) && wp_verify_nonce($_POST['custom_discount_nonce'], 'save_discount')){
    update_option('discount_percentage', $_POST['new_discount']);
    update_option('min_total', $_POST['new_min']);
    update_option('is_active_discount', isset($_POST['new_active']) ? '1' : '0');
    print('Saved values: ' .$_POST['new_discount'] .'-' .$_POST['new_min']);
}

$discount = floatval(get_option('discount_percentage', 0));
$min_value = floatval(get_option('min_total', 0));
$is_active = get_option('is_active_discount', '0') === '1';
?>

<!-- HTML form -->
<div class="wrap">
    <h1>Descuentos Personalizables</h1>
    <form method="post">
        <?php wp_nonce_field('save_discount', 'custom_discount_nonce')?>
        <table class="form-table">
            <tr><th>Descuento a aplicar</th><th>Mínimo Total</th><th>Activo</th></tr>
            <td><input type="number" name="new_discount" value="<?php echo esc_attr($discount)?>"></td>
            <td><input type="number" name="new_min" value="<?php echo esc_attr($min_value)?>"></td>
            <td><input type="checkbox" name="new_active" value="1" <?php checked($is_active)?>></td>
        </table>
        <?php submit_button('Actualizar')?>
    </form>
</div>