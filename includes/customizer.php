<?php

use Leafo\ScssPhp\Compiler;

/**
 * Register the customizer section/setttings
 * 
 * @param obj $wp_customize
 */
function common_tinymce_customize_register( $wp_customize ) {

	// create the customizer section
	$wp_customize->add_section( 'common_tinymce_styles', array(
	    'priority'       => 50,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __( 'Common TinyMCE Styles', 'common-tinymce-styles' ),
	    'description'    => __( 'Some custom colors for buttons and message boxes added by the TinyMCE editor', 'common-tinymce-styles' ),
	) );

	// message color
	$wp_customize->add_setting( 'common_tinymce_message_color',
		array(
			'default'	=> '#428bca',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'common_tinymce_message_color', array(
		'label'		=> __( 'Message Color', 'common-tinymce-styles' ),
		'section'	=> 'common_tinymce_styles',
		'settings'	=> 'common_tinymce_message_color',
	) ) );

	// warning color
	$wp_customize->add_setting( 'common_tinymce_warning_color',
		array(
			'default'	=> '#CC0000',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'common_tinymce_warning_color', array(
		'label'		=> __( 'Warning Color', 'common-tinymce-styles' ),
		'section'	=> 'common_tinymce_styles',
		'settings'	=> 'common_tinymce_warning_color',
	) ) );

	// button color
	$wp_customize->add_setting( 'common_tinymce_button_color',
		array(
			'default'	=> '#999999',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'common_tinymce_button_color', array(
		'label'		=> __( 'Button Color', 'common-tinymce-styles' ),
		'section'	=> 'common_tinymce_styles',
		'settings'	=> 'common_tinymce_button_color',
	) ) );

	// alt button
	$wp_customize->add_setting( 'common_tinymce_alt_button_color',
		array(
			'default'	=> '#CCCCCC',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'common_tinymce_alt_button_color', array(
		'label'		=> __( 'Alt Button Color', 'common-tinymce-styles' ),
		'section'	=> 'common_tinymce_styles',
		'settings'	=> 'common_tinymce_alt_button_color',
	) ) );

 	// Add checkbox for fancy, animated buttons
    $wp_customize->add_setting( 'common_tinymce_fancy_buttons', array(
			'transport' => 'postMessage',
			'sanitize_callback' => 'common_tinymce_sanitize_checkbox',
		)
	);

    // Add control and output for checkbox field
	$wp_customize->add_control(
	    'common_tinymce_fancy_buttons',
	    array(
	        'type' => 'checkbox',
	        'label' => __( 'Fancy Buttons', 'common-tinymce-styles' ),
	        'section' => 'common_tinymce_styles',
	    )
	);

}
add_action( 'customize_register', 'common_tinymce_customize_register', 20 );

/**
 * Load the preview script
 */
function common_tinymce_customizer_live_preview(){
	wp_enqueue_script( 
		  'common-tinymce-preview',			//Give the script an ID
		  COMMON_TINYMCE_STYLES_URL . '/assets/js/customizer.js',//Point to file
		  array( 'jquery','customize-preview' ),	//Define dependencies
		  '',						//Define a version (optional) 
		  true						//Put script in footer?
	);
}
add_action( 'customize_preview_init', 'common_tinymce_customizer_live_preview' );


/**
 * Sanitize the checkbox
 * 
 * @param int $input
 * @return int|null
 */
function common_tinymce_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}


/**
 * Add a body class if checkbox setting is set
 * 
 * @param array $class
 * @return array
 */
function common_tinymce_body_class( $class ){
	if( get_theme_mod( 'common_tinymce_fancy_buttons', 0 ) == 1 ){
		$class[] = 'cts-use-fancy-buttons';
	}
	return $class;
}
add_filter( 'body_class', 'common_tinymce_body_class' );


/**
 * Compile the SCSS into CSS
 */
function _common_tinymce_compile_css(){

	require( COMMON_TINYMCE_STYLES_PATH . '/vendor/autoload.php');
	$scss = new Compiler();

	$scss->setVariables(array(
	    'accent-color' => get_theme_mod( 'common_tinymce_button_color', '#999999' ),
		'alt-color' => get_theme_mod( 'common_tinymce_alt_button_color', '#CCCCCC' ),
		'message-color' => get_theme_mod( 'common_tinymce_message_color', '#BB0000' ),
		'warning-color' => get_theme_mod( 'common_tinymce_warning_color', '#CC0000' )
	));

	$css = file_get_contents( COMMON_TINYMCE_STYLES_PATH . '/assets/css/editor-styles.scss' );

	$css = $scss->compile($css);

	file_put_contents( COMMON_TINYMCE_STYLES_PATH . '/assets/css/editor-styles.css', $css );

	do_action( 'common_tinymce_compile_css', $scss );
	
	update_option( 'common_tinymce_styles_stylesheet', time() );

}
add_action( 'customize_save_after', '_common_tinymce_compile_css' );

//temp for testing
add_action( 'init', '_common_tinymce_compile_css' );