<?php
/**
 * Change the class for sticky posts to .wp-sticky to avoid conflicts with Foundation's Sticky plugin
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

if ( ! function_exists( '<%- pkgNameLowerCase -%>_sticky_posts' ) ) :
	function <%- pkgNameLowerCase -%>_sticky_posts( $classes ) {
		if ( in_array( 'sticky', $classes, true ) ) {
			$classes   = array_diff( $classes, array( 'sticky' ) );
			$classes[] = 'wp-sticky';
		}
		return $classes;
	}
	add_filter( 'post_class', '<%- pkgNameLowerCase -%>_sticky_posts' );

endif;
