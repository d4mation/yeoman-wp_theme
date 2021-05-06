( function( $ ) {
    
    /**
     * At some point, Foundation stopped supporting <a> as a Dropdown Trigger when using keyboard navigation. Mouse still works, but keyboard is broken.
     * 
     * It worked in Foundation 6.3.1, but is not working in 6.6.3. I am not sure when exactly it broke.
     * 
     * Example of it working at one point: https://get.foundation/building-blocks/blocks/topbar-mega-menu-dropdown.html
     * 
     * This helps restore that functionality, somewhat.
     * 
     * @param   object  event     Event Object
     *
     * @since   {{VERSION}}
     * @return  void
     */
    $( document ).on( 'keydown', function( event ) {

        let space = 32,
            enter = 13,
            keycode = ( typeof event.code !== 'undefined' ) ? event.code : event.keyCode;

        // Not an anchor
        if ( ! $( document.activeElement ).is( 'a' ) ) return;

        // Not a toggle
        if ( ! $( document.activeElement ).attr( 'data-toggle' ) ) return;

        // Not hitting space or enter
        if ( keycode !== space && keycode !== enter ) return;

        // Hitting enter, but it isn't a page anchor
        if ( keycode == enter && $( document.activeElement ).attr( 'href' ).indexOf( '#' ) !== 0 ) return;

        event.preventDefault();

        let dropdownID = $( document.activeElement ).attr( 'data-toggle' );

        $( '#' + dropdownID ).foundation( 'toggle' );

    } );

} )( jQuery );