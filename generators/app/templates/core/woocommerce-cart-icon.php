<?php
/**
 * Adds a Cart Icon to the Nav
 *
 * @since   {{VERSION}}
 * @package <%- pkgName %>
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

add_filter( 'woocommerce_add_to_cart_fragments', '<%- pkgNameLowerCase -%>_update_add_to_cart' );

function <%- pkgNameLowerCase -%>_update_add_to_cart( $fragments ) {

    ob_start();

    get_template_part( 'template-parts/cart', 'icon' );

    $fragments['li.cart-contents.menu-item'] = ob_get_clean();

    return $fragments;

}