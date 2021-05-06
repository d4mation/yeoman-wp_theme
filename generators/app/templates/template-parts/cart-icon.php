<?php

$cart_count = WC()->cart->cart_contents_count;
$cart_url = wc_get_cart_url();

?>

<li class="cart-contents menu-item<?php echo ( $cart_count > 0 ) ? ' has-contents' : ''; ?>" role="none">
    <a href="<?php echo esc_url( $cart_url ); ?>" role="menuitem">
        <span class="fas fa-shopping-cart"></span>
        <?php _e( 'Cart', '<%- textDomain -%>' ); ?>
        <?php if ( $cart_count > 0 ) : ?>
            <span class="cart-contents-count">
                (<?php echo esc_html( $cart_count ); ?>)
            </span>
        <?php endif; ?>
    </a>
</li>