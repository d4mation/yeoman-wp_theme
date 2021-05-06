<?php

/**
 * Force the shop page to load a full-width template
 *
 * @param   string  $template  Template Path
 *
 * @since   {{VERSION}}
 * @return  string             Template Path
 */
add_filter( 'template_include', function( $template ) {

    if ( ! function_exists( 'wc_get_page_id' ) ) return $template;

    if ( get_the_ID() !== wc_get_page_id( 'shop' ) && ( ! is_a( get_queried_object(), 'WP_Term' ) || get_queried_object()->taxonomy !== 'product_cat' ) ) return $template;

    global $wp_query;

    // WooCommerce makes a fake "Page" and toggles this on even when it is an archive view
    $wp_query->is_single = false;

    return locate_template( 'page-templates/page-full-width.php', false, false );

}, 99 );

/**
 * There is a filter to change this value for every page but the main Shop template?
 * 
 * @since   {{VERSION}}
 * @return  void
 */
add_action( 'woocommerce_before_shop_loop', function() {

    wc_set_loop_prop( 'columns', 3 );

} );