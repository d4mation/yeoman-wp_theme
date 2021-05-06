<?php
/**
 * Blog template file
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

get_header(); 

$featured_shown = false;
$regular_shown = false;

?>

<?php get_template_part( 'template-parts/page-title', '' ); ?>
<div class="main-container">
	<div class="main-grid">
        <main class="main-content small-order-2 medium-order-1">
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php include locate_template( 'template-parts/content-post.php', false, false ); ?>
			<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; // End have_posts() check. ?>

			<?php /* Display navigation to next/previous pages when applicable */ ?>
			<?php
			if ( function_exists( '<%- pkgNameLowerCase -%>_pagination' ) ) :
			<%- pkgNameLowerCase -%>_pagination();
			elseif ( is_paged() ) :
			?>
				<nav id="post-nav">
					<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', '<%- textDomain -%>' ) ); ?></div>
					<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', '<%- textDomain -%>' ) ); ?></div>
				</nav>
			<?php endif; ?>

		</main>
		<?php get_sidebar( 'post' ); ?>

	</div>
</div>
<?php get_footer();
