<?php
/**
 * Rearranges the Checkout page
 * 
 * WooCommerce does not support making the changes that we want without modifying their template files, but I really do not want to do that
 * 
 * Doing it this way should allow us to not need update this code unless WooCommerce makes some major changes
 *
 * @since   {{VERSION}}
 * @package <%- pkgName %>
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

add_filter( 'template_include', '<%- pkgNameLowerCase -%>_woocommerce_checkout_start', PHP_INT_MAX );

/**
 * Start the object buffer if needed
 *
 * @param   string  $template  Template file
 *
 * @since   {{VERSION}}
 * @return  string             Template file
 */
function <%- pkgNameLowerCase -%>_woocommerce_checkout_start( $template ) {

    if ( is_checkout() ) {
        ob_start();
    }

    return $template;

}

add_action( 'shutdown', '<%- pkgNameLowerCase -%>_woocommerce_checkout_end', 0 );

/**
 * End the object buffer and rearrange the page
 * 
 * @since   {{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_woocommerce_checkout_end() {

    if ( ! is_checkout() ) return;

    $page_html = ob_get_clean();

    $match = preg_match( '/<form.*?name="checkout".*?(<div.*?id="customer_details".*?>[\s\S]*?)<h\d\sid="order_review_heading"/si', $page_html, $matches );

    if ( $match && isset( $matches[1] ) && $matches[1] ) {

        // Remove original location
        $page_html = str_replace( $matches[1], '', $page_html );

        // Move after Order table
        $page_html = preg_replace( '/<table.*?class="shop_table[\s|\S]*?<\/table>/sim', '$0' . $matches[1], $page_html );

    }

    echo $page_html;

}

add_action( '<%- pkgNameLowerCase -%>_before_page_title', function() {

    if ( get_the_ID() !== wc_get_page_id( 'checkout' ) ) return;

    global $wp;

    if ( ! isset( $wp->query_vars['order-received'] ) ) return;

    add_filter( 'the_title', '<%- pkgNameLowerCase -%>_thank_you_page_title' );

} );

add_action( '<%- pkgNameLowerCase -%>_after_page_title', function() {

    if ( get_the_ID() !== wc_get_page_id( 'checkout' ) ) return;

    global $wp;

    if ( ! isset( $wp->query_vars['order-received'] ) ) return;

    remove_filter( 'the_title', '<%- pkgNameLowerCase -%>_thank_you_page_title' );

} );

/**
 * Adjust the Page Title for the Thank You page
 *
 * @param   string  $title  Page Title
 *
 * @since   {{VERSION}}
 * @return  string          Page Title
 */
function <%- pkgNameLowerCase -%>_thank_you_page_title( $title ) {

    return __( 'Order confirmed!', '<%- textDomain -%>' );

}