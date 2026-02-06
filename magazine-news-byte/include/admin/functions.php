<?php
/**
 * Helper Functions
 */

/**
 * Set Theme About Page Tags
 * @access public
 * @return mixed
 */
function magnb_abouttag( $index = 'slug' ) {
	static $tags;
	if ( empty( $tags ) ) {
		$child = hoot_data( 'childtheme_name' );
		$is_official_child = false;
		if ( $child ) {
			$checks = apply_filters( 'magnb_theme_config_childtheme_array', array() );
			foreach ( $checks as $check ) {
				if ( stripos( $child, $check ) !== false ) {
					$is_official_child = true;
					break;
				}
			}
		}
		$tags = $is_official_child ? array() : array(
			'slug' => 'magazine-news-byte',
			'name' => __( 'Magazine NewsByte', 'magazine-news-byte' ),
			'label' => __( 'Magazine NewsByte Dashboard', 'magazine-news-byte' ),
			'vers' => hoot_data( 'template_version' ),
			'shot' => ( file_exists( hoot_data()->template_dir . 'screenshot.jpg' ) ) ? hoot_data()->template_uri . 'screenshot.jpg' : (
						( file_exists( hoot_data()->template_dir . 'screenshot.png' ) ) ? hoot_data()->template_uri . 'screenshot.png' : ''
						),
			'fullshot' => ( file_exists( hoot_data()->incdir . 'admin/images/screenshot.jpg' ) ) ? hoot_data()->incuri . 'admin/images/screenshot.jpg' : (
				( file_exists( hoot_data()->incdir . 'admin/images/screenshot.png' ) ) ? hoot_data()->incuri . 'admin/images/screenshot.png' : ''
				)
		);
		$tags = apply_filters( 'magnb_abouttags', $tags );
		if ( ! is_array( $tags ) ) $tags = array();
		if ( !empty( $tags['name'] ) ) $tags['name'] = esc_html( $tags['name'] );
		if ( !empty( $tags['slug'] ) ) $tags['slug'] = sanitize_html_class( $tags['slug'] );
		if ( !empty( $tags['vers'] ) ) $tags['vers'] = sanitize_text_field( $tags['vers'] );
		if ( !empty( $tags['shot'] ) ) $tags['shot'] = esc_url( $tags['shot'] );
		if ( !empty( $tags['fullshot'] ) ) $tags['fullshot'] = esc_url( $tags['fullshot'] );
	}
	return ( $index === true ? $tags : ( ( isset( $tags[ $index ] ) ) ? $tags[ $index ] : '' ) );
}