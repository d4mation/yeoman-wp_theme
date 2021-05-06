<?php
/**
 * Register widget areas
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

if ( ! function_exists( '<%- pkgNameLowerCase -%>_sidebar_widgets' ) ) :
	function <%- pkgNameLowerCase -%>_sidebar_widgets() {

		register_sidebar(
			array(
				'id'            => 'sidebar-widgets',
				'name'          => __( 'Sidebar widgets', '<%- textDomain -%>' ),
				'description'   => __( 'Drag widgets to this sidebar container.', '<%- textDomain -%>' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h5 class="widget-title">',
				'after_title'   => '</h5>',
			)
		);

		register_sidebar(
			array(
				'id'            => 'course-sidebar',
				'name'          => __( 'Course Sidebar', '<%- textDomain -%>' ),
				'description'   => __( 'Drag widgets to this sidebar container.', '<%- textDomain -%>' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h5 class="widget-title">',
				'after_title'   => '</h5>',
			)
		);

		$column_count = get_theme_mod( '<%- pkgNameLowerCase -%>_footer_column_count', 4 );

		for ( $index = 0; $index < $column_count; $index++ ) {

			register_sidebar(
				array(
					'id'            => 'footer-widgets-' . $index,
					'name'          => sprintf( __( 'Footer column #%d widgets', '<%- textDomain -%>' ), $index + 1 ),
					'description'   => __( 'Drag widgets to this footer container', '<%- textDomain -%>' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h5 class="widget-title">',
					'after_title'   => '</h5>',
				)
			);

		}

	}

	add_action( 'widgets_init', '<%- pkgNameLowerCase -%>_sidebar_widgets' );
endif;
