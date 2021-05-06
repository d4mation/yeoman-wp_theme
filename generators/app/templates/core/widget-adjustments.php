<?php
/**
 * Adjusts Widget Output to wrap each one in a collapsable element
 * 
 * This is largely based on https://philipnewcomer.net/2014/06/filter-output-wordpress-widget/ with some tweaks for our use case
 *
 * @since   {{VERSION}}
 * @package <%- pkgName %>
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

add_filter( 'dynamic_sidebar_params', '<%- pkgNameLowerCase -%>_filter_dynamic_sidebar_params' );

/**
 * Filter all Sidebar Params so that we can set up a separate Callback Function to make all Widgets have a Filter for their Output regardless of their source
 *
 * @param   array  $sidebar_params  Array of Sidebar Params
 *
 * @since   {{VERSION}}
 * @return  array                   Array of Sidebar Params
 */
function <%- pkgNameLowerCase -%>_filter_dynamic_sidebar_params( $sidebar_params ) {
 
    if ( is_admin() ) return $sidebar_params;
 
    global $wp_registered_widgets;
    $widget_id = $sidebar_params[0]['widget_id'];
 
    $wp_registered_widgets[ $widget_id ]['original_callback'] = $wp_registered_widgets[ $widget_id ]['callback'];
    $wp_registered_widgets[ $widget_id ]['callback'] = '<%- pkgNameLowerCase -%>_wrap_widget_callback';
    $wp_registered_widgets[ $widget_id ]['sidebar_id'] = $sidebar_params[0]['id'];
    $wp_registered_widgets[ $widget_id ]['sidebar_args'] = $sidebar_params[0];
 
    return $sidebar_params;
 
}

/**
 * Set up a Filter for all Widget Output
 *
 * @since   {{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_wrap_widget_callback() {

    global $wp_registered_widgets;

    // TIL this function exists
    $original_callback_params = func_get_args();
    $widget_id = $original_callback_params[0]['widget_id'];
 
    $original_callback = $wp_registered_widgets[ $widget_id ]['original_callback'];
    $wp_registered_widgets[ $widget_id ]['callback'] = $original_callback;
 
    if ( is_callable( $original_callback ) ) {
 
        ob_start();
        call_user_func_array( $original_callback, $original_callback_params );
        $widget_output = ob_get_clean();

        $widget_id_base = $wp_registered_widgets[ $widget_id ]['callback'][0]->id_base;
        $instance_number = $wp_registered_widgets[ $widget_id ]['callback'][0]->number;

        $sidebar_id = $wp_registered_widgets[ $widget_id ]['sidebar_id'];
        $sidebar_args = $wp_registered_widgets[ $widget_id ]['sidebar_args'];
 
        echo apply_filters( '<%- pkgNameLowerCase -%>_widget_output', $widget_output, $widget_id_base, $sidebar_id, $instance_number, $sidebar_args );
 
    }

}

add_filter( '<%- pkgNameLowerCase -%>_widget_output', '<%- pkgNameLowerCase -%>_sidebar_menu_widget_output', 10, 5 );

/**
 * If it is not a Footer Widget, wrap the output in an Accordion
 *
 * @param   string   $widget_output    HTML Output
 * @param   string   $widget_id_base   Widget ID Base
 * @param   string   $siderbar_id      Sidebar ID
 * @param   integer  $instance_number  Widget Instance Number/Key
 * @param   array    $sidebar_args     Sidebar Args
 *
 * @since   {{VERSION}}
 * @return  string                     HTML Output
 */
function <%- pkgNameLowerCase -%>_sidebar_menu_widget_output( $widget_output, $widget_id_base, $siderbar_id, $instance_number, $sidebar_args ) {

    if ( strpos( $siderbar_id, 'footer' ) !== false ) return $widget_output;

    // We only use this to get the Widget Instance
    $widget = new WP_Widget( $widget_id_base, 'dummy' );

    $all_instances = $widget->get_settings();
    $instance = ( isset( $all_instances[ $instance_number ] ) && $all_instances[ $instance_number ] ) ? $all_instances[ $instance_number ] : array( 'title' => __( 'Sidebar Widget', '<%- textDomain -%>' ) );

    ob_start();

    ?>

    <div class="show-for-medium">
        <?php echo $widget_output; ?>
    </div>

    <div class="show-for-small-only">

        <?php 

            $match = preg_match( '/(' . preg_quote( $sidebar_args['before_title'], '/' ) . '.*?' . preg_quote( $instance['title'], '/' ) . '.*?' . preg_quote( $sidebar_args['after_title'], '/' ) . ')/sim', $widget_output, $matches );

            $title = $instance['title'];
            if ( $match && isset( $matches[1] ) && $matches[1] ) {
                $widget_output = str_replace( $matches[1], '', $widget_output );
            }

        ?> 

        <ul class="accordion" data-accordion data-allow-all-closed="true">

            <li class="accordion-item" data-accordion-item>

                <a href="#" class="accordion-title">
                    <?php echo $title; ?>
                </a>

                <div class="accordion-content" data-tab-content>
                    <?php echo $widget_output; ?>
                </div>

            </li>

        </ul>

    </div>

    <?php 

    $html = ob_get_clean();

    return $html;

}