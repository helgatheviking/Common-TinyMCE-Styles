<?php
/*
Plugin Name: Common TinyMCE Styles
Plugin URI: http://www.github.com/helgatheviking/common-tinymce-styles
Description: Add custom styles in your posts and pages content using TinyMCE WYSIWYG editor. The plugin adds a handful of standardized elements that can be styled by all themes.
Author: Kathy Darling
Version: 0.0.1
Requires at least: 4.2
Author URI: http://www.kathyisawesome.com/
*/
/*  Copyright 2015 Kathy Darling

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License (GPL v2) only.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Apply styles to the visual editor
 */ 
add_filter('mce_css', 'kia_common_tinymce_editor_style');
function kia_common_tinymce_editor_style($url) {
 
 	if( ! current_theme_supports( 'common-tinymce-styles' ) ){

		if ( !empty($url) ){
			$url .= ',';
		}
	 
		// Retrieves the plugin directory URL
		// Change the path here if using different directories
		$url .= trailingslashit( plugin_dir_url(__FILE__) ) . '/editor-styles.css';

	}
 
	return $url;
}
 
/**
 * Add "Styles" drop-down
 */
add_filter( 'mce_buttons_2', 'kia_common_tinymce_editor_buttons' );
 
function kia_common_tinymce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
 
/**
 * Add styles/classes to the "Styles" drop-down
 */
add_filter( 'tiny_mce_before_init', 'kia_common_tinymce_before_init' );
 
function kia_common_tinymce_before_init( $settings ) {
 
	$style_formats = array(
		array(
			'title' => __( 'Big Accent Headline' , 'common-tinymce-styles'),
			'block' => 'h2',
			'classes' => 'bigger accent-color'
			),
		array(
			'title' => __( 'Accent Headline' , 'common-tinymce-styles'),
			'selector' => 'h3',
			'classes' => 'big accent-color',
		),
		array(
			'title' => __( 'Big Alt Headline' , 'common-tinymce-styles'),
			'block' => 'h2',
			'classes' => 'bigger alt-color'
			),
		array(
			'title' => __( 'Alt Headline' , 'common-tinymce-styles'),
			'selector' => 'h3',
			'classes' => 'big alt-color',
		),
		array(
			'title' => __( 'Message Box' , 'common-tinymce-styles'),
			'block' => 'div',
			'classes' => 'message-box',
			'wrapper' => true
		),
		array(
			'title' => __( 'Warning Box' , 'common-tinymce-styles'),
			'block' => 'div',
			'classes' => 'message-box warning-box',
			'wrapper' => true
		),
		array(
			'title' => __( 'Inverted text' , 'common-tinymce-styles'),
			'inline' => 'span',
			'classes' => 'inverted'
		),
		array(
			'title' => __( 'Button Link' , 'common-tinymce-styles'),
			'selector' => 'a',
			'classes' => 'button accent-color'
		),
		array(
			'title' => __( 'Alt Button Link' , 'common-tinymce-styles'),
			'selector' => 'a',
			'classes' => 'button alt-color'
		)
	);
 
	$settings['style_formats'] = json_encode( $style_formats );
 
	return $settings;
 
}
 
/* Learn TinyMCE style format options at http://www.tinymce.com/wiki.php/Configuration:formats */
 
/*
 * Add custom stylesheet to the website front-end with hook 'wp_enqueue_scripts'
 */
add_action('wp_enqueue_scripts', 'kia_common_tinymce_editor_enqueue');
 
/*
 * Enqueue stylesheet, if it exists.
 */
function kia_common_tinymce_editor_enqueue() {
	if( ! current_theme_supports( 'common-tinymce-styles' ) ){
		wp_enqueue_style( 'common_tinymce_editor_styles', plugin_dir_url(__FILE__) . 'editor-styles.css' );
	}
}
?>