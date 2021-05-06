<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

get_header(); ?>

<?php get_template_part( 'template-parts/page-title', '' ); ?>
<div class="main-container">
	<div class="main-grid">
		<main class="main-content-full-width">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</main>
	</div>
</div>
<?php get_footer();
