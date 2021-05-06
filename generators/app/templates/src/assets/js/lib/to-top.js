( function( $ ) {
    'use strict';
    
    var $to_top;
    
    $( function() {
        
        $to_top = $( '#to-top' );
        
        $to_top.on( 'click', function() {
            $( 'body, html' ).animate( { scrollTop: 0 }, 1000 );
        } );
        
        show();
    } );
    
    $( window ).on( 'scroll', show );
    
    function show() {
        
        if ( ! $to_top || ! $to_top.length ) {
            return;
        }
        
        if ( $( window ).scrollTop() > $( window ).height() ) {
            $to_top.addClass( 'loaded' );
            $to_top.addClass( 'in' );
        }
        else {
            $to_top.removeClass( 'in' );
        }
    }
    
} )( jQuery );