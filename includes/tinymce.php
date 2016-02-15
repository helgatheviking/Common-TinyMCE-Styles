<?php

/**
 * Add "Styles" drop-down
 * @param array $buttons
 * @return array
 */
function common_tinymce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'common_tinymce_editor_buttons' );
 
/**
 * Add styles/classes to the "Styles" drop-down
 * @param array $settings
 * @return array
 */
function common_tinymce_before_init( $settings ) {
 
	$style_formats = array(
		array(
			'title' => __( 'Big Accent Headline' , 'common-tinymce-styles' ),
			'block' => 'h2',
			'classes' => 'bigger accent-color'
			),
		array(
			'title' => __( 'Accent Headline' , 'common-tinymce-styles' ),
			'selector' => 'h3',
			'classes' => 'big accent-color',
		),
		array(
			'title' => __( 'Big Alt Headline' , 'common-tinymce-styles' ),
			'block' => 'h2',
			'classes' => 'bigger alt-color'
			),
		array(
			'title' => __( 'Alt Headline' , 'common-tinymce-styles' ),
			'selector' => 'h3',
			'classes' => 'big alt-color',
		),
		array(
			'title' => __( 'Message Box' , 'common-tinymce-styles' ),
			'block' => 'div',
			'classes' => 'cts-message-box',
			'wrapper' => true
		),
		array(
			'title' => __( 'Warning Box' , 'common-tinymce-styles' ),
			'block' => 'div',
			'classes' => 'cts-message-box cts-warning-box',
			'wrapper' => true
		),
		array(
			'title' => __( 'Inverted text' , 'common-tinymce-styles' ),
			'inline' => 'span',
			'classes' => 'cts-inverted'
		),
		array(
			'title' => __( 'Button Link' , 'common-tinymce-styles' ),
			'selector' => 'a',
			'classes' => 'cts-button accent-color'
		),
		array(
			'title' => __( 'Button Alt Link' , 'common-tinymce-styles' ),
			'selector' => 'a',
			'classes' => 'cts-button alt-color'
		),
		array(
			'title' => __( 'Ghost Button Link' , 'common-tinymce-styles' ),
			'selector' => 'a',
			'classes' => 'cts-ghost-button accent-color'
		),
		array(
			'title' => __( 'Ghost Button Alt Link' , 'common-tinymce-styles' ),
			'selector' => 'a',
			'classes' => 'cts-ghost-button alt-color'
		),
		array(
			'title' => __( 'Smaller Text' , 'common-tinymce-styles' ),
			'selector' => 'p',
			'classes' => 'smaller'
		)
	);
 
	$settings['style_formats'] = json_encode( $style_formats );
 
 	unset( $settings['preview_styles'] );

	return $settings;

}
add_filter( 'tiny_mce_before_init', 'common_tinymce_before_init' );

/**
 * Apply styles to the visual editor
 * @param str $url
 * @return str
 */ 
function common_tinymce_editor_style($url) {
 
 	if( ! current_theme_supports( 'common-tinymce-styles' ) ){

		if ( !empty($url) ){
			$url .= ',';
		}
	 
		// Retrieves the plugin directory URL
		// Change the path here if using different directories
		$url .= COMMON_TINYMCE_STYLES_URL . '/assets/css/editor-styles.css';

	}
 
	return $url;
}
add_filter( 'mce_css', 'common_tinymce_editor_style' );


/*
 * Add custom stylesheet to the website front-end with hook 'wp_enqueue_scripts'
 */
function common_tinymce_editor_enqueue() {
	if( ! current_theme_supports( 'common-tinymce-styles' ) && file_exists( COMMON_TINYMCE_STYLES_PATH . '/assets/css/editor-styles.css' ) ){
		wp_enqueue_style( 'common_tinymce_editor_styles', COMMON_TINYMCE_STYLES_URL . '/assets/css/editor-styles.css', array(), get_option( 'common_tinymce_styles_stylesheet', array() ) );
	}
}
add_action( 'wp_enqueue_scripts', 'common_tinymce_editor_enqueue', 20 );