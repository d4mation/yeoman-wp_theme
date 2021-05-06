<?php
/**
 * Configure responsive images sizes
 *
 * @package WordPress
 * @subpackage <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

// Add featured image sizes
//
// Sizes are optimized and cropped for landscape aspect ratio
// and optimized for HiDPI displays on 'small' and 'medium' screen sizes.
add_image_size( 'featured-small', 640, 200, true ); // name, width, height, crop
add_image_size( 'featured-medium', 1280, 400, true );
add_image_size( 'featured-large', 1440, 400, true );
add_image_size( 'featured-xlarge', 1920, 400, true );

// Add additional image sizes
add_image_size( 'fp-small', 640 );
add_image_size( 'fp-medium', 1024 );
add_image_size( 'fp-large', 1200 );
add_image_size( 'fp-xlarge', 1920 );

// Register the new image sizes for use in the add media modal in wp-admin
function <%- pkgNameLowerCase -%>_custom_sizes( $sizes ) {
	return array_merge(
		$sizes, array(
			'fp-small'  => __( 'FP Small' ),
			'fp-medium' => __( 'FP Medium' ),
			'fp-large'  => __( 'FP Large' ),
			'fp-xlarge' => __( 'FP XLarge' ),
		)
	);
}
add_filter( 'image_size_names_choose', '<%- pkgNameLowerCase -%>_custom_sizes' );

// Add custom image sizes attribute to enhance responsive image functionality for content images
function <%- pkgNameLowerCase -%>_adjust_image_sizes_attr( $sizes, $size ) {

	// Actual width of image
	$width = $size[0];

	// Full width page template
	if ( is_page_template( 'page-templates/page-full-width.php' ) ) {
		if ( 1200 < $width ) {
			$sizes = '(max-width: 1199px) 98vw, 1200px';
		} else {
			$sizes = '(max-width: 1199px) 98vw, ' . $width . 'px';
		}
	} else { // Default 3/4 column post/page layout
		if ( 770 < $width ) {
			$sizes = '(max-width: 639px) 98vw, (max-width: 1199px) 64vw, 770px';
		} else {
			$sizes = '(max-width: 639px) 98vw, (max-width: 1199px) 64vw, ' . $width . 'px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', '<%- pkgNameLowerCase -%>_adjust_image_sizes_attr', 10, 2 );

// Remove inline width and height attributes for post thumbnails
function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	if ( ! strpos( $html, 'attachment-shop_single' ) ) {
		$html = preg_replace( '/^(width|height)=\"\d*\"\s/', '', $html );
	}
	return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

/**
 * Generates an Interchange Attribute
 *
 * @param   [type]  $attachment_id  [$attachment_id description]
 *
 * @return  [type]                  [return description]
 */
function <%- pkgNameLowerCase -%>_get_interchange_attribute( $attachment_id, $sizes = array() ) {

	$sizes = wp_parse_args( $sizes, array(
		'featured-small' => 'small',
		'featured-medium' => 'medium',
		'featured-large' => 'large',
		'featured-xlarge' => 'xlarge',
	) );

	$images = array();

	foreach ( $sizes as $image_size => $breakpoint ) {

		$image = wp_get_attachment_image_src( $attachment_id, $image_size );

		if ( $image ) {
			$images[ $breakpoint ] = $image[0];
		}

	}

	$interchange_string = 'data-interchange="';

	$index = 0;
	foreach ( $images as $breakpoint => $url ) {

		$interchange_string .= '[' . $url . ', ' . $breakpoint . ']';

		if ( $index > 0 && $index !== ( count( $images ) - 1 ) ) {
			$interchange_string .= ',';
		}

		$index++;

	}

	$interchange_string .= '"';

	return $interchange_string;

	return $interchange_string;

}