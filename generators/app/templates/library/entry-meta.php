<?php
/**
 * Entry meta information for posts
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

if ( ! function_exists( '<%- pkgNameLowerCase -%>_entry_meta' ) ) :
	function <%- pkgNameLowerCase -%>_entry_meta() {

		if ( function_exists( 'learndash_get_post_types' ) && in_array( get_post_type(), learndash_get_post_types() ) ) return;

		/* translators: %1$s: current date, %2$s: current time */
		echo '<time class="updated" datetime="' . get_the_time( 'c' ) . '">' . get_the_date() . '</time>';

	}
endif;
