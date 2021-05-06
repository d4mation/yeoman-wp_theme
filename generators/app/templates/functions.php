<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * <%- pkgName %> functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Make sure no theme constants are already defined (realistically, there should be no conflicts)
if ( defined( 'THEME_VER' ) ||
	defined( 'THEME_URI' ) ||
	defined( 'THEME_DIR' ) ) {
	wp_die( 'ERROR in <%- pkgName %> theme: There is a conflicting constant. Please either find the conflict or rename the constant.' );
}

/**
 * Define Constants based on our Stylesheet Header. Update things only once!
 */
$theme_header = wp_get_theme();

define( 'THEME_VER', $theme_header->get( 'Version' ) );
<% if (parentTheme == '') { %>define( 'THEME_URI', get_template_directory_uri() );<% } else { %>define( 'THEME_URI', get_stylesheet_directory_uri() );<% } %>
<% if (parentTheme == '') { %>define( 'THEME_DIR', get_template_directory() );<% } else { %>define( 'THEME_DIR', get_stylesheet_directory() );<% } %>

require_once THEME_DIR . 'vendor/autoload.php';

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Format comments */
require_once( 'library/class-foundationpress-comments.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/class-foundationpress-top-bar-walker.php' );
require_once( 'library/class-foundationpress-mobile-walker.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add Nav Options to Customer */
require_once( 'library/custom-nav.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

/** Gutenberg editor support */
require_once( 'library/gutenberg.php' );

// LearnDash
require_once( 'core/learndash-hooks.php' );

if ( function_exists( 'WC' ) ) {

	// WooCommerce 
	require_once( 'core/woocommerce-product-single.php' );
	require_once( 'core/woocommerce-checkout.php' );
	require_once( 'core/woocommerce-cart-icon.php' );
	require_once( 'core/woocommerce-my-account.php' );
	require_once( 'core/woocommerce-shop.php' );
	require_once( 'core/woocommerce-cart.php' );

}

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/class-foundationpress-protocol-relative-theme-assets.php' );

// Widgets
require_once( 'core/widget-adjustments.php' );

global $<%- pkgNameLowerCase -%>_field_helpers;
$<%- pkgNameLowerCase -%>_field_helpers = false;

if ( class_exists( 'RBM_FieldHelpers' ) ) {

	$<%- pkgNameLowerCase -%>_field_helpers = new RBM_FieldHelpers( array(
		'ID'   => 'kmcu', // Your Theme/Plugin uses this to differentiate its instance of RBM FH from others when saving/grabbing data
		'file' => __FILE__,
		'l10n' => array(
			'field_table'    => array(
				'delete_row'    => __( 'Delete Row', '<%- textDomain -%>' ),
				'delete_column' => __( 'Delete Column', '<%- textDomain -%>' ),
			),
			'field_select'   => array(
				'no_options'       => __( 'No select options.', '<%- textDomain -%>' ),
				'error_loading'    => __( 'The results could not be loaded', '<%- textDomain -%>' ),
				/* translators: %d is number of characters over input limit */
				'input_too_long'   => __( 'Please delete %d character(s)', '<%- textDomain -%>' ),
				/* translators: %d is number of characters under input limit */
				'input_too_short'  => __( 'Please enter %d or more characters', '<%- textDomain -%>' ),
				'loading_more'     => __( 'Loading more results...', '<%- textDomain -%>' ),
				/* translators: %d is maximum number items selectable */
				'maximum_selected' => __( 'You can only select %d item(s)', '<%- textDomain -%>' ),
				'no_results'       => __( 'No results found', '<%- textDomain -%>' ),
				'searching'        => __( 'Searching...', '<%- textDomain -%>' ),
			),
			'field_repeater' => array(
				'collapsable_title' => __( 'New Row', '<%- textDomain -%>' ),
				'confirm_delete'    => __( 'Are you sure you want to delete this element?', '<%- textDomain -%>' ),
				'delete_item'       => __( 'Delete', '<%- textDomain -%>' ),
				'add_item'          => __( 'Add', '<%- textDomain -%>' ),
			),
			'field_media'    => array(
				'button_text'        => __( 'Upload / Choose Media', '<%- textDomain -%>' ),
				'button_remove_text' => __( 'Remove Media', '<%- textDomain -%>' ),
				'window_title'       => __( 'Choose Media', '<%- textDomain -%>' ),
			),
			'field_checkbox' => array(
				'no_options_text' => __( 'No options available.', '<%- textDomain -%>' ),
			),
		),
	) );

}

require_once( 'core/rbm-field-helpers-functions.php' );

if ( <%- pkgNameLowerCase -%>_fieldhelpers() ) {

	// Extra meta
	require_once( 'core/extra-meta/front-page-extra-meta.php' );

}

/**
 * Quickly calculates a timezone offset to use with timezones stored in UTC before displaying them
 *
 * @param   string  $timezone_string  Timezone String. Defauts to the one stored for the site (Recommended)
 *
 * @since	{{VERSION}}
 * @return  integer                   Timezone offset in seconds
 */
function <%- pkgNameLowerCase -%>_get_timezone_offset( $timezone_string = '' ) {

	if ( ! $timezone_string ) {
		$timezone_string = get_option( 'timezone_string', 'America/Detroit' );
	}

	$timezone_offset = 0;
	if ( strpos( $timezone_string, '/' ) === false ) {

		$timezone_string = str_replace( 'UTC-', '', $timezone_string );

		if ( $timezone_string ) {
			$timezone_offset = $timezone_string * HOUR_IN_SECONDS;
		}

	}
	else {

		$date_time_zone = new DateTimeZone( $timezone_string );
		$timezone_offset = $date_time_zone->getOffset( new DateTime( 'now', null ) );

	}

	return $timezone_offset;

}

/**
 * Quickly converts a UTC Timestamp to a local timestamp
 *
 * @param   integer $utc_timestamp    UTC Timestamp
 * @param   integer $timezone_offset  Timezone offset. False will generate one for you (Recommended)
 *
 * @since	{{VERSION}}
 * @return  integer                   Local Timestamp
 */
function <%- pkgNameLowerCase -%>_convert_utc_timestamp_to_local( $utc_timestamp, $timezone_offset = false ) {

	if ( $timezone_offset === false ) {
		$timezone_offset = <%- pkgNameLowerCase -%>_get_timezone_offset();
	}

	return $utc_timestamp + $timezone_offset;

}

/**
 * Returns an Array of Complete and Not Complete Course Step Items for a Given Course and User
 *
 * @param   integer $course_id  Course ID
 * @param   integer $user_id    User ID
 *
 * @since	{{VERSION}}
 * @return  array				Array of Step IDs
 */
function <%- pkgNameLowerCase -%>_get_course_progress( $course_id, $user_id = null ) {

	if ( ! $user_id ) $user_id = get_current_user_id();

	$user_course_progress = get_user_meta( get_current_user_id(), '_sfwd-course_progress', true );

	if ( isset( $user_course_progress[ $course_id ] ) && $user_course_progress[ $course_id ] ) {
		$user_course_progress = $user_course_progress[ $course_id ];
	}
	else {
		$user_course_progress = array(
			'lesson' => array(),
			'topic' => array(),
			'quiz' => array(),
		);
	}

	foreach ( $user_course_progress as $key => $value ) {

		// Convert to singular since LearnDash hardcoded the Course Progress keys to be plural
		// Since we know these are always in English and can't be changed via a Custom Label we can do a replacement like this
		$new_key = preg_replace( '/[s|zes]*$/sim', '', $key );

		unset( $user_course_progress[ $key ] );
		$user_course_progress[ $new_key ] = $value;

	}

	$all_steps = <%- pkgNameLowerCase -%>_get_course_step_post_ids( $course_id );

	$course_progress = array(
		'lesson' => array(
			'complete' => array(),
			'not_complete' => array(),
		),
		'topic' => array(
			'complete' => array(),
			'not_complete' => array(),
		),
		'quiz' => array(
			'complete' => array(),
			'not_complete' => array(),
		),
	);

	foreach ( $all_steps as $post_type => $post_ids ) {

		$post_type_key = learndash_get_post_type_key( $post_type );

		foreach ( $post_ids as $post_id ) {

			if ( $post_type_key == 'quiz' ) {

				if ( learndash_is_quiz_complete( get_current_user_id(), $post_id, $course_id ) ) {
					$course_progress[ $post_type_key ]['complete'][] = $post_id;
				}
				else {
					$course_progress[ $post_type_key ]['not_complete'][] = $post_id;
				}

			}
			elseif ( $post_type_key == 'topic' ) {

				$found = false;

				foreach ( $user_course_progress[ $post_type_key ] as $lesson_id => $post_ids ) {

					if ( array_key_exists( $post_id, $post_ids ) ) {
						$found = true;
						break;
					}

				}

				if ( $found ) {
					$course_progress[ $post_type_key ]['complete'][] = $post_id;
				}
				else {
					$course_progress[ $post_type_key ]['not_complete'][] = $post_id;
				}

			}
			else {

				if ( array_key_exists( $post_id, $user_course_progress[ $post_type_key ] ) ) {
					$course_progress[ $post_type_key ]['complete'][] = $post_id;
				}
				else {
					$course_progress[ $post_type_key ]['not_complete'][] = $post_id;
				}

			}

		}

	}

	return $course_progress;

}

/**
 * Returns an Array of all the Post IDs that comprise Steps in a given Course
 *
 * @param   integer  $course_id  Course ID
 *
 * @since	{{VERSION}}
 * @return  array                Array of Step IDs
 */
function <%- pkgNameLowerCase -%>_get_course_step_post_ids( $course_id ) {

	$steps_object = LDLMS_Factory_Post::course_steps( $course_id );
	$course_heirarchy_steps = $steps_object->get_steps( 'h' );

	$post_ids = array();
	
	_<%- pkgNameLowerCase -%>_get_course_step_post_ids( $course_heirarchy_steps, $post_ids );

	return $post_ids;

}

/**
 * Recurse through the Course Steps found in <%- pkgNameLowerCase -%>_get_course_step_post_ids()
 *
 * @param   array  $array    Input Array
 * @param   array  $results  Results passed by reference
 *
 * @since	{{VERSION}}
 * @return  array            Results
 */
function _<%- pkgNameLowerCase -%>_get_course_step_post_ids( $array, &$results ) {

	foreach ( $array as $key => $value ) {

		if ( is_array( $value ) ) {

			if ( is_numeric( $key ) ) {

				$post_type = get_post_type( $key );

				if ( ! isset( $results[ $post_type ] ) ) $results[ $post_type ] = array();

				$results[ $post_type ][] = $key;

				if ( ! empty( $value ) ) {

					_<%- pkgNameLowerCase -%>_get_course_step_post_ids( $value, $results );

				}

			}
			else {

				_<%- pkgNameLowerCase -%>_get_course_step_post_ids( $value, $results );

			}

		}

	}

}

/**
 * Can the User access a given Post?
 *
 * @param   integer $post_id  WP_Post ID
 * @param   integer $user_id  WP_User ID
 *
 * @since	{{VERSION}}
 * @return  boolean           Can/Can't Access
 */
function <%- pkgNameLowerCase -%>_can_access_content( $post_id = null, $user_id = null ) {

	if ( ! is_user_logged_in() ) return false;

	if ( ! $post_id ) $post_id = get_the_ID();

	if ( ! $user_id ) $user_id = get_current_user_id();

	// Super Admin always has access
	if ( is_super_admin( $user_id ) ) return true;

	$access = false;

	if ( class_exists( 'MeprRule' ) ) {

		$post = get_post( $post_id );
		$rules = MeprRule::get_rules( $post );

		$user = new MeprUser( $user_id );

		foreach ( $rules as $rule ) {
			
			if ( $user->has_access_from_rule( $rule->ID ) ) {
				$access = true;
				break;
			}

		}

	}

	// This is a helpful fallback to have
	if ( ! $access && get_post_type( $post_id ) == 'sfwd-courses' && function_exists( 'sfwd_lms_has_access' ) ) {

		$access = sfwd_lms_has_access( $post_id, $user_id );

	}

	return $access;

}

/**
 * The Gradient used by the Logo requires a unique ID, so this function ensures that it stays unique
 *
 * @since	{{VERSION}}
 * @return  string         SVG HTML
 */
function <%- pkgNameLowerCase -%>_get_logo( $location = 'header' ) {

	ob_start();

	if ( $location !== 'header' ) {
										
		echo file_get_contents( THEME_DIR . 'dist/assets/img/logo.svg' );

	}
	else {

		?>

		<div class="hide-for-large">
			<?php echo file_get_contents( THEME_DIR . 'dist/assets/img/logo-mobile.svg' ); ?>
		</div>

		<div class="show-for-large">
			<?php echo file_get_contents( THEME_DIR . 'dist/assets/img/logo-desktop.svg' ); ?>
		</div>

		<?php

	}

	$svg = ob_get_clean();

	return $svg;

}

use function SSNepenthe\ColorUtils\{
    scale_color, red, green, blue, lightness, desaturate, adjust_hue, color, lighten, darken, saturate
};

/**
 * Converts internal RGB color object to Hex
 *
 * @param   SSNepenthe\ColorUtils\Colors\Rgb  $rgb  RGB Color object
 *
 * @since	{{VERSION}}
 * @return  string       							Hex Color
 */
function _<%- pkgNameLowerCase -%>_color_to_hex( $rgb ) {

	$color = color( $rgb );
	return $color->toHexString();

}

/**
 * Replicates SCSS scale-color()
 *
 * @param   string  $hex    Hex Color
 * @param   array   $args   Associative Array of arguments. Example: `lightness`
 *
 * @since	{{VERSION}}
 * @return  string          Scaled Hex Color
 */
function <%- pkgNameLowerCase -%>_scale_color( $hex, $args ) {
	return _<%- pkgNameLowerCase -%>_color_to_hex( scale_color( $hex, $args ) );
}

/**
 * Replicates SCSS desaturate()
 *
 * @param   string  $hex    Hex Color
 * @param   array   $args   Associative Array of arguments. Example: `lightness`
 *
 * @since	{{VERSION}}
 * @return  string          Scaled Hex Color
 */
function <%- pkgNameLowerCase -%>_desaturate( $hex, $amount ) {
	return _<%- pkgNameLowerCase -%>_color_to_hex( desaturate( $hex, $amount ) );
}

/**
 * Replicates SCSS saturate()
 *
 * @param   string  $hex    Hex Color
 * @param   array   $args   Associative Array of arguments. Example: `lightness`
 *
 * @since	{{VERSION}}
 * @return  string          Scaled Hex Color
 */
function <%- pkgNameLowerCase -%>_saturate( $hex, $amount ) {
	return _<%- pkgNameLowerCase -%>_color_to_hex( saturate( $hex, $amount ) );
}

function <%- pkgNameLowerCase -%>_adjust_hue( $hex, $degrees ) {
	return _<%- pkgNameLowerCase -%>_color_to_hex( adjust_hue( $hex, $degrees ) );
}

function <%- pkgNameLowerCase -%>_lighten( $hex, $amount ) {
	return _<%- pkgNameLowerCase -%>_color_to_hex( lighten( $hex, $amount ) );
}

function <%- pkgNameLowerCase -%>_darken( $hex, $amount ) {
	return _<%- pkgNameLowerCase -%>_color_to_hex( darken( $hex, $amount ) );
}

function <%- pkgNameLowerCase -%>_lightness( $hex ) {
	return lightness( $hex );
}

/**
 * Copy of the color-luminance() SCSS function from Foundation
 *
 * @param   string  $hex  Hex Color
 *
 * @since	{{VERSION}}
 * @return  float         Color Luminance Ratio
 */
function _<%- pkgNameLowerCase -%>_color_luminance( $hex ) {

	$rgb = array( red( $hex ), green( $hex ), blue( $hex ) );

	foreach ( $rgb as &$channel ) {
		 
		$ratio = $channel / 255;

		$channel = ( $ratio < 0.03928 ) ? $ratio / 12.92 : pow( ( $ratio + 0.055 ) / 1.055, 2.4 );

	}

	return 0.2126 * $rgb[0] + 0.7152 * $rgb[1] + 0.0722 * $rgb[2];

}

/**
 * Copy of the color-contrast() SCSS function from Foundation
 *
 * @param   string  $color1  Hex Color
 * @param   string  $color2  Hex Color
 *
 * @since	{{VERSION}}
 * @return  float            Contrast Ratio
 */
function _<%- pkgNameLowerCase -%>_color_contrast( $color1, $color2 ) {

	$luminance1 = _<%- pkgNameLowerCase -%>_color_luminance( $color1 ) + 0.05;
	$luminance2 = _<%- pkgNameLowerCase -%>_color_luminance( $color2 ) + 0.05;
	$ratio = $luminance1 / $luminance2;

	if ( $luminance2 > $luminance1 ) {
		$ratio = 1 / $ratio;
	}

	$ratio = round( $ratio * 10 ) / 10;

	return $ratio;

}

/**
 * Copy of color-pick-contrast() SCSS function from Foundation
 * 
 * This checks the best color for contrast given two colors to pick from
 * 
 * Foundation technically lets you feed in a List of multiple colors to check against, but generally speaking you only compare against two colors
 *
 * @param   string  $base_color  Hex Color of the base or background
 * @param   string  $color1      Hex Color
 * @param   string  $color2      Hex Color
 * @param   float   $tolerance   Contrast tolerance
 *
 * @since	{{VERSION}}
 * @return  string               Hex Color with the best contrast
 */
function <%- pkgNameLowerCase -%>_color_pick_contrast( $base_color, $color1 = '#262626', $color2 = '#ffffff', $tolerance = 0 ) {

	$contrast = _<%- pkgNameLowerCase -%>_color_contrast( $base_color, $color1 );

	// Defaults to color 1
	$best = $color1;

	// This just makes the rest of the code cleaner
	$colors = array(
		$color1,
		$color2
	);

	foreach ( $colors as $color ) {

		$current_contrast = _<%- pkgNameLowerCase -%>_color_contrast( $base_color, $color );

		if ( ( $current_contrast - $contrast ) > $tolerance ) {
			$contrast = $current_contrast;
			$best = $color;
		}

	}

	if ( $contrast < 3 ) {
		error_log( "Contrast ratio of $best on $base_color is pretty bad. Just $contrast" );
	}

	return $best;

}

/**
 * Copy of smart-scale() SCSS function from Foundation
 * 
 * This will scale a color to be either lighter or darker as appropriate
 *
 * @param   string   $hex        Hex Color
 * @param   integer  $scale      Percentage to scale the color's Lightess or Darkness by
 * @param   integer  $threshold  Lightness threshold
 *
 * @since	{{VERSION}}
 * @return  string               Hex Color
 */
function <%- pkgNameLowerCase -%>_smart_scale( $hex, $scale = 5, $threshold = 40 ) {

	if ( lightness( $hex ) > $threshold ) {
		$scale = - $scale;
	}

	return <%- pkgNameLowerCase -%>_scale_color( $hex, array( 'lightness' => $scale ) );

}

/**
 * A copy of my own create-gradient() SCSS mixin
 *
 * @param   integer  $degree      Degree angle of the gradient
 * @param   string   $start       Hex Color
 * @param   string   $stop        Hex Color
 * @param   float    $start_step  Percentage
 * @param   float    $stop_step   Percentage
 *
 * @since	{{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_create_gradient_css( $degree, $start, $stop, $start_step = 0, $stop_step = 100 ) {

	switch ( $degree ) {
		case 'vertical' : 
			$degree = 0;
			break;
		case 'diagonal-up' :
			$degree = 45;
			break;
		case 'diagonal-down' : 
			$degree = -45;
			break;
		case 'horizontal' : 
			$degree = 90;
			break;
		default : 
			break;
	}

	/* Fallback for ancient things */
    echo "background: $start;";
    
    /* FF3.6-15 */
    echo "background: -moz-linear-gradient( {$degree}deg, $start {$start_step}%, $stop {$stop_step}% );";
    
    /* Chrome10-25,Safari5.1-6 */
    echo "background: -webkit-linear-gradient( {$degree}deg, $start {$start_step}%, $stop {$stop_step}% );";
    
    /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    if ( $degree == -45 ) {
		$degree = 180 + $degree;
        echo "background: linear-gradient( {$degree}deg, $start {$start_step}%, $stop {$stop_step}% );";
    }
    else if ( $degree == 45 ) {
        echo "background: linear-gradient( {$degree}deg, $start {$start_step}%, $stop {$stop_step}% );";
    }
    else {
		$degree = 180 - $degree;
        echo "background: linear-gradient( {$degree}deg, $start {$start_step}%, $stop {$stop_step}% );";
    }
    
    /* IE6-9 */
    echo "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$start', endColorstr='$stop',GradientType=1 );";

}

/**
 * A copy of my own light-or-dark-text() SCSS mixin
 *
 * @param   string  $background_color  Background Color
 * @param   string  $dark_text_color   Dark Text Color
 * @param   string  $light_text_color  Light Text Color
 *
 * @since	{{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_light_or_dark_text( $background_color, $dark_text_color = '#262626', $light_text_color = '#ffffff' ) {

	echo 'color: ' . <%- pkgNameLowerCase -%>_color_pick_contrast( $background_color, $dark_text_color, $light_text_color ) . ';';

}

/**
 * A copy of my own light-or-dark-link() SCSS mixin
 * 
 * Due to limitations of vanilla CSS, we need to pass the selector into this function
 *
 * @param   string  $selector          CSS Selector to apply this to
 * @param   string  $background_color  Hex Background Color
 * @param   string  $dark_link_color   Hex dark link Color
 * @param   string  $light_link_color  Hex light link Color
 *
 * @since	{{VERSION}}
 * @return  string                     CSS
 */
function <%- pkgNameLowerCase -%>_light_or_dark_link( $selector, $background_color, $dark_link_color = '#286CAD', $light_link_color = '#ffffff' ) {

	echo $selector . ' {';
		echo 'color: ' . <%- pkgNameLowerCase -%>_color_pick_contrast( $background_color, $dark_link_color, $light_link_color ) . ';'; 
	echo '}';

	echo $selector . ':hover, ' . $selector . ':focus {';

		$dark_link_color = <%- pkgNameLowerCase -%>_smart_scale( $dark_link_color, 14 );
		$light_link_color = <%- pkgNameLowerCase -%>_smart_scale( $light_link_color, 14 );

		echo 'color: ' . <%- pkgNameLowerCase -%>_color_pick_contrast( $background_color, $dark_link_color, $light_link_color ) . ';';
	echo '}';

}

/**
 * Shorthand to get the FacetWP Prefix
 *
 * @since	{{VERSION}}
 * @return  string  FacetWP Prefix
 */
function <%- pkgNameLowerCase -%>_get_facetwp_prefix() {

	$facetwp_prefix = 'fwp_';

    if ( function_exists( 'FWP' ) ) {
        $facetwp_prefix = FWP()->helper->get_setting( 'prefix' );
	}
	
	return $facetwp_prefix;
	
}

add_filter( 'facetwp_query_args', '<%- pkgNameLowerCase -%>_fix_facetwp_search', 1 );

/**
 * Fixes FacetWP search which strangely appears broken
 *
 * @param   array  $args        WP_Query Args
 *
 * @since   {{VERSION}}
 * @return  array               WP_Query Args
 */
function <%- pkgNameLowerCase -%>_fix_facetwp_search( $args ) {

	$facetwp_prefix = <%- pkgNameLowerCase -%>_get_facetwp_prefix();

	// ...why isn't this working normally?
	if ( isset( $_REQUEST[ $facetwp_prefix . 'search' ] ) && $_REQUEST[ $facetwp_prefix . 'search' ] ) {

		$args['s'] = $_REQUEST[ $facetwp_prefix . 'search' ];

	}

	return $args;

}

/**
 * Returns an array of Children recursively for a given Post
 * get_page_children() isn't quite good enough since we don't want to have to give it a list of Posts to check against
 *
 * @param   integer  $parent_id  Parent Post ID
 *
 * @since	{{VERSION}}
 * @return  array                Array of WP_Post Objects
 */
function <%- pkgNameLowerCase -%>_get_post_children( $parent_id ) {

	$children = array();

	$posts = get_posts( array(
		'post_type' => get_post_type( $parent_id ),
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'post_parent' => $parent_id,
		'facetwp' => false,
		'orderby' => array(
            'menu_order' => 'ASC',
            'post_date' => 'DESC',
        ),
	) );

	if ( $posts ) {
		// Direct descendents/children
		$children = array_merge( $children, $posts );
	}

	foreach ( $posts as $child ) {

		$grandchildren = <%- pkgNameLowerCase -%>_get_post_children( $child->ID );

		if ( ! empty( $grandchildren ) ) {
			$children = array_merge( $children, $grandchildren );
		}

	}

	return $children;

}

/**
 * Retrieves the furthest most Parent for a given Post's Parent
 * You'll probably want to pass in $post->post_parent or similar
 *
 * @param   integer  $post_parent  Post Parent ID
 *
 * @since	{{VERSION}}
 * @return  integer                Post ID of the furthest back ancestor
 */
function <%- pkgNameLowerCase -%>_get_post_ancestor( $post_parent ) {

	$parent_id = 0;

	if ( $post_parent ) : 
		
		$parent_id = $post_parent;

		while ( $post_parent ) {

			$post_parent = wp_get_post_parent_id( $post_parent );
			
			if ( $post_parent ) {
				$parent_id = $post_parent;
			}
			
		}

	endif;

	return $parent_id;
	
}