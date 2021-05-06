<?php
/**
 * Adjust how the My Account page renders
 *
 * @since   {{VERSION}}
 * @package <%- pkgName %>
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

add_filter( 'the_title', '<%- pkgNameLowerCase -%>_adjust_page_title_for_my_account', 10, 2 );

/**
 * Adjust the Page Title for the My Account Page
 *
 * @param   string   $title    Post Title
 * @param   integer  $post_id  WP_Post ID
 *
 * @since   {{VERSION}}
 * @return  string             Post Title
 */
function <%- pkgNameLowerCase -%>_adjust_page_title_for_my_account( $title, $post_id ) {

    if ( $post_id !== (int) get_option('woocommerce_myaccount_page_id') ) return $title;

    if ( is_user_logged_in() ) return $title;

    return __( 'Sign Up', '<%- textDomain -%>' );

}

add_filter( 'document_title_parts', '<%- pkgNameLowerCase -%>_adjust_title_tag_for_my_account' );

/**
 * Adjust the Title Tag for the My Account Page
 *
 * @param   array  $title_parts  Document Title Parts Array
 *
 * @since   {{VERSION}}
 * @return  array                Document Title Parts Array
 */
function <%- pkgNameLowerCase -%>_adjust_title_tag_for_my_account( $title_parts ) {

    if ( get_the_ID() !== (int) get_option('woocommerce_myaccount_page_id') ) return $title_parts;

    if ( is_user_logged_in() ) return $title_parts;

    $title_parts['title'] = __( 'Sign Up', '<%- textDomain -%>' );

    return $title_parts;

}

add_action( 'woocommerce_account_page_endpoint', '<%- pkgNameLowerCase -%>_hide_woocommerce_my_account_dashboard' );

function <%- pkgNameLowerCase -%>_hide_woocommerce_my_account_dashboard() {
    // Do nothing
}

function woocommerce_account_navigation() {
    // Do nothing
}