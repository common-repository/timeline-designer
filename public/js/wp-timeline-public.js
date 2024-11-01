;'use strict';var wptlpublic = {
	init:function(){
		$ = jQuery;
		this.do_height();
		this.run_flexslider();
	},
	do_height:function(){
		a = this;
		a.set_height();
		$( '.wtl-schedule-wrap' ).on( "bind",
			'DOMSubtreeModified',
			function(){
				a.set_height();
			}
		);
	},
	set_height:function(){
		$( '.wtl-schedule-meta-content' ).each(
			function(){
				h = $( this ).height();
				h = h + 'px';
				$( this ).parents( '.wtl-schedule-post-content' ).css( 'min-height',h );
				$( '.wtl_template_hire_layout .wtl-schedule-wrap:before' ).css( 'float','inherit' );
			}
		);
	},
	run_flexslider:function(){
		if ($( '.wtl-flexslider.flexslider' ).length > 0) {
			$( '.wtl-flexslider.flexslider' ).flexslider( {animation: "slide",controlNav: false} );
		}
	},

};
;(function( $ ) {
	$( window ).on(
		'load',
		function() {
			wptlpublic.init();
			if (typeof AOS != "undefined") {
				AOS.init( {startEvent: 'DOMContentLoaded'} );
			}

		}
	);

})( jQuery );

jQuery( document ).ready(
	function(){
		(function($){
			if (typeof AOS != "undefined") {
				AOS.init();
			}
		}(jQuery))
	}
);


// $(document).ready(function() {
// 	var title = $('.title');
	
// 	// Function to check if title exceeds two lines and add ellipsis if necessary
// 	function checkTitleOverflow() {
// 	  var titleHeight = title.height();
// 	  var lineHeight = parseInt(title.css('line-height'));
// 	  var titleLines = titleHeight / lineHeight;
	  
// 	  if (titleLines > 2) {
// 		// Calculate the maximum number of characters that can be displayed in two lines
// 		var maxChars = Math.floor((title.width() / parseInt(title.css('font-size'))) * 2);
// 		var originalText = title.text();
// 		// Truncate the text to fit in two lines
// 		var truncatedText = originalText.substring(0, maxChars - 3) + '...'; // Subtract 3 for the ellipsis
		
// 		// Apply truncated text with ellipsis
// 		title.text(truncatedText);
// 	  }
// 	}
	
// 	// Call the function when the document is ready and on window resize
// 	$(window).on('resize', function() {
// 	  checkTitleOverflow();
// 	});
	
// 	// Initial check when the document is ready
// 	checkTitleOverflow();
//   });
  