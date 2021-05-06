<?php
/**
 * Allow users to select Topbar or Offcanvas menu. Adds body class of offcanvas or topbar based on which they choose.
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

add_action( 'customize_register', function( $wp_customize ) {

	if ( class_exists( '\Kirki\Control\Editor' ) ) {
		$wp_customize->register_control_type( '\Kirki\Control\Editor' );
	}

} );

if ( ! function_exists( 'wpt_register_theme_customizer' ) ) :
	function wpt_register_theme_customizer( $wp_customize ) {

		// Create custom panels
		$wp_customize->add_panel(
			'<%- pkgNameLowerCase -%>_elearning_settings', array(
				'priority'       => 1000,
				'theme_supports' => '',
				'title'          => __( 'KMCU Theme Settings', '<%- textDomain -%>' ),
				'description'    => __( 'Holds configuration specific to our Theme', '<%- textDomain -%>' ),
			)
		);

		// Create custom field for mobile navigation layout
		$wp_customize->add_section( 'product_settings', array(
			'title' => __( 'Global Product Settings', '<%- textDomain -%>' ),
			'panel' => '<%- pkgNameLowerCase -%>_elearning_settings',
		) );

		$wp_customize->add_section( 'footer_settings', array(
			'title' => __( 'Footer Settings', '<%- textDomain -%>' ),
			'panel' => '<%- pkgNameLowerCase -%>_elearning_settings',
		) );

		$wp_customize->add_section( 'social_media_settings', array(
			'title' => __( 'Social Media Links', '<%- textDomain -%>' ),
			'panel' => '<%- pkgNameLowerCase -%>_elearning_settings',
		) );

		$query = new WP_Query( array(
			'post_type' => 'product',
			'posts_per_page' => -1,
		) );

		$options = array();

		if ( $query->have_posts() ) {
			$options = wp_list_pluck( $query->posts, 'post_title', 'ID' );
		}

		$wp_customize->add_setting(
			'<%- pkgNameLowerCase -%>_discovery_consultation_product',
			array(
				'default' => '',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'<%- pkgNameLowerCase -%>_discovery_consultation_product',
				array(
					'type'     => 'select',
					'section'  => 'product_settings',
					'label' => __( 'Discovery Consultation Product', '<%- textDomain -%>' ),
					'settings' => '<%- pkgNameLowerCase -%>_discovery_consultation_product',
					'choices' => array( '' => __( 'Select a Product', '<%- textDomain -%>' ) ) + $options, 
				)
			)
		);

		$wp_customize->add_setting(
			'<%- pkgNameLowerCase -%>_footer_below_title',
			array(
				'default' => '<p style="font-size: 22px"><a href="tel:8558326562"><strong>(855) TEAM KMC</strong></a></p><p><a href="tel:8558326562">(855) 382-6562</a></p>',
			)
		);

		$wp_customize->add_control(
			new \Kirki\Control\Editor(
				$wp_customize,
				'<%- pkgNameLowerCase -%>_footer_below_title',
				array(
					'section'  => 'footer_settings',
					'label' => __( 'Below Site Name', '<%- textDomain -%>' ),
					'settings' => '<%- pkgNameLowerCase -%>_footer_below_title',
				)
			)
		);

		$wp_customize->add_setting(
			'<%- pkgNameLowerCase -%>_facebook_link',
			array(
				'default' => '',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'<%- pkgNameLowerCase -%>_facebook_link',
				array(
					'type'     => 'text',
					'section'  => 'social_media_settings',
					'label' => __( 'Facebook Link', '<%- textDomain -%>' ),
					'settings' => '<%- pkgNameLowerCase -%>_facebook_link',
				)
			)
		);

		$wp_customize->add_setting(
			'<%- pkgNameLowerCase -%>_youtube_link',
			array(
				'default' => '',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'<%- pkgNameLowerCase -%>_youtube_link',
				array(
					'type'     => 'text',
					'section'  => 'social_media_settings',
					'label' => __( 'YouTube Link', '<%- textDomain -%>' ),
					'settings' => '<%- pkgNameLowerCase -%>_youtube_link',
				)
			)
		);

	}

	add_action( 'customize_register', 'wpt_register_theme_customizer' );

	// Add class to body to help w/ CSS
	add_filter( 'body_class', 'mobile_nav_class' );
	function mobile_nav_class( $classes ) {
		$classes[] = 'offcanvas';
		return $classes;
	}
endif;

// This wasn't getting loaded for some reason?
add_action( 'customize_controls_enqueue_scripts', function() {

	wp_enqueue_script( 'wp-hooks' );

}, 1 );