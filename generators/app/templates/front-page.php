<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

get_header(); 

?>

<div class="main-container">
	<div class="main-grid">
		<main class="main-content-full-width">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'front-page' ); ?>
			<?php endwhile; ?>
		</main>
	</div>
</div>

<?php get_footer();