<?php
/**
 * Some adjustments for the Cart page
 *
 * @since   {{VERSION}}
 * @package <%- pkgName %>
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Swap out some WooCommerce Labels
 *
 * @param   string  $translated_text  Translated Text
 * @param   string  $text             Original Text
 * @param   string  $domain           Text Domain
 *
 * @since   {{VERSION}}
 * @return  string                    Translated Text
 */
add_filter( 'gettext', function( $translated_text, $text, $domain ) {

    if ( $domain !== 'woocommerce' ) return $translated_text;

    if ( $text == 'Coupon:' || $text == 'Coupon code' ) {
        return __( 'Discount code', '<%- textDomain -%>' );
    }

    if ( $text == 'Apply coupon' ) {
        return __( 'Apply', '<%- textDomain -%>' );
    }

    return $translated_text;

}, 10, 3 );

/**
 * Add some text after the Discount Code field
 * 
 * @since   {{VERSION}}
 * @return void
 */
add_action( 'woocommerce_cart_coupon', function() {

    ?>

    <p class="description">
        <?php _e( 'Enter the discount code above and click "apply."', '<%- textDomain -%>' ); ?>
    </p>

    <?php

} );

/**
 * Adds Continue Shopping table under the Cart
 * 
 * @since   {{VERSION}}
 * @return  void
 */
add_action( 'woocommerce_after_cart_table', function() {

    ?>

    <a href="<?php echo esc_attr( wc_get_page_permalink( 'shop' ) ); ?>" class="button secondary continue-shopping">
        <?php _e( 'Continue Shopping', '<%- textDomain -%>' ); ?>
    </a>

    <?php

} );