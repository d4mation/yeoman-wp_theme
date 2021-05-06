import { Foundation } from './lib/foundation';

( function( $ ) {

    $( document ).foundation();

    $( window ).on( 'load resize', function() {

        if ( $( '.orbit' ).length < 1 ) return; 

        // wait for css
        $( '.orbit' ).foundation( '_reset' );

        $( '.orbit .orbit-slide' ).show();

        $( '.orbit' ).foundation( '_init' );

    } );

} )( jQuery );

import './lib/to-top';
import './lib/resize-iframe';
import './lib/enable-links-in-tabs';
import './lib/dropdown';
import './lib/woocommerce-product-listing-equalizer';
import './lib/facetwp-animations';