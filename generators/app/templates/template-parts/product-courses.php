<?php
/**
 * Displays Courses associated with a Product
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

?>

<div class="small-12 cell product-courses">

    <h2>
        <?php _e( 'Courses included:', '<%- textDomain -%>' ); ?>
    </h2>

    <div class="grid-x grid-margin-x">

        <?php 

        global $post;
        $old_post = $post;

        foreach ( $courses as $course_id ) : 

            $post = get_post( $course_id );
            setup_postdata( $course_id ); ?>

            <div class="small-12 medium-6 large-4 cell product-course-<?php echo $course_id; ?>">

                <h5>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h5>

                <?php add_filter( 'excerpt_length', '<%- pkgNameLowerCase -%>_cell_excerpt_length' ); ?>
                <?php the_excerpt(); ?>
                <?php remove_filter( 'excerpt_length', '<%- pkgNameLowerCase -%>_cell_excerpt_length' ); ?>
        
            </div>

        <?php 
        
        endforeach; 

        $post = $old_post;
        wp_reset_postdata();
        
        ?>

    </div>

</div>