<?php
/**
 * Enqueue all styles and scripts
 *
 * Learn more about enqueue_script: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_script}
 * Learn more about enqueue_style: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_style }
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */


// Check to see if rev-manifest exists for CSS and JS static asset revisioning
//https://github.com/sindresorhus/gulp-rev/blob/master/integration.md

if ( ! function_exists( '<%- pkgNameLowerCase -%>_asset_path' ) ) :
	function <%- pkgNameLowerCase -%>_asset_path( $filename ) {
		$filename_split = explode( '.', $filename );
		$dir            = end( $filename_split );
		$manifest_path  = dirname( dirname( __FILE__ ) ) . '/dist/assets/' . $dir . '/rev-manifest.json';

		if ( file_exists( $manifest_path ) ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true );
		} else {
			$manifest = array();
		}

		if ( array_key_exists( $filename, $manifest ) ) {
			return $manifest[ $filename ];
		}
		return $filename;
	}
endif;


if ( ! function_exists( '<%- pkgNameLowerCase -%>_scripts' ) ) :
	function <%- pkgNameLowerCase -%>_scripts() {

		// Enqueue the main Stylesheet.
		wp_enqueue_style( 
			'main-stylesheet', 
			get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'app.css' ), 
			array(), 
			( defined( 'WP_DEBUG' ) && WP_DEBUG == true ) ? time() : THEME_VER, 
			'all'
		 );

		// Deregister the jquery version bundled with WordPress.
		//wp_deregister_script( 'jquery' );

		// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
		//wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', false );

		// Deregister the jquery-migrate version bundled with WordPress.
		//wp_deregister_script( 'jquery-migrate' );

		// CDN hosted jQuery migrate for compatibility with jQuery 3.x
		//wp_register_script( 'jquery-migrate', '//code.jquery.com/jquery-migrate-3.0.1.min.js', array('jquery'), '3.0.1', false );

		// Enqueue jQuery migrate. Uncomment the line below to enable.
		// wp_enqueue_script( 'jquery-migrate' );

		// Enqueue Foundation scripts
		wp_enqueue_script( 
			'foundation', 
			get_stylesheet_directory_uri() . '/dist/assets/js/' . <%- pkgNameLowerCase -%>_asset_path( 'app.js' ), 
			array( 'jquery' ), 
			( defined( 'WP_DEBUG' ) && WP_DEBUG == true ) ? time() : THEME_VER, 
			true 
		);

		// Enqueue FontAwesome from CDN. Uncomment the line below if you need FontAwesome.
		//wp_enqueue_script( 'fontawesome', 'https://use.fontawesome.com/5016a31c8c.js', array(), '4.7.0', true );

		// Add the comment-reply library on pages where it is necessary
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	add_action( 'wp_enqueue_scripts', '<%- pkgNameLowerCase -%>_scripts' );
endif;

add_action( 'admin_enqueue_scripts', '<%- pkgNameLowerCase -%>_elearning_admin_scripts' );

function <%- pkgNameLowerCase -%>_elearning_admin_scripts() {

	wp_enqueue_style( 
		'admin-stylesheet', 
		get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'admin.css' ), 
		array(), 
		( defined( 'WP_DEBUG' ) && WP_DEBUG == true ) ? time() : THEME_VER, 
		'all'
	);

	wp_enqueue_script( 
		'admin-script', 
		get_stylesheet_directory_uri() . '/dist/assets/js/' . <%- pkgNameLowerCase -%>_asset_path( 'admin.js' ), 
		array(), 
		( defined( 'WP_DEBUG' ) && WP_DEBUG == true ) ? time() : THEME_VER, 
		'all'
	);

}

add_filter( '<%- pkgNameLowerCase -%>_hr_dashboard_frontend_css_src', function( $src ) {

	return get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'hr-dashboard.css' );

} );

add_filter( 'ld_gb_frontend_gradebook_style_src', function( $src ) {

	return get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'learndash-gradebook.css' );

} );

add_filter( 'rbm_ld_group_registration_shortcode_css_src', function( $src ) {

	return get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'group-registration.css' );

} );

add_filter( 'rbm_ld_group_registration_frontend_css_src', function( $src ) {

	return get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'group-registration-frontend.css' );

} );

add_filter( 'rbm_reviews_for_learndash_frontend_css_src', function( $src ) {

	return get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'reviews.css' );

} );

add_action( 'login_enqueue_scripts', function() {

	wp_enqueue_style( 
		'kmcu-login', 
		get_stylesheet_directory_uri() . '/dist/assets/css/' . <%- pkgNameLowerCase -%>_asset_path( 'login.css' ),
		array(),
		( defined( 'WP_DEBUG' ) && WP_DEBUG == true ) ? time() : THEME_VER, 
		'all'
	);

} );

add_action( 'gform_pre_enqueue_scripts', function() {

	wp_enqueue_script( 
		'kmcu-gravity-forms', 
		get_stylesheet_directory_uri() . '/dist/assets/js/' . <%- pkgNameLowerCase -%>_asset_path( 'gravity-forms.js' ), 
		array( 'jquery' ), 
		( defined( 'WP_DEBUG' ) && WP_DEBUG == true ) ? time() : THEME_VER, 
		'all'
	);

} );