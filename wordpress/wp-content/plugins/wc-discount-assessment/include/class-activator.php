<?php

if (!defined('ABSPATH')) exit;

class Discount_Assesment_Activator {

    public static function activar() {
        
        // Añadir rol vip
        add_role('cliente_vip', 'Cliente VIP', ['read' => true]);    
        
        // Añadir función de ejecutar consultas
        global $wpdb;
        require_once ABSPATH . "wp-admin/includes/upgrade.php";
        $charset = $wpdb->get_charset_collate();

        // Creación tabla logs
        $sql = "CREATE TABLE {$wpdb->prefix}discount_log (
            id INT NOT NULL AUTO_INCREMENT,
            user_id BIGINT NOT NULL,
            order_id BIGINT NOT NULL,
            discount_amount DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset";

        dbDelta($sql);
    }
}