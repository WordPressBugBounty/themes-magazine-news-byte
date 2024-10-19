<?php
/**
 * Blocks Setup
 * This file is loaded using 'after_setup_theme' hook at priority 10
 *
 * @package    Magazine News Byte
 * @subpackage Theme
 */

/* === WordPress Blocks === */


/** Add Gutenberg Wide Align support **/

add_theme_support( 'align-wide' );


/** Temporarily remove Gutenberg Widgets Screen **/

if ( apply_filters( 'magnb_disable_widgets_block_editor', true ) ) {
	remove_theme_support( 'widgets-block-editor' );
}


/** Add slightly more opinionated styles for the front end **/

add_theme_support( 'wp-block-styles' );


/** Custom spacing option for blocks like cover and group **/

add_theme_support( 'custom-spacing' );


/** Add accent colors to Block Pallete - hook to init to have default vals for accent via hoot_get_mod **/

if ( apply_filters( 'magnb_editor_color_palette', true ) )
	add_action( 'init', 'magnb_wpblock_color_palette' );
function magnb_wpblock_color_palette(){
	$defaults = array(
		'#000000' => array( 'black',                 __( 'Black', 'magazine-news-byte' ) ),
		'#abb8c3' => array( 'cyan-bluish-gray',      __( 'Cyan bluish gray', 'magazine-news-byte' ) ),
		'#ffffff' => array( 'white',                 __( 'White', 'magazine-news-byte' ) ),
		'#f78da7' => array( 'pale-pink',             __( 'Pale pink', 'magazine-news-byte' ) ),
		'#cf2e2e' => array( 'vivid-red',             __( 'Vivid red', 'magazine-news-byte' ) ),
		'#ff6900' => array( 'luminous-vivid-orange', __( 'Luminous vivid orange', 'magazine-news-byte' ) ),
		'#fcb900' => array( 'luminous-vivid-amber',  __( 'Luminous vivid amber', 'magazine-news-byte' ) ),
		'#7bdcb5' => array( 'light-green-cyan',      __( 'Light green cyan', 'magazine-news-byte' ) ),
		'#00d084' => array( 'vivid-green-cyan',      __( 'Vivid green cyan', 'magazine-news-byte' ) ),
		'#8ed1fc' => array( 'pale-cyan-blue',        __( 'Pale cyan blue', 'magazine-news-byte' ) ),
		'#0693e3' => array( 'vivid-cyan-blue',       __( 'Vivid cyan blue', 'magazine-news-byte' ) ),
		'#9b51e0' => array( 'vivid-purple',          __( 'Vivid purple', 'magazine-news-byte' ) ),
	);
	$load = false;
	$palette = array();
	$accent = hoot_get_mod( 'accent_color' );
		$load = true;
		$palette[] = array(
			'name' => __( 'Theme Accent Color', 'magazine-news-byte' ),
			'slug' => 'accent',
			'color' => $accent
		);
	$accentfont = hoot_get_mod( 'accent_font' );
		$load = true;
		$palette[] = array(
			'name' => __( 'Theme Accent Font Color', 'magazine-news-byte' ),
			'slug' => 'accent-font',
			'color' => $accentfont
		);
	if ( $load ) {
		foreach ( $defaults as $key => $value )
			if ( $key != $accent && $key != $accentfont )
				$palette[] = array(
					'name' => $value[1],
					'slug' => $value[0],
					'color' => $key
				);
		add_theme_support( 'editor-color-palette', $palette );
	}
}


/** Add Stylesheets **/

// This is loaded in both Frontend and Backend (HBS loads @10)
// add_action( 'enqueue_block_assets', 'magnb_wpblock_assets', 12 );

// Load after main stylesheet (and hootkit if available), but before child theme's stylesheet (and child hootkit)
add_action( 'wp_enqueue_scripts', 'magnb_wpblock_assets', 16 );
function magnb_wpblock_assets(){
	$style_uri = hoot_locate_style( 'include/blocks/wpblocks' );
	wp_enqueue_style( 'hoot-wpblocks', $style_uri, array(), hoot_data()->template_version );
}

// Set dynamic css handle to hoot-wpblocks
add_filter( 'hoot_style_builder_inline_style_handle', 'magnb_dynamic_css_wpblock_handle', 4 );
function magnb_dynamic_css_wpblock_handle(){ return 'hoot-wpblocks'; }

// Editor stylesheet (HBS loads @10)
add_action( 'enqueue_block_editor_assets', 'magnb_wpblock_editor_assets', 12 );
function magnb_wpblock_editor_assets(){
	// This is loaded in only Backend...
	$style_uri = hoot_locate_style( 'include/blocks/wpblocks-editor' );
	wp_enqueue_style( 'hoot-wpblocks-editor', $style_uri, array(), hoot_data()->template_version );

	$styles = magnb_user_style();
	extract( $styles );
	$dynamic_css = '';
	$dynamic_css .= ':root .has-accent-color' . ',' . '.is-style-outline>.wp-block-button__link:not(.has-text-color), .wp-block-button__link.is-style-outline:not(.has-text-color)'
					. '{ color: ' . $accent_color . '; } ';
	$dynamic_css .= ':root .has-accent-background-color' . ',' . '.wp-block-button__link' . ',' . '.wp-block-search__button, .wp-block-file__button'
					. '{ background: ' . $accent_color . '; } ';
	$dynamic_css .= ':root .has-accent-font-color' . ',' . '.wp-block-button__link' . ',' . '.wp-block-search__button, .wp-block-file__button'
					. '{ color: ' . $accent_font . '; } ';
	$dynamic_css .= ':root .has-accent-font-background-color'
					. '{ background: ' . $accent_font . '; } ';
	wp_add_inline_style( 'hoot-wpblocks-editor', $dynamic_css );
}


/** Add Dynamic CSS **/

add_action( 'hoot_dynamic_cssrules', 'magnb_dynamic_wpblockcss', 8 );
function magnb_dynamic_wpblockcss() {
	$styles = magnb_user_style();
	extract( $styles );

	hoot_add_css_rule( array(
						'selector'  => ':root .has-accent-color' . ',' . '.is-style-outline>.wp-block-button__link:not(.has-text-color), .wp-block-button__link.is-style-outline:not(.has-text-color)',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );
	hoot_add_css_rule( array(
						'selector'  => ':root .has-accent-background-color' . ',' . '.wp-block-button__link,.wp-block-button__link:hover' . ',' . '.wp-block-search__button,.wp-block-search__button:hover, .wp-block-file__button,.wp-block-file__button:hover',
						'property'  => 'background',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );
	hoot_add_css_rule( array(
						'selector'  => ':root .has-accent-font-color' . ',' . '.wp-block-button__link,.wp-block-button__link:hover' . ',' . '.wp-block-search__button,.wp-block-search__button:hover, .wp-block-file__button,.wp-block-file__button:hover',
						'property'  => 'color',
						'value'     => $accent_font,
						'idtag'     => 'accent_font',
					) );
	hoot_add_css_rule( array(
						'selector'  => ':root .has-accent-font-background-color',
						'property'  => 'background',
						'value'     => $accent_font,
						'idtag'     => 'accent_font',
					) );

}