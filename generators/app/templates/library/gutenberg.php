<?php

if ( ! function_exists( '<%- pkgNameLowerCase -%>_gutenberg_support' ) ) :
	function <%- pkgNameLowerCase -%>_gutenberg_support() {

    // Add foundation color palette to the editor
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => __( 'Primary Color', '<%- textDomain -%>' ),
            'slug' => 'primary',
            'color' => '#1779ba',
        ),
        array(
            'name' => __( 'Secondary Color', '<%- textDomain -%>' ),
            'slug' => 'secondary',
            'color' => '#767676',
        ),
        array(
            'name' => __( 'Success Color', '<%- textDomain -%>' ),
            'slug' => 'success',
            'color' => '#3adb76',
        ),
        array(
            'name' => __( 'Warning color', '<%- textDomain -%>' ),
            'slug' => 'warning',
            'color' => '#ffae00',
        ),
        array(
            'name' => __( 'Alert color', '<%- textDomain -%>' ),
            'slug' => 'alert',
            'color' => '#cc4b37',
        )
    ) );

	}

	add_action( 'after_setup_theme', '<%- pkgNameLowerCase -%>_gutenberg_support' );
endif;
