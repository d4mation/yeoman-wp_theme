<?php
/**
 * Register Menus
 *
 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus#Examples
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

register_nav_menus(
	array(
        'main'  => esc_html__( 'Main Nav Bar', '<%- textDomain -%>' ),
        //'top-bar' => esc_html__( 'Top Bar', '<%- textDomain -%>' ),
        'account-nav' => esc_html__( 'Account Nav', '<%- textDomain -%>' ),
        'footer-top' => esc_html__( 'Footer Top', '<%- textDomain -%>' ),
        'footer-bottom' => esc_html__( 'Footer Bottom', '<%- textDomain -%>' ),
		//'mobile-nav' => esc_html__( 'Mobile', '<%- textDomain -%>' ),
	)
);


/**
 * Desktop navigation - Main Nav
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( '<%- pkgNameLowerCase -%>_main_nav' ) ) {
	function <%- pkgNameLowerCase -%>_main_nav() {

		wp_nav_menu(
			array(
				'container'      => false,
				'menu_class'     => 'dropdown menu desktop-menu',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
				'theme_location' => 'main',
				'depth'          => 3,
				'fallback_cb'    => false,
				'walker'         => new Foundationpress_Top_Bar_Walker(),
			)
		);
	}
}

/**
 * Navigation - Top bar
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( '<%- pkgNameLowerCase -%>_top_nav' ) ) {
	function <%- pkgNameLowerCase -%>_top_nav() {
		wp_nav_menu(
			array(
				'container'      => false,
				'menu_class'     => 'dropdown menu top-nav',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
				'theme_location' => 'top-bar',
				'depth'          => 3,
				'fallback_cb'    => false,
				'walker'         => new Foundationpress_Top_Bar_Walker(),
			)
		);
	}
}

/**
 * Navigation - Account Nav
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( '<%- pkgNameLowerCase -%>_account_nav' ) ) {
	function <%- pkgNameLowerCase -%>_account_nav( $desktop = true ) {

		wp_nav_menu(
			array(
				'container'      => false,
				'menu_class'     => ( ( $desktop ) ? 'show-for-medium dropdown ' : 'vertical ' ) . 'menu' . ( ( $desktop ) ? ' account-nav' : ' account-nav-mobile' ),
				'items_wrap'     => '<ul id="%1$s" class="%2$s"' . ( ( $desktop ) ? ' data-dropdown-menu' : ' data-accordion-menu data-submenu-toggle="true"' ) . '>%3$s</ul>',
				'theme_location' => 'account-nav',
				'depth'          => 3,
                'fallback_cb'    => false,
				'walker'         => ( $desktop ) ? new Foundationpress_Top_Bar_Walker() : new Foundationpress_Mobile_Walker(),
			)
		);
	}
}

/**
 * Generates a fake Menu Item given parameters
 *
 * @param   integer|string  $post_id    Post ID. Give it a String name if no Post exists
 * @param   string|boolean  $title      Title. Set it to false to grab one via Post ID
 * @param   string|boolean  $url        URL. Set it to false to grab one via Post ID
 * @param   integer:boolean $parent_id  Parent ID. Set to 0 for top-level
 *
 * @since   {{VERSION}}
 * @return  object                      Menu Item Object
 */
function <%- pkgNameLowerCase -%>_generate_menu_item( $post_id, $title = false, $url = false, $parent_id = 0, $children = array() ) {

    $menu_item = new stdClass();
    $menu_item->menu_item_parent = $parent_id;
    $menu_item->post_parent = $parent_id;
    $menu_item->classes = 'menu-item';
    $menu_item->target = '';
    $menu_item->xfn = '';

    $menu_item->ID = $post_id;
    $menu_item->db_id = $menu_item->ID;
    $menu_item->object_id = $menu_item->ID;

    if ( ! $url ) {
        $menu_item->url = get_permalink( $post_id );
    }
    else {
        $menu_item->url = $url;
    }

    if ( ! $title ) {
        $title = get_the_title( $post_id );
    }

    $menu_item->title = $title;

    global $wp_query;
    $queried_object_id = (int) $wp_query->queried_object_id;

    $children_ids = array_map( function( $item ) {
        return $item->ID;
    }, $children );

    $menu_item->current = ( $queried_object_id == $post_id ) ? true : false;
    $menu_item->current_item_ancestor = ( in_array( $queried_object_id, $children_ids ) ) ? true : false;

    return $menu_item;

}

add_filter( 'wp_nav_menu_items', '<%- pkgNameLowerCase -%>_top_nav_add_cart_icon', 10, 2 );

function <%- pkgNameLowerCase -%>_top_nav_add_cart_icon( $html, $args ) {

	if ( is_admin() ) return $html;

    if ( $args->theme_location !== 'account-nav' ) return $html;

    if ( ! function_exists( 'WC' ) ) return $html;
    
    ob_start();
    get_template_part( 'template-parts/cart', 'icon' );

	return $html . ob_get_clean();

}

function <%- pkgNameLowerCase -%>_footer_top_menu_fallback() {

    ?>

    <ul class="vertical menu footer-top-menu">

    <?php

    $template = locate_template( 'template-parts/login-button.php', false, false );

    if ( $template ) {
        include $template;
    }

    ?>

    </ul>

    <?php

}

/**
 * Desktop navigation - Footer top
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( '<%- pkgNameLowerCase -%>_footer_top_menu' ) ) {
	function <%- pkgNameLowerCase -%>_footer_top_menu() {
		wp_nav_menu(
			array(
				'container'      => false,
				'menu_class'     => 'menu vertical footer-top-menu',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'theme_location' => 'footer-top',
				'depth'          => 3,
				'fallback_cb'    => '<%- pkgNameLowerCase -%>_footer_top_menu_fallback',
			)
		);
	}
}

/**
 * Desktop navigation - Footer bottom
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( '<%- pkgNameLowerCase -%>_footer_bottom_menu' ) ) {
	function <%- pkgNameLowerCase -%>_footer_bottom_menu() {
		wp_nav_menu(
			array(
				'container'      => false,
				'menu_class'     => 'menu footer-bottom-menu',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'theme_location' => 'footer-bottom',
				'depth'          => 3,
				'fallback_cb'    => false,
				'walker'         => new Foundationpress_Top_Bar_Walker(),
			)
		);
	}
}

/**
 * Mobile navigation - topbar (default) or offcanvas
 */
if ( ! function_exists( '<%- pkgNameLowerCase -%>_mobile_nav' ) ) {
	function <%- pkgNameLowerCase -%>_mobile_nav() {

		wp_nav_menu(
			array(
				'container'      => false,                         // Remove nav container
				'menu'           => __( 'mobile-nav', '<%- textDomain -%>' ),
				'menu_class'     => 'vertical menu',
				'theme_location' => 'main',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true">%3$s</ul>',
				'fallback_cb'    => false,
				'walker'         => new Foundationpress_Mobile_Walker(),
			)
		);
	}
}


/**
 * Add support for buttons in the top-bar menu:
 * 1) In WordPress admin, go to Apperance -> Menus.
 * 2) Click 'Screen Options' from the top panel and enable 'CSS CLasses' and 'Link Relationship (XFN)'
 * 3) On your menu item, type 'has-form' in the CSS-classes field. Type 'button' in the XFN field
 * 4) Save Menu. Your menu item will now appear as a button in your top-menu
*/
if ( ! function_exists( '<%- pkgNameLowerCase -%>_add_menuclass' ) ) {
	function <%- pkgNameLowerCase -%>_add_menuclass( $ulclass ) {
		$find    = array( '/<a rel="button"/', '/<a title=".*?" rel="button"/' );
		$replace = array( '<a rel="button" class="button"', '<a rel="button" class="button"' );

		return preg_replace( $find, $replace, $ulclass, 1 );
	}
	add_filter( 'wp_nav_menu', '<%- pkgNameLowerCase -%>_add_menuclass' );
}

function <%- pkgNameLowerCase -%>_custom_breadcrumbs() {
 
    $delimiter = __( ' &raquo; ', '<%- textDomain -%>' ); // delimiter between miscellaneous things
    $home = __( 'Home', '<%- textDomain -%>' ); // text for the 'Home' link
    $show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before_current = '<li><span class="show-for-sr">' . __( 'Current:', '<%- textDomain -%>' ) . ' </span>'; // tag before the current crumb
    $before = '<li>'; // tag before every crumb
	$after = '</li>'; // tag after the current crumb
	
    if ( is_front_page() ) return false;
    global $post;
    $home_link = get_bloginfo( 'url' );
	
	global $wp_query;
	
?>
 
    <nav aria-label="<?php _e( 'You are here:', '<%- textDomain -%>' ); ?>" role="navigation">
        <ul class="breadcrumbs">
            <li><a href="<?php echo $home_link; ?>"><?php echo $home; ?></a></li>

            <?php
            if ( is_home() ) { // Since we have a static front page, this is actually for the Blog
                echo $before_current . get_the_title() . $after;
                
            }
			elseif ( is_404() ) {
                echo $before_current . __( 'Error 404', '<%- textDomain -%>' ) . $after;
            }
            elseif ( is_category() ) {
                
                $this_cat = get_category( get_query_var( 'cat' ), false );
                if ( $this_cat->parent != 0 ) echo get_category_parents( $this_cat->parent, TRUE, $delimiter );
                $post_type = get_post_type_object( get_post_type() );

                if ( $post_type ) {
                    echo $before . '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . $post_type->labels->menu_name . '</a>' . $after;
                    echo $before_current . sprintf( __( '"%s" Archives', '<%- textDomain -%>' ), single_cat_title( '', false ) ) . $after;
                }
            }
            elseif ( is_search() ) {
                echo $before_current . sprintf( __( 'Search results for "%s"', '<%- textDomain -%>' ), get_search_query() ) . $after;
            }
            elseif ( is_day() ) {
                $post_type = get_post_type_object( get_post_type() );
                echo $before . '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . $post_type->labels->menu_name . '</a>' . $after;
                echo $before . '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $after;
                echo $before . '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a>' . $after;
                echo $before_current . get_the_time( 'd' ) . $after;
            }
            elseif ( is_month() ) {
                $post_type = get_post_type_object( get_post_type() );
                echo $before . '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . $post_type->labels->menu_name . '</a>' . $after;
                echo $before . '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $after;
                echo $before_current . get_the_time( 'F' ) . $after;
            }
            elseif ( is_year() ) {
                $post_type = get_post_type_object( get_post_type() );
                echo $before . '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . $post_type->labels->menu_name . '</a>' . $after;
                echo $before_current . get_the_time( 'Y' ) . $after;
            }
            elseif ( is_page() && ! $post->post_parent ) {
                if ( $show_current == 1) echo $before_current . get_the_title() . $after;
            }
            elseif ( ( is_page() ) && $post->post_parent ) {

                $parent_id  = $post->post_parent;
                $breadcrumbs = array();

                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = $before . '<a href="' . get_permalink( $page->ID ) . '">' . $page->post_title . '</a>' . $after;
                    $parent_id  = $page->post_parent;
                }

                $breadcrumbs = array_reverse( $breadcrumbs );
                for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
                    echo $breadcrumbs[$i];
                    
                }
                if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
            }
            elseif ( is_single() && ! is_attachment() ) {
                // Since we used Page Templates for most Archives (To allow a Content Editor), we need to make our own Breadcrumbs for each
                
				if ( get_post_type() == 'tribe_events' ) {
					
					echo $before . tribe_get_event_label_plural() . $after;
					if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
					
				}
				else if ( get_post_type() == 'wp_router_page' ) {
					
					if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
					
                }
                else if ( get_post_type() == 'page' ) {
					
					if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
					
                }
                else if ( get_post_type() == 'product' ) {

                    echo $before . '<a href="' . wc_get_page_permalink( 'shop' ) . '">' . __( 'The Store', '<%- textDomain -%>' ) . '</a>' . $after;

                    if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;

                }
                else if ( in_array( get_post_type(), array( 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic', 'sfwd-quiz' ) ) ) {

                    if ( get_post_type() == 'sfwd-courses' ) {

                        if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;

                    }
                    else {

                        $course_id = learndash_get_course_id( get_the_ID() );

                        echo $before . '<a href="' . get_the_permalink( $course_id ) . '">' . get_the_title( $course_id ) . '</a>' . $after;

                        if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;

                    }

                }
				else if ( get_post_type() != 'post' ) {

                    $post_type = get_post_type_object( get_post_type() );
                    
                    if ( $post_type->has_archive ) {
                    
                        $slug = $post_type->rewrite;
                        echo $before . '<a href="' . $home_link . '/' . $slug['slug'] . '/">' . $post_type->labels->name . '</a>' . $after;
                    }
                    else {
                        echo $before . $post_type->labels->name . $after;
                    }
					
					if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
					
                }
                else if ( get_post_type() == 'post' ) {
                    $post_type = get_post_type_object( get_post_type() );
                    echo $before . '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . $post_type->labels->menu_name . '</a>' . $after;
                    if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
                }
                else {
                    $cat = get_the_category(); $cat = $cat[0];
                    $cats = get_category_parents( $cat, TRUE, $delimiter );
                    if ( $show_current == 0 ) $cats = preg_replace( "#^(.+)\s$delimiter\s$#", "$1", $cats );
                    echo $cats;
                    if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
                }
            } 
            elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
				
				// Events Calendar always reports that it is a Page, so it hijacks your Page template
				if ( isset( $wp_query->query['post_type'] ) && $wp_query->query['post_type'] == 'tribe_events' ) {
					$post_type = 'tribe_events';
				}
				else {
                	$post_type = get_post_type();
				}
				
				$post_type = get_post_type_object( $post_type );
				
                echo $before_current . $post_type->labels->name . $after;
				
            }
            elseif ( is_attachment() ) {
                $parent = get_post( $post->post_parent );
                $cat = get_the_category( $parent->ID ); $cat = $cat[0];
                
                echo $before . get_category_parents( $cat, TRUE, $delimiter );
                echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>' . $after;
                if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
            }
            elseif ( is_tag() ) {
                echo $before_current . sprintf( __( 'Posts tagged "%s"', '<%- textDomain -%>' ), single_tag_title( '', false ) ) . $after;
            }
            elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata( $author );
                echo $before_current . sprintf( __( 'Articles posted by %s', '<%- textDomain -%>' ), $userdata->display_name ) . $after;
            }
            
            if ( get_query_var( 'paged' ) ) {
                
                echo $before;
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                echo sprintf( __( 'Page %d', '<%- textDomain -%>' ), get_query_var( 'paged' ) );
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
                
                echo $after;
            }
            ?>

        </ul>
</nav>

<?php
}