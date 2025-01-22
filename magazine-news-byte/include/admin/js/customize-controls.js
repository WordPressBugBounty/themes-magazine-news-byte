/**
 * Theme Customizer
 */


( function( api ) {

	// Extends our custom "hoot-theme" section.
	api.sectionConstructor['hoot-theme'] = api.Section.extend( {
		// No events for this type of section.
		attachEvents: function () {},
		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

	/*** JS equivalent for active_callback ***/

	api.bind('ready', function () {
		api.control('logo', function (control) {
			control.setting.bind(function (value) {
				switch (value) {
					case 'text':
						api.control( 'logo_size', function( control ) {            control.activate(); } );
						api.control( 'site_title_icon', function( control ) {      control.activate(); } );
						api.control( 'site_title_icon_size', function( control ) { control.activate(); } );
						api.control( 'custom_logo', function( control ) {          control.deactivate(); } );
						api.control( 'logo_image_width', function( control ) {     control.deactivate(); } );
						api.control( 'logo_custom', function( control ) {          control.deactivate(); } );
						break;
					case 'custom':
						api.control( 'logo_size', function( control ) {            control.deactivate(); } );
						api.control( 'site_title_icon', function( control ) {      control.activate(); } );
						api.control( 'site_title_icon_size', function( control ) { control.activate(); } );
						api.control( 'custom_logo', function( control ) {          control.deactivate(); } );
						api.control( 'logo_image_width', function( control ) {     control.deactivate(); } );
						api.control( 'logo_custom', function( control ) {          control.activate(); } );
						break;
					case 'image':
						api.control( 'logo_size', function( control ) {            control.deactivate(); } );
						api.control( 'site_title_icon', function( control ) {      control.deactivate(); } );
						api.control( 'site_title_icon_size', function( control ) { control.deactivate(); } );
						api.control( 'custom_logo', function( control ) {          control.activate(); } );
						api.control( 'logo_image_width', function( control ) {     control.deactivate(); } );
						api.control( 'logo_custom', function( control ) {          control.deactivate(); } );
						break;
					case 'mixed':
						api.control( 'logo_size', function( control ) {            control.activate(); } );
						api.control( 'site_title_icon', function( control ) {      control.deactivate(); } );
						api.control( 'site_title_icon_size', function( control ) { control.deactivate(); } );
						api.control( 'custom_logo', function( control ) {          control.activate(); } );
						api.control( 'logo_image_width', function( control ) {     control.activate(); } );
						api.control( 'logo_custom', function( control ) {          control.deactivate(); } );
						break;
					case 'mixedcustom':
						api.control( 'logo_size', function( control ) {            control.deactivate(); } );
						api.control( 'site_title_icon', function( control ) {      control.deactivate(); } );
						api.control( 'site_title_icon_size', function( control ) { control.deactivate(); } );
						api.control( 'custom_logo', function( control ) {          control.activate(); } );
						api.control( 'logo_image_width', function( control ) {     control.activate(); } );
						api.control( 'logo_custom', function( control ) {          control.activate(); } );
						break;
				}
			});
		});
		api.control('menu_location', function (control) {
			control.setting.bind(function (value) {
				switch (value) {
					case 'top': case 'bottom':
						api.control( 'logo_side', function( control ) {            control.activate(); } );
						api.control( 'fullwidth_menu_align', function( control ) { control.activate(); } );
						break;
					case 'none':
						api.control( 'logo_side', function( control ) {            control.activate(); } );
						api.control( 'fullwidth_menu_align', function( control ) { control.deactivate(); } );
						break;
					case 'side':
						api.control( 'logo_side', function( control ) {            control.deactivate(); } );
						api.control( 'fullwidth_menu_align', function( control ) { control.deactivate(); } );
						break;
				}
			});
		});

		jQuery(document).ready(function($) {
			$('a[rel="focuslink"]').click(function(e) {
				e.preventDefault();
				var id = $(this).data('href'),
					type = $(this).data('focustype');
				if(api[type].has(id)) {
					api[type].instance(id).focus();
				}
			});

			var areaIds = ['area_a', 'area_b', 'area_c', 'area_d', 'area_e', 'area_f', 'area_g', 'area_h', 'area_i', 'area_j', 'area_k', 'area_l', 'content'];
			function updateBgVisibility($input,areaId,initial=false) {
				var selectedValue = $input.val();
				var $parentli = $input.closest('li');
				var $colorli = $parentli.siblings("#customize-control-frontpage_sectionbg_" + areaId + "-color");
				var $imageli = $parentli.siblings("#customize-control-frontpage_sectionbg_" + areaId + "-image");
				var $parallaxli = $parentli.siblings("#customize-control-frontpage_sectionbg_" + areaId + "-parallax");
				if (selectedValue === "none") {
					if ( initial ) {
						$colorli.hide(); $imageli.hide(); $parallaxli.hide();
					} else {
						$colorli.slideUp('fast'); $imageli.slideUp('fast'); $parallaxli.slideUp('fast');
					}
				} else if (selectedValue === "color" || selectedValue === "highlight") {
					if ( initial ) {
						$colorli.show(); $imageli.hide(); $parallaxli.hide();
					} else {
						$colorli.slideDown('fast'); $imageli.slideUp('fast'); $parallaxli.slideUp('fast');
					}
				} else if (selectedValue === "image") {
					if ( initial ) {
						$colorli.hide(); $imageli.show(); $parallaxli.show();
					} else {
						$colorli.slideUp('fast'); $imageli.slideDown('fast'); $parallaxli.slideDown('fast');
					}
				}
			}
			function updateFontVisibility($input,areaId,initial=false) {
				var selectedValue = $input.val();
				var $parentli = $input.closest('li');
				var $colorli = $parentli.siblings("#customize-control-frontpage_sectionbg_" + areaId + "-fontcolor");
				if (selectedValue === "theme") {
					if ( initial ) {
						$colorli.hide();
					} else {
						$colorli.slideUp('fast');
					}
				} else {
					if ( initial ) {
						$colorli.show();
					} else {
						$colorli.slideDown('fast');
					}
				}
			}
			areaIds.forEach(function(areaId) {
				var $typeinput = $("#customize-control-frontpage_sectionbg_"+areaId+"-type input[type='radio']");
				if( $typeinput.length ) {
					$typeinput.filter(':checked').each(function() {
						updateBgVisibility($(this), areaId, true);
					});
					$typeinput.on('change', function() {
						updateBgVisibility($(this), areaId);
					});
				}
				var $typeinput = $("#customize-control-frontpage_sectionbg_"+areaId+"-font input[type='radio']");
				if( $typeinput.length ) {
					$typeinput.filter(':checked').each(function() {
						updateFontVisibility($(this), areaId, true);
					});
					$typeinput.on('change', function() {
						updateFontVisibility($(this), areaId);
					});
				}
			});

		});

	});

	// Color Schemes @credit TwentySixteen theme
	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {
					var accent = '', font = '';
					switch (value) {
						case 'maroon': accent = '#bd2e2e'; font = '#ffffff'; break;
						case 'blue':   accent = '#107cdb'; font = '#ffffff'; break;
						case 'green':  accent = '#38b295'; font = '#ffffff'; break;
						case 'orange': accent = '#db7910'; font = '#ffffff'; break;
						case 'red':    accent = '#db1010'; font = '#ffffff'; break;
						case 'gold':   accent = '#db9010'; font = '#ffffff'; break;
					}
					// Accent Color
					api( 'accent_color' ).set( accent );
					api.control( 'accent_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', accent )
						.wpColorPicker( 'defaultColor', accent );
					// Accent Font
					api( 'accent_font' ).set( font );
					api.control( 'accent_font' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', font )
						.wpColorPicker( 'defaultColor', font );
				} );
			}
		}
	} );

} )( wp.customize );


jQuery(document).ready(function($) {
	"use strict";

	/*** Hide and link module BG buttons ***/

	$('.frontpage_sections_modulebg .button').on('click',function(event){
		event.stopPropagation();
		var choice = $(this).closest('li.hoot-control-sortlistitem').data('choiceid');
		$('.hoot-control-id-frontpage_sectionbg_' + choice + ' .hoot-flypanel-button').trigger('click');
	});

});