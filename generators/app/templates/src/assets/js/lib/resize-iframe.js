/**
 * Resizes an iFrame to fit the width of its Parent and adjusts the height to match the original Aspect Ratio
 * 
 * @param		object iFrame DOM Object of the iFrame
 * @since		{{VERSION}}
 * @return		void
 */
window['resizeIframe'] = function( iFrame ) {
	
	var $el = jQuery( iFrame ),
		newWidth = $el.parent().width();
	
	if ( ! $el.data( 'aspectRatio' ) ) {
		
		$el
			.data( 'aspectRatio', iFrame.height / iFrame.width )
			
			// and remove the hard coded width/height
			.removeAttr( 'height' )
			.removeAttr( 'width' );
		
	}

	$el
		.width( newWidth )
		.height( newWidth * $el.data( 'aspectRatio' ) );
	
};

( function( $ ) {

	// Find all YouTube videos
	var $allVideos = $( 'iframe:not(.ignore-responsive)' );

	// When the window is resized
	// (You'll probably want to debounce this)
	$( window ).resize( function() {
		
		// Resize all videos according to their own aspect ratio
		$allVideos.each( function() {

			window.resizeIframe( this );

		} );

	// Kick off one resize to fix all videos on page load
	} ).resize();
	
	// Ensure any accordions holding YouTube videos properly resize
	$( 'ul.accordion, ul.tabs' ).on( 'down.zf.accordion change.zf.tabs', function() {
		
		// Resize all videos according to their own aspect ratio
		$allVideos.each( function() {

			window.resizeIframe( this );

		} );
		
	} );

} )( jQuery );