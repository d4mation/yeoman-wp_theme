<?php

global $wp_query;
global $post;

do_action( '<%- pkgNameLowerCase -%>_before_page_title' );

if ( <%- pkgNameLowerCase -%>_fieldhelpers() ) {

    $post_id = apply_filters( '<%- pkgNameLowerCase -%>_page_title_post_id', get_the_ID() );
    if ( function_exists( 'learndash_get_post_types' ) ) {
        if ( in_array( get_post_type(), learndash_get_post_types() ) ) {
            $post_id = apply_filters( '<%- pkgNameLowerCase -%>_page_title_post_id', learndash_get_course_id( $post_id ) );
        }
    }

    if ( is_home() ) {
        $post_id = apply_filters( '<%- pkgNameLowerCase -%>_page_title_post_id', get_queried_object_id() );
    }

}

$post_backup = $post;

if ( is_home() ) {
    $post = get_queried_object();
    $GLOBALS['post'] = $post;
}

?>

<header class="page-title-container" role="banner">

    <div class="grid-container">
        <div class="grid-x grid-margin-x">

            <div class="small-12 cell">

                <?php do_action( '<%- pkgNameLowerCase -%>_before_title' ); ?>

                <h1 class="page-title">

                    <?php if ( is_singular() || is_home() ) : ?>

                        <?php the_title(); ?>
                    
                    <?php elseif ( is_archive() ) : ?>
                        
                        <?php if ( is_post_type_archive() ) :
                        
                            $labels = get_post_type_labels( get_post_type_object( get_post_type() ) ); 

                            echo $labels->name;

                        endif;

                    endif;

                    if ( is_tax() ) :

                        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                        echo $term->name;

                    elseif ( is_a( get_queried_object(), 'WP_Term' ) ) :

                        echo get_queried_object()->name;

                    endif; ?>
                    
                </h1>

                <?php do_action( '<%- pkgNameLowerCase -%>_after_title' ); ?>

                <?php if ( apply_filters( '<%- pkgNameLowerCase -%>_show_breadcrumbs', true ) ) : ?>

                    <div class="breadcrumbs-container">
                        <?php <%- pkgNameLowerCase -%>_custom_breadcrumbs(); ?>
                    </div>

                <?php endif; ?>

            </div>

        </div>
    </div>

</header>

<?php

$post = $post_backup;
$GLOBALS['post'] = $post;

do_action( '<%- pkgNameLowerCase -%>_after_page_title' );