<?php
/**
 * The default template for displaying page content
 *
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( trim( $post->post_content ) ) : ?>
        <section class="entry-content">
            <?php the_content(); ?>
            <?php edit_post_link( __( '(Edit)', '<%- textDomain -%>' ), '<span class="edit-link">', '</span>' ); ?>
        </section>
    <?php endif; ?>

</article>