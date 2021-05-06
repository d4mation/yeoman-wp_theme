<?php

$steps = 0;
$completed = 0;
if ( function_exists( 'learndash_get_course_steps_count' ) ) {

    $steps = learndash_get_course_steps_count( get_the_ID() );
    $completed = learndash_course_get_completed_steps( get_current_user_id(), get_the_ID() );

}

if ( ! isset( $show_category ) ) : 

    $show_category = false;

endif;

if ( ! isset( $show_completion ) ) : 

    $show_completion = false;

endif;

if ( ! isset( $date_format ) ) : 

    $date_format = get_option( 'date_format', 'F, j Y' );

endif;

if ( ! isset( $show_price ) ) : 

    $show_price = false;

endif;

if ( function_exists( 'sfwd_lms_has_access' ) && ! sfwd_lms_has_access( get_the_ID(), get_current_user_id() ) ) {
    $show_completion = false;
}

if ( function_exists( 'sfwd_lms_has_access' ) && sfwd_lms_has_access( get_the_ID(), get_current_user_id() ) ) {
    $show_price = false;
}

if ( ! isset( $column_class ) ) : 
    $column_class = 'medium-6 large-4';
endif; ?>

<?php

    $post_classes = array(
        'small-12',
        $column_class,
        'course',
        'cell',
    );

    if ( $show_price ) {
        $post_classes[] = 'show-price';
    }
    
?>

<div <?php post_class( $post_classes ); ?>>

    <?php if ( $show_category ) : 

        $terms = wp_get_post_terms( get_the_ID(), 'ld_course_category', array() );

        foreach ( $terms as $term ) : ?>

            <h6>
                <?php echo $term->name; ?>
            </h6>

        <?php endforeach; ?>
    
    <?php endif; ?>

    <?php

        $product_id = false;

        if ( $show_price ) {

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

        }

    ?>

    <h5 class="course-title">
        <a class="course-title-link" href="<?php echo get_the_permalink( get_the_ID() ) ;?>">
            <?php if ( $show_price && ! $product_id ) : ?>
                <?php if ( ! is_user_logged_in() || ( function_exists( 'sfwd_lms_has_access' ) && ! sfwd_lms_has_access( get_the_ID(), get_current_user_id() ) ) ) : ?>
                    <span class="fas fa-lock"></span>
                <?php endif; ?>
            <?php endif; ?>
            <span class="text-container">
                <?php echo get_the_title( get_the_ID() ); ?>
            </span>
        </a>
    </h5>

    <?php if ( $show_price ) : ?>

        <?php add_filter( 'excerpt_length', '<%- pkgNameLowerCase -%>_cell_excerpt_length' ); ?>
        <?php echo apply_filters( 'the_content', get_the_excerpt( get_the_ID() ) ); ?>
        <?php remove_filter( 'excerpt_length', '<%- pkgNameLowerCase -%>_cell_excerpt_length' ); ?>

        <?php 

            if ( $product_id && function_exists( 'wc_get_product' ) ) : 

                global $product;

                $product = wc_get_product( $product_id );

                woocommerce_template_loop_price();

                woocommerce_template_loop_add_to_cart();
            
            endif;

        ?>

    <?php endif; ?>

    <?php if ( $show_completion ) : ?>

        <?php if ( $steps == $completed ) : ?>

            <p>

                <span class="kmcu-icon checkbox"></span><?php _e( 'Complete', '<%- textDomain -%>' ); ?>


            </p>

        <?php else : ?>

            <div class="progress" role="progressbar" tabindex="0" aria-valuenow="<?php echo ( $completed / $steps ) * 100; ?>" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-meter" style="width: <?php echo ( $completed / $steps ) * 100; ?>%;"></div>
            </div>

            <p>

                <?php if ( ! $completed ) : ?>

                    <?php printf( '%d %s', $steps, ( ( $steps > 1 ) ? __( 'steps', '<%- textDomain -%>' ) : __( 'step', '<%- textDomain -%>' ) ) ); ?>

                <?php else : ?>

                    <?php printf( '%d/%d %s', $completed, $steps, ( ( $steps > 1 ) ? __( 'steps', '<%- textDomain -%>' ) : __( 'step', '<%- textDomain -%>' ) ) ); ?>

                <?php endif; ?>

            </p>

        <?php endif; ?>

    <?php endif; ?>

</div>