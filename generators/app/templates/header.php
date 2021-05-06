<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */

?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

	<nav class="mobile-off-canvas-menu off-canvas position-right" id="<?php <%- pkgNameLowerCase -%>_mobile_menu_id(); ?>" data-off-canvas data-auto-focus="false" role="navigation">
		<?php get_search_form(); ?>
		<?php <%- pkgNameLowerCase -%>_mobile_nav(); ?>
		<div class="show-for-small-only">
			<?php <%- pkgNameLowerCase -%>_account_nav( false ); ?>
		</div>
	</nav>

	<div class="off-canvas-content" data-off-canvas-content>

		<header class="site-header" role="banner">

			<div class="top-menu-container">
				<div class="grid-container">
					<div class="grid-x grid-margin-x">
						<div class="small-12 cell">

							<div class="site-desktop-title top-bar-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
									<?php echo <%- pkgNameLowerCase -%>_get_logo( 'header' ); ?>
								</a>
							</div>

							<?php <%- pkgNameLowerCase -%>_account_nav( true ); ?>

							<div class="show-for-large search-form-container">
								<?php get_search_form(); ?>
							</div>

							<div class="hide-for-large menu-icon-container">
								<button type="button" data-toggle="<?php <%- pkgNameLowerCase -%>_mobile_menu_id(); ?>">
									<span class="menu-icon"></span>
									<span class="text-container">
										<?php _e( 'Menu', '<%- textDomain -%>' ); ?>
									</span>
								</button>
							</div>

						</div>
					</div>
				</div>
			</div>

			<nav class="site-navigation top-bar title-bar show-for-large" role="navigation" id="<?php <%- pkgNameLowerCase -%>_mobile_menu_id(); ?>">

				<div class="top-bar-left title-bar-left">
					<?php // Intentionally left empty ?>
				</div>

				<div class="top-bar-right title-bar-right">

					<div class="show-for-medium desktop-menu-container">
						<?php <%- pkgNameLowerCase -%>_main_nav(); ?>
					</div>

				</div>
			</nav>

		</header>