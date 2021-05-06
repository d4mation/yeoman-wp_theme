<?php
/**
 * The sidebar containing the course widget area
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */
?>
<aside class="sidebar <?php echo ( ( is_single() || is_singular() ) && get_post_meta( get_the_ID(), '_wp_page_template', true ) !== 'page-templates/page-sidebar-left.php' ) ? 'small-order-1 medium-order-2' : 'small-order-1 medium-order-1'; ?>">
	<?php dynamic_sidebar( 'course-sidebar' ); ?>
</aside>
