<li class="menu-item" role="none">
    <?php if ( is_user_logged_in() ) : ?>
        <a href="<?php echo esc_url( wp_logout_url() ); ?>" role="menuitem">
            <?php _e( 'Log Out', '<%- textDomain -%>' ); ?>
        </a>
    <?php else : ?>
        <a href="<?php echo esc_url( wp_login_url() ); ?>" role="menuitem">
            <?php _e( 'Log In', '<%- textDomain -%>' ); ?>
        </a>
    <?php endif; ?>
</li>