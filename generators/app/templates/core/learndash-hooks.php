<?php

/**
 * Prevent the Tabs from showing on the Course Overview page
 *
 * @param   string   $file_path         Full file path. False to not load.
 * @param   string   $name              Relative File path in the LD Themes directory
 * @param   array    $args              Array of Args to pass to the template
 * @param   boolean  $echo              Whether to echo the results. Always null in learndash_get_template_part()
 * @param   boolean  $return_file_path  Return file path instead of output. Always true in learndash_get_template_part()
 *
 * @since   {{VERSION}}
 * @return  string                      Full file path.
 */
add_filter( 'learndash_template', function( $file_path, $name, $args, $echo, $return_file_path ) {

    if ( $name == 'modules/tabs.php' && $args['context'] == 'course' ) return false;

    return $file_path;

}, 10, 5 );

/**
 * We have our own Breadcrumbs
 *
 * @param   string   $file_path         Full file path. False to not load.
 * @param   string   $name              Relative File path in the LD Themes directory
 * @param   array    $args              Array of Args to pass to the template
 * @param   boolean  $echo              Whether to echo the results. Always null in learndash_get_template_part()
 * @param   boolean  $return_file_path  Return file path instead of output. Always true in learndash_get_template_part()
 *
 * @since   {{VERSION}}
 * @return  string                      Full file path.
 */
add_filter( 'learndash_template', function( $file_path, $name, $args, $echo, $return_file_path ) {

    if ( $name == 'modules/breadcrumbs.php' ) return false;

    return $file_path;

}, 10, 5 );

/**
 * We are outputing the entire Course Overview in the sidebar
 *
 * @param   string   $file_path         Full file path. False to not load.
 * @param   string   $name              Relative File path in the LD Themes directory
 * @param   array    $args              Array of Args to pass to the template
 * @param   boolean  $echo              Whether to echo the results. Always null in learndash_get_template_part()
 * @param   boolean  $return_file_path  Return file path instead of output. Always true in learndash_get_template_part()
 *
 * @since   {{VERSION}}
 * @return  string                      Full file path.
 */
add_filter( 'learndash_template', function( $file_path, $name, $args, $echo, $return_file_path ) {

    if ( $name == 'modules/infobar.php' && in_array( $args['context'], array( 'course', 'lesson', 'topic', 'quiz' ) ) ) return false;

    return $file_path;

}, 10, 5 );

/**
 * We are outputing this below the sidebar and content
 *
 * @param   string   $file_path         Full file path. False to not load.
 * @param   string   $name              Relative File path in the LD Themes directory
 * @param   array    $args              Array of Args to pass to the template
 * @param   boolean  $echo              Whether to echo the results. Always null in learndash_get_template_part()
 * @param   boolean  $return_file_path  Return file path instead of output. Always true in learndash_get_template_part()
 *
 * @since   {{VERSION}}
 * @return  string                      Full file path.
 */
add_filter( 'learndash_template', function( $file_path, $name, $args, $echo, $return_file_path ) {

    if ( $name == 'modules/course-steps.php' && in_array( $args['context'], array( 'lesson', 'topic', 'quiz' ) ) ) return false;

    return $file_path;

}, 10, 5 );

/**
 * Output the Course's Content Field. This by default does not show in LearnDash, oddly enough
 *
 * @param   integer  $course_id  Course ID
 * @param   integer  $user_id    User ID
 *
 * @since   {{VERSION}}
 * @return  void
 */
add_action( 'learndash-course-certificate-link-after', function( $course_id, $user_id ) {

    $course = get_post( $course_id );

    add_filter( 'learndash_template_preprocess_filter', '__return_false' );

    if ( $course->post_content ) : 

    ?>

    <div class="ld-section-heading">

        <div class="kmcu-course-overview">

            <h2>
                <?php printf( __( 'About this %s', '<%- textDomain -%>' ), learndash_get_custom_label_lower( 'course' ) ); ?>
            </h2>

            <div class="grid-container full">
                <div class="grid-x">
                    <div class="cell">
                        <?php 

                            echo apply_filters( 'the_content', $course->post_content );

                        ?>
                    </div>
                    <?php 

                    $product_id = false;

                    $find_product = new WP_Query( array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'fields' => 'ids',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => '_related_course',
                                'value' => 'i:' . get_the_ID() . ';', // Match the serialized data
                                'compare' => 'LIKE',
                            ),
                        )
                    ) );

                    if ( $find_product->have_posts() ) : 

                        $product_id = $find_product->posts[0];

                    endif;
                    
                    if ( ( ! is_user_logged_in() || ! sfwd_lms_has_access( $course_id, get_current_user_id() ) ) && $product_id ) : ?>
                        <div class="cell">
                            <?php 

                                if ( $product_id && function_exists( 'wc_get_product' ) ) : 

                                    global $product;

                                    $product = wc_get_product( $product_id );

                                    woocommerce_template_loop_add_to_cart();

                                    woocommerce_template_loop_price();

                                    unset( $product );

                                endif;

                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>

    <?php

    endif;

}, 10, 2 );

add_action( 'learndash-course-progress-bar-before', function() {

    add_filter( 'learndash_get_user_activity', '<%- pkgNameLowerCase -%>_always_show_course_steps', 10, 2 );

} );

add_action( 'learndash-course-progress-bar-after', function() {

    remove_filter( 'learndash_get_user_activity', '<%- pkgNameLowerCase -%>_always_show_course_steps', 10, 2 );

} );

/**
 * Return nothing for User Course Activity to ensure we always see the %d/%d Steps text rather than a String saying what their last seen Timestamp was
 *
 * @param   object $activity  User Activity
 * @param   array  $args      learndash_get_user_activity() $args
 *
 * @since   {{VERSION}}
 * @return  object            User Activity
 */
function <%- pkgNameLowerCase -%>_always_show_course_steps( $activity, $args ) {

    return false;

}

/**
 * Outputs text for a Course that a User is enrolled in but has not started
 * LearnDash by default does not have a message for this
 *
 * @param   string  $bubble  Bubble HTML
 * @param   string  $status  Course Status
 *
 * @since   {{VERSION}}
 * @return  string           Bubble HTML
 */
add_filter( 'learndash_status_bubble', function( $bubble, $status ) {

    if ( $status !== __( 'Not Started', 'learndash' ) ) return $bubble;

    return '<div class="ld-status ld-status-progress ld-primary-background">' . __( 'You are enrolled in this course', '<%- textDomain -%>' ) . '</div>';

}, 10, 2 );

/**
 * Since we disabled the Tabs on the Course Single, we need to output the Materials separately
 * LearnDash does not have a template for this, so we'll output them manually
 * It would have likely required us to override any template that existed anyway
 *
 * @param   integer  $course_id  Course ID
 * @param   integer  $user_id    User ID
 *
 * @since   {{VERSION}}
 * @return  void
 */
add_action( 'learndash-course-content-list-after', function( $course_id, $user_id ) {

    $course_materials = learndash_get_setting( $course_id, 'course_materials' );

    if ( ! $course_materials ) return;

    // We're going to extract all the links and reformat them
    $match = preg_match_all( '/<a.*?href="(.*?)">(.*?)<\/a>/i', $course_materials, $matches );

    if ( ! $match ) return;

    ?>

    </div>

    <div class="ld-item-list ld-lesson-list">

        <div class="kmcu-materials-list">

            <div class="ld-section-heading">

                <h2>
                    <?php _e( 'Materials', '<%- textDomain -%>' ); ?>
                </h2>

            </div>

            <div class="grid-container full">
                <div class="grid-x">

                <?php foreach ( $matches[0] as $index => $full_match ) : ?>

                    <div class="cell">
                        <div class="grid-x">
                            <div class="cell medium-3">
                                <a class="primary button expanded" href="<?php echo esc_attr( $matches[1][ $index ] ); ?>" target="_blank">
                                    <?php echo esc_attr( $matches[2][ $index ] ); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                </div>
            </div>

        </div>

    </div>

    <?php

}, 10, 2 );

add_action( 'learndash-lesson-before', '<%- pkgNameLowerCase -%>_learndash_before', 10, 3 );
add_action( 'learndash-topic-before', '<%- pkgNameLowerCase -%>_learndash_before', 10, 3 );
add_action( 'learndash-quiz-before', '<%- pkgNameLowerCase -%>_learndash_before', 10, 3 );

/**
 * Put Course Content inside a wrapper
 *
 * @param   integer  $post_id    Post ID
 * @param   integer  $course_id  Course ID
 * @param   integer  $user_id    User ID
 *
 * @since   {{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_learndash_before( $post_id, $course_id, $user_id ) {

    ?>

    <div class="grid-container full">
        <div class="grid-x grid-margin-x">

            <div class="cell small-12 medium-8 small-order-1 medium-order-2 kmcu-course-content">

    <?php

}

add_action( 'learndash-lesson-after', '<%- pkgNameLowerCase -%>_learndash_after', 10, 3 );
add_action( 'learndash-topic-after', '<%- pkgNameLowerCase -%>_learndash_after', 10, 3 );
add_action( 'learndash-quiz-after', '<%- pkgNameLowerCase -%>_learndash_after', 10, 3 );

/**
 * Close out the wrapper and place in some additional elements
 *
 * @param   integer  $post_id    Post ID
 * @param   integer  $course_id  Course ID
 * @param   integer  $user_id    User ID
 *
 * @since   {{VERSION}}
 * @return  void
 */
function <%- pkgNameLowerCase -%>_learndash_after( $post_id, $course_id, $user_id ) {

    ?>

            <div class="kmcu-course-actions">

                <?php

                    global $post;

                    $quizzes = learndash_get_lesson_quiz_list( $post, null, $course_id );
                    $quizids = array();

                    if ( ! empty( $quizzes ) ) {
                        foreach ( $quizzes as $quiz ) {
                            $quizids[ $quiz['post']->ID ] = $quiz['post']->ID;
                        }
                    }

                    $all_quizzes_completed = false;

                    if ( ! empty( $quizids ) ) {
                        $all_quizzes_completed = ! learndash_is_quiz_notcomplete( null, $quizids, false, $course_id );
                    } else {
                        $all_quizzes_completed = true;
                    }

                    $can_complete = false;

                    if ( $all_quizzes_completed && is_user_logged_in() && ! empty( $course_id ) ) :
                        $can_complete = apply_filters( 'learndash-lesson-can-complete', true, get_the_ID(), $course_id, $user_id );
                    endif;

                    learndash_get_template_part(
                        'modules/course-steps.php',
                        array(
                            'course_id'             => $course_id,
                            'course_step_post'      => $post,
                            'all_quizzes_completed' => $all_quizzes_completed,
                            'user_id'               => $user_id,
                            'course_settings'       => learndash_get_setting( $course_id ),
                            'context'               => 'after_step_content',
                            'can_complete'          => $can_complete,
                        ),
                        true
                    );

                ?>

            </div>

            <?php // close out column from the main content ?>
            </div>

            <div class="cell small-12 medium-4 small-order-3 medium-order-1 kmcu-course-sidebar">

                <?php

                    do_action( 'learndash-focus-sidebar-before', $course_id, $user_id );

                    learndash_get_template_part(
                        'focus/sidebar.php',
                        array(
                            'course_id' => $course_id,
                            'user_id'   => $user_id,
                            'context'   => 'sidebar', // changed from "focus"
                        ),
                        true
                    );

                ?>

            </div>

            <div class="cell small-12 small-order-2 medium-order-3 kmcu-interior-course-progress">

                <?php

                do_action( 'learndash-course-infobar-access-progress-before', get_post_type(), $course_id, $user_id );

                learndash_get_template_part(
                    'modules/progress.php',
                    array(
                        'context'   => 'course',
                        'user_id'   => $user_id,
                        'course_id' => $course_id,
                    ),
                    true
                );
                
                do_action( 'learndash-course-infobar-access-progress-after', get_post_type(), $course_id, $user_id );

                ?>

            </div>

        <?php // close out the grid ?>
        </div>
    </div>

    <?php

}

/**
 * Adds a button for downloading the Certificate next to the Status Bubble
 *
 * @param   string  $bubble  Bubble HTML
 * @param   string  $status  Course Status
 *
 * @since   {{VERSION}}
 * @return  string           Bubble HTML
 */
add_filter( 'learndash_status_bubble', function( $bubble, $status ) {

    if ( $status == __( 'Completed', 'learndash' ) && get_post_type() == 'sfwd-courses' && $cert_link = learndash_get_course_certificate_link( get_the_ID(), get_current_user_id() ) ) {
        return $bubble . '<a href="' . esc_attr( $cert_link ) . '" target="_blank" class="button primary cert-link">' . __( 'View Certificate', '<%- textDomain -%>' ) . '</a>'; 
    }

    return $bubble;

}, 10, 2 );

/**
 * Remove Certificate Notice
 *
 * @param   string   $file_path         Full file path. False to not load.
 * @param   string   $name              Relative File path in the LD Themes directory
 * @param   array    $args              Array of Args to pass to the template
 * @param   boolean  $echo              Whether to echo the results. Always null in learndash_get_template_part()
 * @param   boolean  $return_file_path  Return file path instead of output. Always true in learndash_get_template_part()
 *
 * @since   {{VERSION}}
 * @return  string                      Full file path.
 */
add_filter( 'learndash_template', function( $file_path, $name, $args, $echo, $return_file_path ) {

    if ( $name == 'modules/alert.php' && $args['icon'] == 'certificate' ) return false;

    return $file_path;

}, 10, 5 );

/**
 * Adjust Course Content text
 *
 * @param   string  $translation  Translated Text
 * @param   string  $text         Untranslated Text
 * @param   string  $context      Translation Context
 * @param   string  $domain       Text Domain
 *
 * @since   {{VERSION}}
 * @return  strting               Translated Text
 */
add_filter( 'gettext_with_context', function( $translation, $text, $context, $domain ) {

    if ( $domain !== 'learndash' ) return $translation;

    if ( $context !== 'placeholder: Course' ) return $translation;

    if ( $text !== '%s Content' ) return $translation;
    
    return '%s ' . learndash_get_custom_label_lower( 'lessons' );

}, 10, 4 );

add_filter( 'learndash_group_course_row_atts', '<%- pkgNameLowerCase -%>_remove_ld_access_tooltip' );
add_filter( 'learndash_lesson_row_atts', '<%- pkgNameLowerCase -%>_remove_ld_access_tooltip' );
add_filter( 'learndash_quiz_row_atts', '<%- pkgNameLowerCase -%>_remove_ld_access_tooltip' );

/**
 * Remove the "You cannot access this content" tooltip on hover
 *
 * @param   string  $tooltip  HTML Attributes, including the tooltip
 *
 * @since   {{VERSION}}
 * @return  string            HTML Attributes, excluding the tooltip
 */
function <%- pkgNameLowerCase -%>_remove_ld_access_tooltip( $tooltip ) {

    $tooltip = preg_replace( '/data-ld-tooltip=".*?"/sim', '', $tooltip );

    return $tooltip;

}

add_filter( 'learndash_next_step_id', function( $next_step_id, $current_step_id, $course_id, $user_id ) {

    if ( $temp = <%- pkgNameLowerCase -%>_get_next_course_step_id( get_post( $current_step_id ) ) ) {
        return $temp;
    }

    return $next_step_id;

}, 10, 4 );

/**
 * LearnDash does not handle "Next Step" very cleanly. It will try to skip over Topics/Quizzes and instead progress to the next Lesson
 * 
 * This function helps us fix that
 *
 * @param   WP_Post  $post_object  WP_Post object of the current Course Step
 *
 * @since   {{VERSION}}
 * @return  integer                Next Course Step ID
 */
function <%- pkgNameLowerCase -%>_get_next_course_step_id( $post_object = null ) {

    if ( ! class_exists( 'LDLMS_Factory_Post' ) ) return '';

    if ( ! function_exists( 'learndash_get_course_id' ) ) return '';

    if ( ! $post_object ) {

        global $post;
        $post_object = $post;

    }

    if ( $post_object->post_type == 'sfwd-courses' ) return '';

    $course_id = learndash_get_course_id( $post_object->ID );

    if ( ! $course_id ) return false;

    // Used to know which one is "next"
    $current_id = $post_object->ID;

    $steps_object = LDLMS_Factory_Post::course_steps( $course_id );
    $course_heirarchy_steps = $steps_object->get_steps( 'h' );

    $post_ids = array();

    _<%- pkgNameLowerCase -%>_get_course_steps_recursive( $course_heirarchy_steps, $post_ids );

    if ( empty( $post_ids ) ) return false;

    $index = array_search( $current_id, $post_ids );

    if ( $index === false ) return false;

    $next_id = false;

    if ( isset( $post_ids[ $index + 1 ] ) && $post_ids[ $index + 1 ] ) {
        $next_id = $post_ids[ $index + 1 ];
    }

    if ( ! $next_id ) return false;

    return $next_id;

}

/**
 * Returns a flat array of Course Steps so we can easily see the order of Course Steps
 *
 * @param   array  $course_heirarchy_steps  Course Heirarchy Steps via LDLMS_Factory_Post
 * @param   array  $post_ids                Array of flat Post IDs
 *
 * @since   {{VERSION}}
 * @return  array                           Array of flat Post IDs
 */
function _<%- pkgNameLowerCase -%>_get_course_steps_recursive( $course_heirarchy_steps, &$post_ids ) {

    foreach ( $course_heirarchy_steps as $key => $value ) {

        if ( is_array( $value ) ) {

            if ( is_numeric( $key ) ) {

                $post_ids[] = $key;

                if ( ! empty( $value ) ) {

                    _<%- pkgNameLowerCase -%>_get_course_steps_recursive( $value, $post_ids );

                }

            }
            else {

                _<%- pkgNameLowerCase -%>_get_course_steps_recursive( $value, $post_ids );

            }

        }

    }

}