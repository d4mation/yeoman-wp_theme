<?php
/**
 * Post Sidebar
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

$term_query = new WP_Term_query( array(
    'taxonomy' => 'category',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => '<%- pkgNameLowerCase -%>_color',
            'compare' => 'EXISTS',
        ),
        array(
            'key' => '<%- pkgNameLowerCase -%>_color',
            'compare' => '!=',
            'value' => '',
        ),
        array(
            'key' => '<%- pkgNameLowerCase -%>_icon',
            'compare' => 'EXISTS',
        ),
        array(
            'key' => '<%- pkgNameLowerCase -%>_icon',
            'compare' => '!=',
            'value' => '',
        ),
    ),
    'orderby' => 'tax_position',
    'order' => 'ASC',
    //'hide_empty' => false,
) );

?>
<aside class="sidebar posts <?php echo ( ( is_single() || is_singular() ) && get_post_meta( get_the_ID(), '_wp_page_template', true ) !== 'page-templates/page-sidebar-left.php' ) ? 'small-order-1 medium-order-2' : 'small-order-1 medium-order-1'; ?>">

    <div class="show-for-small-only">

        <ul class="accordion" data-accordion data-allow-all-closed="true">

            <li class="accordion-item" data-accordion-item>

                <a href="#" class="accordion-title">
                    <?php _e( 'Catagories', '<%- textDomain -%>' ); ?>
                </a>

                <div class="accordion-content" data-tab-content>
                    <?php

                        if ( $term_query->get_terms() ) {

                            foreach ( $term_query->get_terms() as $term ) : 

                                $color = get_term_meta( $term->term_id, '<%- pkgNameLowerCase -%>_color', true );
                            
                                ?>

                                <style type="text/css">

                                    .sidebar.posts .category-block.category-<?php echo $term->term_id; ?> {

                                        border-color: <?php echo $color; ?>;
                                        color: <?php echo $color; ?>;

                                    }

                                    .sidebar.posts .category-block.category-<?php echo $term->term_id; ?>:hover, .sidebar.posts .category-block.category-<?php echo $term->term_id; ?>:focus {
                                        
                                        border-color: <?php echo <%- pkgNameLowerCase -%>_smart_scale( $color, 14 ); ?>;
                                        color: <?php echo <%- pkgNameLowerCase -%>_smart_scale( $color, 14 ); ?>;

                                    }

                                </style>

                                <a class="category-block category-<?php echo $term->term_id; ?>" href="<?php echo get_term_link( $term, 'category' ); ?>">

                                    <span class="<?php echo esc_attr( get_term_meta( $term->term_id, '<%- pkgNameLowerCase -%>_icon', true ) ); ?>"></span>

                                    <?php echo $term->name; ?>

                                </a>

                            <?php endforeach; 

                        }

                    ?> 
                </div>

            </li>

        </ul>

    </div>

    <div class="show-for-medium">

        <h6 class="subheader">
            <?php _e( 'Categories', '<%- textDomain -%>' ); ?>
        </h6>
        
        <?php

            if ( $term_query->get_terms() ) {

                foreach ( $term_query->get_terms() as $term ) : ?>

                    <a class="category-block category-<?php echo $term->term_id; ?>" href="<?php echo get_term_link( $term, 'category' ); ?>">

                        <span class="<?php echo esc_attr( get_term_meta( $term->term_id, '<%- pkgNameLowerCase -%>_icon', true ) ); ?>"></span>

                        <?php echo $term->name; ?>

                    </a>

                <?php endforeach; 

            }

        ?>

    </div>

</aside>
