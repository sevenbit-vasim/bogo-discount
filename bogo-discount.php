<?php
/*
Plugin Name: Buy One Get One Free (BOGO) Discount
Description: Automatically applies a BOGO discount for every second item in the cart.
Version: 1.0
Author: Your Name or Organization
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('woocommerce_cart_calculate_fees', 'bogo_discount');

function bogo_discount() {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    $cart = WC()->cart;

    // Reset discount amount
    $discount = 0;

    // Check if there are items in the cart
    if ($cart->is_empty()) {
        return;
    }

    // Loop through cart items
    foreach ($cart->get_cart() as $cart_item) {
        $product_quantity = $cart_item['quantity'];

        // Apply BOGO discount for every second item
        $discount += floor($product_quantity / 2);
    }

    // Calculate the total discount amount
    $discount_amount = $discount * $cart->get_cart_contents_total();

    // Apply discount
    if ($discount_amount > 0) {
        $cart->add_fee('BOGO Discount', -$discount_amount);
    }
}
