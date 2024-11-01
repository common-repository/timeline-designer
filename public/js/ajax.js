"use strict";
jQuery( document ).ready(
	function(){
		(function($){

			if (jQuery( '.chosen-select' ).length > 0) {
				var config = {
					'.chosen-select': {},
					'.chosen-select-deselect': {allow_single_deselect: true},
					'.chosen-select-no-single': {disable_search_threshold: 10},
					'.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
					'.chosen-select-width': {width: "95%"}
				}
				jQuery( ".chosen-select" ).chosen();
			}
			jQuery(
				function () {
					var elems     = jQuery( '.animateblock' );
					var winheight = jQuery( window ).height();
					elems.each(
						function () {
							var elm       = jQuery( this );
							var topcoords = elm.offset().top;
							if (topcoords < winheight) {
								// animate when top of the window is 3/4 above the element
								elm.addClass( 'animated' );
								elm.removeClass( 'animateblock' );
							}
						}
					);

					jQuery( '.timeline' ).each(
						function () {
							if (jQuery( this ).offset().top < winheight) {
								var width = jQuery( this ).attr( 'data-width' );
								jQuery( this ).animate(
									{
										width: width
									},
									1000
								);
							}
						}
					);

					jQuery( window ).scroll(
						function () {
							wtl_animate_elems();
						}
					);

				}
			);
		}(jQuery))
	}
);

// For load more functionality

jQuery(
	function () {
		easy_timeline_effects();
		social_share_div();
	}
);

function social_share_div() {
	var maxWidth = Math.max.apply(
		null,
		jQuery( '.post-media' ).map(
			function () {
				return jQuery( this ).width();
			}
		).get()
	);
	maxWidth     = (maxWidth / 2) + 10;
	var cusstyle = '<style> .post-content-area:before { border-left-width: ' + Math.round( maxWidth ) + 'px; } .post-media:before { border-right-width: ' + Math.round( maxWidth ) + 'px; } .post-media:after { border-left-width: ' + Math.round( maxWidth ) + 'px; } </style>'
	jQuery( 'head' ).append( cusstyle );
}

function easy_timeline_effects() {
	var effect = jQuery( '.easy-timeline' ).attr( 'data-effect' );
	jQuery( '.easy-timeline li' ).each(
		function () {
			if (jQuery( this ).offset().top > jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75) {
				jQuery( this ).addClass( 'is-hidden' );
			} else {
				jQuery( this ).addClass( effect );
			}
		}
	);

	jQuery( window ).on(
		'scroll',
		function () {
			jQuery( '.easy-timeline li' ).each(
				function () {
					if ((jQuery( this ).offset().top <= (jQuery( window ).scrollTop() + jQuery( window ).height() * 0.75)) && jQuery( this ).hasClass( "is-hidden" )) {
						jQuery( this ).removeClass( "is-hidden" ).addClass( effect );
					}
				}
			);
		}
	);
}

function wtl_animate_elems() {
	var elems     = jQuery( '.animateblock' );
	var winheight = jQuery( window ).height();
	var wintop    = jQuery( window ).scrollTop(); // calculate distance from top of window

	// loop through each item to check when it animates
	elems.each(
		function () {
			var elm = jQuery( this );
			if (elm.hasClass( 'animated' )) {
				return true;
			} // if already animated skip to the next item
			var topcoords = elm.offset().top; // element's distance from top of page in pixels
			if (wintop > (topcoords - (winheight * 0.6))) {
				// animate when top of the window is 3/4 above the element
				elm.addClass( 'animated' );
				elm.removeClass( 'animateblock' );
			}
		}
	);
	jQuery( '.timeline' ).each(
		function () {
			if (wintop > jQuery( this ).offset().top - winheight) {
				var width = jQuery( this ).attr( 'data-width' );
				jQuery( this ).animate(
					{
						width: width
					},
					500
				);
			}
		}
	);
}



jQuery( window ).on(
	'load',
	function () {
		if (jQuery( '.masonry' ).length > 0) {
			setTimeout(
				function () {
					jQuery( '.masonry' ).imagesLoaded(
						function () {
							jQuery( '.masonry' ).masonry(
								{
									columnWidth: 0,
									itemSelector: '.blog_masonry_item',
									isResizable: true
								}
							);
						}
					);
				},
				500
			);
		}
	}
);
