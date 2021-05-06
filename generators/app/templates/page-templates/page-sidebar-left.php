<?php
/*
Template Name: Left Sidebar
*/
get_header(); ?>

<?php get_template_part( 'template-parts/page-title', '' ); ?>
<div class="main-container">
	<div class="main-grid sidebar-left">
		<?php get_sidebar(); ?>
		<main class="main-content small-order-2 medium-order-2">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</main>
	</div>
</div>
<?php get_footer();
