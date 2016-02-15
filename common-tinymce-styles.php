<?php
/*
Plugin Name: Common TinyMCE Styles
Plugin URI: http://www.github.com/helgatheviking/common-tinymce-styles
Description: Add custom styles in your posts and pages content using TinyMCE WYSIWYG editor. The plugin adds a handful of standardized elements that can be styled by all themes.
Author: Kathy Darling
Version: 1.0.0
Requires at least: 4.2
Author URI: http://www.kathyisawesome.com/
*/
/*  

Copyright 2015 Kathy Darling

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

// move functions to separate functions
require_once( 'includes/customizer.php' );
require_once( 'includes/tinymce.php' );

define( 'COMMON_TINYMCE_STYLES_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'COMMON_TINYMCE_STYLES_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Create CSS on activation
 */
function common_tinymce_activate(){
	if( ! file_exists( COMMON_TINYMCE_STYLES_PATH . '/css/editor-styles.css' ) ){
		_common_tinymce_compile_css();
	}
}
register_activation_hook( __FILE__, 'common_tinymce_activate' );
 