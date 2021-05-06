( function( $ ) {
    
    var loaded = false,
    $posts = false;
    
    // Ensure this does not fire on page load
    $( document ).on( 'facetwp-refresh', function() {
        
        if ( loaded ) {
            
            $posts.each( function( index, element ) {
                Foundation.Motion.animateOut( element, 'scale-out-down' );
            } );
            
        }
        else {
            loaded = true;
        }
        
    } );
    
    $( document ).on( 'facetwp-loaded', function() {
        
        $posts = $( '.facetwp-template' ).find( '[class*="post-"], [class*="category-"]' );
        
        $posts.each( function( index, element ) {
            Foundation.Motion.animateIn( element, 'scale-in-up' );
        } );
        
        setTimeout( function() {
            
            $( document ).trigger( 'facetwp-animations-done' );
            
        }, 250 ); // Wait until animation finishes, 500ms is Motion-UI default
        
    } );
    
    $( document ).on( 'facetwp-animations-done', function() {
        
        $( '.facetwp-template iframe' ).each( function( index, element ) {
            
            // Force reload. Fixes some weird browser cache issues when hitting the back button
            $( element ).attr( 'src', $( element ).attr( 'src' ) );
            
        } );
        
    } );
    
} )( jQuery );