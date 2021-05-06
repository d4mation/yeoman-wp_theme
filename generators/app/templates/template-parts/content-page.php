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
	<div class="entry-content">
		<?php the_content(); ?>
		<?php edit_post_link( __( '(Edit)', '<%- textDomain -%>' ), '<span class="edit-link">', '</span>' ); ?>
	</div>
	<footer>
		<?php
			wp_link_pages(
				array(
					'before' => '<nav id="page-nav"><p>' . __( 'Pages:', '<%- textDomain -%>' ),
					'after'  => '</p></nav>',
				)
			);
		?>
	</footer>
</article>

<?php if ( is_single() ) : ?>

	<?php the_post_navigation(); ?>

<?php endif; ?>