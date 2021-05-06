( function( $ ) {

    let $products = $( '.woocommerce ul.products li.product' );

    if ( $products.length < 1 ) return;

    $products.closest( 'ul.products' ).attr( 'data-equalizer', true ).attr( 'data-equalize-on', 'medium' ).attr( 'data-equalize-on-stack', 'true' );

    $products.each( function( index, product ) {
        $( product ).attr( 'data-equalizer-watch', true );
    } );

    let equalizer = new Foundation.Equalizer( $products.closest( 'ul.products' ) );

} )( jQuery );