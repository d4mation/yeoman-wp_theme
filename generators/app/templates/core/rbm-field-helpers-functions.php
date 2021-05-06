<?php

/**
 * Quick access to plugin field helpers.
 *
 * @since {{VERSION}}
 *
 * @return RBM_FieldHelpers
 */
function <%- pkgNameLowerCase -%>_fieldhelpers() {

    global $<%- pkgNameLowerCase -%>_field_helpers;

    if ( ! $<%- pkgNameLowerCase -%>_field_helpers ) {
        error_log( 'field helpers library not loaded' );
        return false;
    }

    return $<%- pkgNameLowerCase -%>_field_helpers;
    
}

/**
 * This is only necessary to call for Meta Fields using the "Hook" field type. Everything else will work automatically.
 *
 * @param   string  $name  Field Name
 * @param   string  $type  Field Type
 * @param   array   $args  Field Args
 *
 * @since	{{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_init_field( $name, $type, $args ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->save->field_init( $name, $type, $args );
}

/**
 * Initializes a field group for automatic saving.
 *
 * @since {{VERSION}}
 *
 * @param $group
 */
function <%- pkgNameLowerCase -%>_init_field_group( $group ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->save->initialize_fields( $group );
}

/**
 * Gets a meta field helpers field.
 *
 * @since {{VERSION}}
 *
 * @param string $name Field name.
 * @param string|int $post_ID Optional post ID.
 * @param mixed $default Default value if none is retrieved.
 * @param array $args
 *
 * @return mixed Field value
 */
function <%- pkgNameLowerCase -%>_get_field( $name, $post_ID = false, $default = '', $args = array() ) {
    $value = <%- pkgNameLowerCase -%>_fieldhelpers()->fields->get_meta_field( $name, $post_ID, $args );
    return $value !== false ? $value : $default;
}

/**
 * Gets a option field helpers field.
 *
 * @since {{VERSION}}
 *
 * @param string $name Field name.
 * @param mixed $default Default value if none is retrieved.
 * @param array $args
 *
 * @return mixed Field value
 */
function <%- pkgNameLowerCase -%>_get_option_field( $name, $default = '', $args = array() ) {
	$value = <%- pkgNameLowerCase -%>_fieldhelpers()->fields->get_option_field( $name, $args );
	return $value !== false ? $value : $default;
}

/**
 * Outputs a text field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_text( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_text( $args['name'], $args );
}

/**
 * Outputs a password field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_password( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_password( $args['name'], $args );
}

/**
 * Outputs a textarea field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_textarea( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_textarea( $args['name'], $args );
}

/**
 * Outputs a checkbox field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_checkbox( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_checkbox( $args['name'], $args );
}

/**
 * Outputs a toggle field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_toggle( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_toggle( $args['name'], $args );
}

/**
 * Outputs a radio field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_radio( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_radio( $args['name'], $args );
}

/**
 * Outputs a select field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_select( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_select( $args['name'], $args );
}

/**
 * Outputs a number field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_number( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_number( $args['name'], $args );
}

/**
 * Outputs an image field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_media( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_media( $args['name'], $args );
}

/**
 * Outputs a datepicker field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_datepicker( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_datepicker( $args['name'], $args );
}

/**
 * Outputs a timepicker field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_timepicker( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_timepicker( $args['name'], $args );
}

/**
 * Outputs a datetimepicker field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_datetimepicker( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_datetimepicker( $args['name'], $args );
}

/**
 * Outputs a colorpicker field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_colorpicker( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_colorpicker( $args['name'], $args );
}

/**
 * Outputs a list field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_list( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_list( $args['name'], $args );
}

/**
 * Outputs a hidden field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_hidden( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_hidden( $args['name'], $args );
}

/**
 * Outputs a table field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_table( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_table( $args['name'], $args );
}

/**
 * Outputs a HTML field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_html( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_html( $args['name'], $args );
}

/**
 * Outputs a repeater field.
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_repeater( $args = array() ) {
	<%- pkgNameLowerCase -%>_fieldhelpers()->fields->do_field_repeater( $args['name'], $args );
}

/**
 * Outputs a Hook
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_do_field_hook( $args = array() ) {
	do_action( "<%- pkgNameLowerCase -%>_field_hook_{$args['id']}", $args );
}

/**
 * Outputs a String if a Callback Function does not exist for an Options Page Field
 *
 * @since {{VERSION}}
 *
 * @param array $args
 */
function <%- pkgNameLowerCase -%>_missing_callback( $args ) {
	
	printf( 
		_x( 'A callback function called "<%- pkgNameLowerCase -%>_do_field_%s" does not exist.', '%s is the Field Type', '<%- textDomain -%>' ),
		$args['type']
	);
		
}