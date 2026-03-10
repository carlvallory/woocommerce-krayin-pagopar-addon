<?php
/**
 * Plugin Name: WooCommerce Krayin CRM - Pagopar Addon
 * Plugin URI: https://github.com/carlvallory/woocommerce-krayin-pagopar-addon
 * Description: Addon para WooCommerce Krayin CRM. Detecta y guarda el medio de pago específico de Pagopar (ej: Tarjeta, QR) basándose en las notas del pedido.
 * Version: 1.0.0
 * Author: Carlos Vallory
 * Author URI: https://github.com/carlvallory
 * License: GPL v2 or later
 * Text Domain: wc-krayin-pagopar-addon
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

class WC_Krayin_Pagopar_Addon {

    /**
     * Initialize the plugin.
     */
    public static function init() {
        // Hook into order note added
        add_filter('woocommerce_order_note_added', array(__CLASS__, 'check_pagopar_payment_method_in_note'), 10, 2);
    }

    /**
     * Check if the added note contains Pagopar payment method info.
     *
     * @param int $comment_id The comment ID.
     * @param WC_Order $order The order object.
     */
    public static function check_pagopar_payment_method_in_note($comment_id, $order) {
        if (!$order) {
            return $comment_id;
        }

        $comment = get_comment($comment_id);
        if (!$comment) {
            return $comment_id;
        }

        $note_content = $comment->comment_content;

        // Check for "Forma de Pago:" string
        // The Pagopar plugin adds: "Forma de Pago: " . $method . "\n"
        if (strpos($note_content, 'Forma de Pago:') !== false) {
            
            // Extract the payment method using Regex
            if (preg_match('/Forma de Pago:\s*(.*?)(\n|$)/', $note_content, $matches)) {
                $payment_method = trim($matches[1]);

                if (!empty($payment_method)) {
                    // Update order meta using update_post_meta to avoid triggering full order save hooks/webhooks
                    update_post_meta($order->get_id(), '_pagopar_payment_method', $payment_method);
                }
            }
        }
        
        return $comment_id; // Filter should return the ID
    }
}

// Initialize the plugin
add_action('plugins_loaded', array('WC_Krayin_Pagopar_Addon', 'init'));
