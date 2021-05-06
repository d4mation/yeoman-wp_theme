<?php
/**
 * Front Page Extra Meta
 *
 * @since   {{VERSION}}
 * @package <%- pkgName %>
 * @subpackage  <%- pkgName %>/core
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'add_meta_boxes', '<%- pkgNameLowerCase -%>_front_page_featured_add_meta_box' );
add_action( 'do_meta_boxes', '<%- pkgNameLowerCase -%>_remove_front_page_metaboxes' );
add_action( 'init', '<%- pkgNameLowerCase -%>_remove_front_page_supports' );

function <%- pkgNameLowerCase -%>_remove_front_page_supports() {

    if ( is_admin() && 
        isset( $_REQUEST['post'] ) && 
        $_REQUEST['post'] == get_option( 'page_on_front' ) ) {

            remove_post_type_support( 'page', 'thumbnail' );

    }

}

function <%- pkgNameLowerCase -%>_remove_front_page_metaboxes() {
    
    if ( is_admin() && 
        isset( $_REQUEST['post'] ) && 
        $_REQUEST['post'] == get_option( 'page_on_front' ) ) {
    
        // "Attributes" Meta Box
        remove_meta_box( 'pageparentdiv', 'page', 'side' );

        // From that sidebar plugin
        remove_meta_box( 'simplepagesidebarsdiv', 'page', 'side' );
        
    }
    
}

function <%- pkgNameLowerCase -%>_front_page_featured_add_meta_box() {

	global $post;

	if ( $post->post_type !== 'page' ) {
		return;
    }

    if ( ! isset( $_REQUEST['post'] ) || $_REQUEST['post'] !== get_option( 'page_on_front' ) ) {
        return;
    }
    
    if ( ! <%- pkgNameLowerCase -%>_fieldhelpers() ) {
        return;
    }

    add_filter( 'rbm_fieldhelpers_load_select2', '__return_true' );
    
}