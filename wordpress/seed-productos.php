<?php
/**
 * Script para crear productos dummy de WooCommerce
 * Acceder una sola vez desde: http://localhost:8080/seed-productos.php
 */

define('ABSPATH_CHECK', true);
require_once __DIR__ . '/wp-load.php';

if (!class_exists('WooCommerce')) {
    die('WooCommerce no está activo.');
}

$productos = [
    [
        'name'          => 'Camiseta Básica',
        'price'         => 20000,
        'description'   => 'Camiseta de algodón 100%, disponible en varios colores.',
        'category'      => 'Ropa',
        'sku'           => 'CAM-001',
    ],
    [
        'name'          => 'Pantalón Casual',
        'price'         => 45000,
        'description'   => 'Pantalón casual cómodo para uso diario.',
        'category'      => 'Ropa',
        'sku'           => 'PAN-001',
    ],
    [
        'name'          => 'Audífonos Bluetooth',
        'price'         => 80000,
        'description'   => 'Audífonos inalámbricos con cancelación de ruido.',
        'category'      => 'Tecnología',
        'sku'           => 'AUD-001',
    ],
    [
        'name'          => 'Teclado Mecánico',
        'price'         => 120000,
        'description'   => 'Teclado mecánico retroiluminado RGB.',
        'category'      => 'Tecnología',
        'sku'           => 'TEC-001',
    ],
    [
        'name'          => 'Mochila Urbana',
        'price'         => 55000,
        'description'   => 'Mochila resistente con compartimento para laptop.',
        'category'      => 'Accesorios',
        'sku'           => 'MOC-001',
    ],
    [
        'name'          => 'Botella Térmica',
        'price'         => 25000,
        'description'   => 'Botella de acero inoxidable, mantiene temperatura 12 horas.',
        'category'      => 'Accesorios',
        'sku'           => 'BOT-001',
    ],
];

$creados = [];
$errores = [];

foreach ($productos as $data) {

    // Crear o reutilizar categoría
    $cat_id = null;
    $term   = get_term_by('name', $data['category'], 'product_cat');
    if ($term) {
        $cat_id = $term->term_id;
    } else {
        $new_term = wp_insert_term($data['category'], 'product_cat');
        if (!is_wp_error($new_term)) {
            $cat_id = $new_term['term_id'];
        }
    }

    // Verificar si ya existe el SKU
    $existing_id = wc_get_product_id_by_sku($data['sku']);
    if ($existing_id) {
        $errores[] = "⚠️ SKU ya existe, omitido: {$data['name']} ({$data['sku']})";
        continue;
    }

    // Crear producto
    $product = new WC_Product_Simple();
    $product->set_name($data['name']);
    $product->set_status('publish');
    $product->set_description($data['description']);
    $product->set_short_description($data['description']);
    $product->set_regular_price($data['price']);
    $product->set_sku($data['sku']);
    $product->set_manage_stock(true);
    $product->set_stock_quantity(100);
    $product->set_stock_status('instock');

    if ($cat_id) {
        $product->set_category_ids([$cat_id]);
    }

    $product_id = $product->save();

    if ($product_id) {
        $creados[] = "#{$product_id} — {$data['name']} (\${$data['price']})";
    } else {
        $errores[] = "Error al crear: {$data['name']}";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seed Productos</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 40px auto; padding: 0 20px; }
        h2   { color: #333; }
        li   { margin: 6px 0; }
        .warn { color: #e67e22; }
        .ok   { color: #27ae60; }
        .err  { color: #e74c3c; }
        .box  { background: #fff3cd; border: 1px solid #ffc107; padding: 12px 16px; border-radius: 6px; margin-top: 24px; }
    </style>
</head>
<body>
    <h2>🛒 Seed de Productos WooCommerce</h2>

    <?php if ($creados): ?>
        <h3 class="ok">Productos creados (<?= count($creados) ?>)</h3>
        <ul><?php foreach ($creados as $msg) echo "<li class='ok'>$msg</li>"; ?></ul>
    <?php endif; ?>

    <?php if ($errores): ?>
        <h3 class="warn">Avisos</h3>
        <ul><?php foreach ($errores as $msg) echo "<li class='warn'>$msg</li>"; ?></ul>
    <?php endif; ?>

    <div class="box">
        ⚠️ <strong>Recuerda eliminar este archivo</strong> una vez que ya no lo necesites:<br>
        <code>wordpress/seed-productos.php</code>
    </div>
</body>
</html>
