jQuery(document).ready(function($) {
	"use strict";

	$('.hoot-abouttheme-top').on('click',function(e){
		var $target = $( $(this).attr('href') );
		if ( $target.length ) {
			e.preventDefault();
			var destin = $target.offset().top - 50;
			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destin}, 500 );
		}
	});

	$('.hoot-abouttabs .nav-tab, .hoot-about-sub .linkto-tab, .hoot-abouttabs .linkto-tab').on('click',function(e){
		e.preventDefault();
		var targetid = $(this).data('tabid'),
			$navtabs = $('.hoot-abouttabs .nav-tab'),
			$tabs = $('.hoot-abouttabs .hoot-tab'),
			$target = $('#hoot-'+targetid);
		if ( $target.length ) {
			$navtabs.removeClass('nav-tab-active');
			$navtabs.filter('[data-tabid="'+targetid+'"]').addClass('nav-tab-active');
			$tabs.removeClass('hoot-tab-active');
			$target.addClass('hoot-tab-active');
			// Update the URL with the new tab parameter
			var newUrl = new URL(window.location.href);
			newUrl.searchParams.set('tab', targetid);
			history.replaceState(null, null, newUrl.toString());
		}
	});

});