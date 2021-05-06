import { getScreenSize } from './screen-size';

( function( $ ) {

    if ( $( '.enable-tab-links' ).length < 1 ) return;

    $( document ).on( 'click touch', '.enable-tab-links .tabs-title a [data-href]', function( event ) {

        if ( getScreenSize() == 'small' ) return;

        window.location.href = $( this ).attr( 'data-href' );

    } );

    $( '.enable-tab-links' ).on( 'change.zf.tabs', function( event, $target ) {

        $( this ).closest( '.enable-tab-links' ).find( '[data-href]' ).attr( 'tabindex', '-1' );
        $( this ).closest( '.enable-tab-links' ).find( '.progress' ).attr( 'tabindex', '-1' );

        $target.find( '[data-href]' ).attr( 'tabindex', '0' );
        $target.find( '.progress' ).attr( 'tabindex', '0' );

    } );

} )( jQuery );