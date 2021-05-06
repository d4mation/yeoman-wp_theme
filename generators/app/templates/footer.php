<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package <%- pkgName %>
 * @since <%- pkgName %> {{VERSION}}
 */
?>

		<footer class="site-footer">
			<div class="footer-top">

				<div class="grid-container">
					<div class="grid-x grid-margin-x">

						<div class="small-12 medium-2 cell footer-logo text-center">

							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php echo <%- pkgNameLowerCase -%>_get_logo( 'footer' ); ?>
							</a>

						</div>

						<div class="small-12 medium-10 large-6 xlarge-5 cell footer-site-meta text-center medium-text-left">
							<h4><?php bloginfo( 'name' ); ?></h4>
							<?php echo get_theme_mod( '<%- pkgNameLowerCase -%>_footer_below_title', '<p style="font-size: 22px;"><strong><a href="tel:8558326562">(855) TEAM KMC</strong></a></p><p><a href="tel:8558326562">(855) 382-6562</a></p>' ); ?>
						</div>

						<div class="small-12 large-4 xlarge-5 cell footer-top-nav">
							<?php <%- pkgNameLowerCase -%>_footer_top_menu(); ?>
						</div>

					</div>
				</div>

			</div>
			<div class="footer-bottom">

				<div class="grid-container">
					<div class="grid-x grid-margin-x">

						<div class="social-media-cell small-12 large-3 cell text-center medium-text-left">
						
							<?php

							$facebook_link = get_theme_mod( '<%- pkgNameLowerCase -%>_facebook_link', false );
							$youtube_link = get_theme_mod( '<%- pkgNameLowerCase -%>_youtube_link', false );

							if ( $facebook_link || $youtube_link ) : ?>

								<ul class="menu">

							<?php endif;

							if ( $facebook_link ) : ?>

								<li>
									<a href="<?php echo esc_attr( $facebook_link ); ?>" class="social-media-link facebook" target="_blank">
										<?php _e( 'Facebook', '<%- textDomain -%>' ); ?>
									</a>
								</li>

							<?php endif;

							if ( $youtube_link ) : ?>

								<li>
									<a href="<?php echo esc_attr( $youtube_link ); ?>" class="social-media-link youtube" target="_blank">
										<?php _e( 'YouTube', '<%- textDomain -%>' ); ?>
									</a>
								</li>

							<?php endif; ?>

							<?php if ( $facebook_link || $youtube_link ) : ?>

								</ul>

							<?php endif; ?>

						</div>

						<div class="footer-copyright small-12 large-9 cell text-center medium-text-left large-text-right">

							<div class="footer-nav-container">

								<?php <%- pkgNameLowerCase -%>_footer_bottom_menu(); ?>

							</div>

							<div class="copyright-container">

								<?php
								
									printf( __( '&copy; KCMU University %d', '<%- textDomain -%>' ), current_time( 'Y' ) );

								?>

							</div>

						</div>

					</div>
				</div>

			</div>
		</footer>

		<?php do_action( '<%- pkgNameLowerCase -%>_off_canvas_content_end' ); ?>

	</div><!-- Close off-canvas content -->

	<button id="to-top">
		<div class="to-top-container">
			<span class="far fa-angle-up" aria-label="<?php _e( 'To top', '<%- textDomain -%>' ); ?>"></span>
		</div>
	</button>

<?php wp_footer(); ?>

</body>
</html>