<?php
/**
 * Rearranges the Product Single page
 *
 * @since   {{VERSION}}
 * @package <%- pkgName %>
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

add_filter( 'body_class', '<%- pkgNameLowerCase -%>_adjust_body_class_for_product_single' );

function <%- pkgNameLowerCase -%>_adjust_body_class_for_product_single( $body_classes ) {

    if ( get_post_type() !== 'product' ) return $body_classes;

    $product = wc_get_product( get_the_ID() );

    if ( ! $product->get_image_id() ) {
        $body_classes[] = 'no-featured-image';
    }

    return $body_classes;

}

add_action( 'woocommerce_before_single_product_summary', '<%- pkgNameLowerCase -%>_maybe_remove_product_featured_image_from_single', 1 );

/**
 * If there is no featured image, don't show a location for it on Product Single
 *
 * @since   {{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_maybe_remove_product_featured_image_from_single() {

    $product = wc_get_product( get_the_ID() );

    if ( ! $product->get_image_id() ) {
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    }
  
}

add_action( 'woocommerce_single_product_summary', '<%- pkgNameLowerCase -%>_move_content_above_add_to_cart_form', 1 );

/**
 * Put the Product Content above the Add to Cart form
 *
 * @since   {{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_move_content_above_add_to_cart_form() {

    the_content();

}

add_filter( 'woocommerce_product_tabs', '<%- pkgNameLowerCase -%>_remove_description_tab_from_product_single', 11 );

/**
 * Remove the Description Tab since we have moved it above the Add to Cart form
 *
 * @param   array  $tabs  Tabs
 *
 * @since   {{VERSION}}
 * @return  array         Tabs
 */
function <%- pkgNameLowerCase -%>_remove_description_tab_from_product_single( $tabs ) {

    if ( isset( $tabs['description'] ) ) {
        unset( $tabs['description'] );
    }

    return $tabs;

}

add_action( 'woocommerce_after_single_product_summary', '<%- pkgNameLowerCase -%>_add_course_listing_for_product', 11 );

/**
 * Add Course Listing to the Product
 *
 * @since   {{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_add_course_listing_for_product() {

    $courses = get_post_meta( get_the_ID(), '_related_course', true );

    if ( empty( $courses ) ) return;

    $template = locate_template( 'template-parts/product-courses.php', false, false );

    if ( $template ) {
        // This lets us have access to $courses without needing to do any nasty global stuff
        include $template;
    }

}

/*
function woocommerce_related_products() {
    // Remove Related Products Output
}
*/

/**
 * Change the header text for Related Products
 *
 * @param   string  $text  Header Text
 *
 * @since   {{VERSION}}
 * @return  string         Header Text
 */
add_filter( 'woocommerce_product_related_products_heading', function( $text ) {

    return __( 'You may also like:', '<%- textDomain -%>' );

} );

/**
 * Add an "All Products" button after the Related Products header
 *
 * @param   string  $output  HTML Output
 *
 * @since   {{VERSION}}
 * @return  string           HTML Output
 */
add_filter( 'woocommerce_product_loop_start', function( $output ) {

    if ( ! is_singular( 'product' ) ) return $output;

    if ( wc_get_loop_prop( 'name' ) !== 'related' ) return $output;

    ob_start();

    ?>

    <a class="button secondary alignright" href="<?php echo wc_get_page_permalink( 'shop' ); ?>">
        <?php _e( 'All Products', '<%- textDomain -%>' ); ?>
    </a>

    <?php

    $button = ob_get_clean();

    return $button . $output;

} );

/**
 * Set columns for related products to 3
 *
 * @param   integer  $columns  Related Products Column count
 *
 * @since   {{VERSION}}
 * @return  integer            Related Products Column count
 */
add_filter( 'woocommerce_related_products_columns', function( $columns ) {

    return 3;

} );

/**
 * Similarly restrict the maximum output of Related Products to 3
 *
 * @param   array  $args  WP_Query Args
 *
 * @since   {{VERSION}}
 * @return  array         WP_Query Args
 */
add_filter( 'woocommerce_output_related_products_args', function( $args ) {

    $args['posts_per_page'] = 3;

    return $args;

} );

// Remove featured image from loops for Products
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

/**
 * Add the excerpt to product loop output above pricing
 * 
 * @since   {{VERSION}}
 * @return  void
 */
add_action( 'woocommerce_after_shop_loop_item_title', function() {

    add_filter( 'excerpt_length', '<%- pkgNameLowerCase -%>_cell_excerpt_length' );

    the_excerpt();

    remove_filter( 'excerpt_length', '<%- pkgNameLowerCase -%>_cell_excerpt_length' );

}, 1 );

/**
 * Disable Comments for Products
 *
 * @param   boolean  $open     Comments Open state
 * @param   integer  $post_id  Post ID
 *
 * @since   {{VERSION}}
 * @return  boolean            Comments Open state
 */
add_filter( 'comments_open', function( $open, $post_id ) {

    if ( get_post_type( $post_id ) == 'product' ) return false;

    return $open;

}, 10, 2 );

add_action( 'woocommerce_product_meta_start', function() {

    add_filter( 'term_links-product_cat', '<%- pkgNameLowerCase -%>_remove_product_terms_output' );
    add_filter( 'term_links-product_tag', '<%- pkgNameLowerCase -%>_remove_product_terms_output' );

} );

add_action( 'woocommerce_product_meta_end', function() {

    remove_filter( 'term_links-product_cat', '<%- pkgNameLowerCase -%>_remove_product_terms_output' );
    remove_filter( 'term_links-product_tag', '<%- pkgNameLowerCase -%>_remove_product_terms_output' );

} );

/**
 * Prevent WooCommerce from outputting Product Categories/Tags on Product Single
 *
 * @param   array  $term_links  Array of String Links
 *
 * @since   {{VERSION}}
 * @return  array               Array of String Links
 */
function <%- pkgNameLowerCase -%>_remove_product_terms_output( $term_links ) {

    return array();

}

/**
 * ...Why aren't they checking if their Term Output methods actually succeed before printing Category: or Tag: ?
 *
 * @param   string  $translation  Translated Text
 * @param   string  $singular     Singlular Text
 * @param   string  $plural       Plural Text
 * @param   integer $number       Number of items
 * @param   string  $domain       Text Domain
 *
 * @since   {{VERSION}}
 * @return  string                Translated Text
 */
add_filter( 'ngettext', function( $translation, $singular, $plural, $number, $domain ) {

    if ( $domain !== 'woocommerce' ) return $translation;

    if ( $singular !== 'Category:' && $singular !== 'Tag:' ) return $translation;

    return '';

}, 10, 5 );