<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

add_filter( 'tiny_mce_before_init', function( $settings ) {
	global $luxe;
	//$settings['theme']	= 'modern';
	//$settings['skin']	= 'lightgray';
	//$settings['indent']	= false;
	//$settings['keep_styles']	= false;
	//$settings['wpautop']	= true;
	//$settings['branding']	= false;
	//$settings['wp_autoresize_on'] = true;
	//$settings['wp_keep_scroll_position'] = false;
	//$settings['resize']	= false;
	if( isset( $luxe['mce_menubar'] ) ) {
		$settings['menubar'] = true;
	}
	if( isset( $luxe['mce_enter_key'] ) && $luxe['mce_enter_key'] === 'linefeed' ) {
		$settings['forced_root_block'] = false;
	}
	$settings['body_class']	= 'post';
	$settings['cache_suffix'] = 'v=' . $_SERVER['REQUEST_TIME'];
	$maxwidth = isset( $luxe['mce_max_width'] ) && ctype_digit( (string)$luxe['mce_max_width'] ) && $luxe['mce_max_width'] !== 0 ? $luxe['mce_max_width'] . 'px' : '100%';
	$bg_color = isset( $luxe['mce_bg_color'] ) ? $luxe['mce_bg_color'] : '#fff';
	$color    = isset( $luxe['mce_color'] ) ? $luxe['mce_color'] : '#000';
	$settings['content_style'] = 'body.mceContentBody{max-width:' . $maxwidth . ';background:' . $bg_color . ';color:' . $color . '}';
	return $settings;
});
$turi = get_template_directory_uri() . '/';
$suri = get_stylesheet_directory_uri() . '/';
$editor_css_files = array();

if( file_exists( TPATH . DSEP . 'style.min.css' ) === true ) {
	$editor_css_files[] = $turi . 'style.min.css';
}
else {
	$editor_css_files[] = $turi . 'css/luxe-mode.css';
	$editor_css_files[] = $turi . 'style.css';
}
$editor_css_files[] = $turi . 'editor-style.css';
if( TPATH !== SPATH ) {
	if( isset( $luxe['design_file'] ) ) {
		$design_editor_css = 'design/' . $luxe['design_file'] . '/style.css';
		$design_editor_css = 'design/' . $luxe['design_file'] . '/editor-style.css';
		if( file_exists( SPATH . DSEP . $design_editor_css ) === true ) {
			$editor_css_files[] = $suri . $design_editor_css;
		}
	}
	if( file_exists( SPATH . DSEP . 'style.min.css' ) === true ) {
		$editor_css_files[] = $suri . 'style.min.css';
	}
	else {
		$editor_css_files[] = $suri . 'style.css';
	}
	$editor_css_files[] = $suri . 'editor-style.css';
}
add_editor_style( $editor_css_files );
