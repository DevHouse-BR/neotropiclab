<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Counter
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_counter extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'value' => '999',
			'value_speed' => '2000',
			'value_interval' => '1',
			'checkicon' => '',
			'icon' => '',
			'title_tag' => 'h2',
			'title_size' => '2rem',
			'title_line_height' => '1em',
			'title_color' => '',
			'counter_size' => '6rem',
			'counter_line_height' => '1em',
			'counter_color' => '#818b92',
			'icon_size' => '4rem',
			'icon_line_height' => '2em',
			'icon_color' => '',
        	//Static
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
			), $atts ) );
		$output = '';
      	$ve_global_color = 've-global-color'; //General Color
	  	$ve_global_border_color = 've-global-border-color'; //Border Color
	  	$ve_global_background_color = 've-global-background-color'; //Background Color


	  // Start Default Extra Class, CSS and CSS animation

	  	$css = isset( $atts['css'] ) ? $atts['css'] : '';
	  	$el_class = isset( $atts['el_class'] ) ? $atts['el_class'] : '';

	  	if ( '' !== $css_animation ) {
	  		wp_enqueue_script( 'waypoints' );
	  		$css_animation_style = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
	  	}

	  	$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
	  	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

	  // End Default Extra Class, CSS and CSS animation



	  	$title_color_default = '';
	  	if($title_color == '') {
	  		$title_color_default = $ve_global_color;
	  	} 

	  	$icon_color_default = '';
	  	if($icon_color == '') {
	  		$icon_color_default = $ve_global_color;
	  	} 		  


	  	$output .= '<div class="counter text-center '.$css_class.'">';

	  	$output .= '<div class="counter-data" value="'.$value.'" value-speed="'.$value_speed.'" value-interval="'.$value_interval.'">';

	  	if($checkicon == 'icon') {
	  		$output .= '<div class="counter-icon"><i style="font-size:'.$icon_size.'; line-height:'.$icon_line_height.'; color:'.$icon_color.';" class="'.$icon.' '.$icon_color_default.'"></i></div>';
	  	} 

	  	$output .= '<div style="font-size:'.$counter_size.'; line-height:'.$counter_line_height.'; color:'.$counter_color.';" class="counter-value"></div>';

	  	if($title != ''){ 
	  		$output .= '<'.$title_tag.' style="font-size:'.$title_size.'; line-height:'.$title_line_height.'; color:'.$title_color.';" class="counter-title '.$title_color_default.'">'.$title.'</'.$title_tag.'>'; 
	  	}
	  	$output .= '</div>';
	  	$output .= '</div>';

	  	return $output;
	  }
	}

	return array(
		'name' => __( 'Counter', 'vslmd' ),
		'base' => 've_counter',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		'show_settings_on_create' => true,
		'category' => __( 'Visual Elements', 'vslmd' ),
		'description' => __( 'Your milestones and achievements', 'vslmd' ),
		'params' => array(

			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'vslmd' ),
				'param_name' => 'title',
				'description' => __( 'Enter the title here.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Counter Value', 'vslmd' ),
				'param_name' => 'value',
				'description' => __( 'Enter number for counter without any special character.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Counter Value Speed', 'vslmd' ),
				'param_name' => 'value_speed',
				'description' => __( 'Enter number for counter without any special character.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Counter Value Interval', 'vslmd' ),
				'param_name' => 'value_interval',
				'description' => __( 'Enter number for counter without any special character.', 'vslmd' ),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'vslmd' ),
				'param_name' => 'checkicon',
				'value' => array(
					__( 'No', 'vslmd' ) => '',
					__( 'Yes', 'vslmd' ) => 'icon',
					),
				'description' => __( 'Enable Icon Library.', 'vslmd' ),
				),

			array(
				'type' => 'iconmanager',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon',
				'description' => __( 'Select icon from library.', 'js_composer' ),
				'dependency' => array(
					'element' => 'checkicon',
					'value' => array( 'icon' ),
					),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Title Tag', 'vslmd' ),
				'param_name' => 'title_tag',
				'group' => 'Typography',
				'value' => array(
					__( 'H1', 'vslmd' ) => 'h1',
					__( 'H2', 'vslmd' ) => 'h2',
					__( 'H3', 'vslmd' ) => 'h3',
					__( 'H4', 'vslmd' ) => 'h4',
					__( 'H5', 'vslmd' ) => 'h5',
					__( 'H6', 'vslmd' ) => 'h6',
					__( 'p', 'vslmd' ) => 'p',
					__( 'div', 'vslmd' ) => 'div',
					),
				'description' => __( 'Select title tag.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Title Font Size', 'vslmd' ),
				'param_name' => 'title_size',
				'description' => __( 'Enter font size.', 'vslmd' ),
				'group' => 'Typography',
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Title Line Height', 'vslmd' ),
				'param_name' => 'title_line_height',
				'description' => __( 'Enter line height.', 'vslmd' ),
				'group' => 'Typography',
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Title Color', 'vslmd' ),
				'param_name' => 'title_color',
				'description' => __( 'Select custom color for the title.', 'vslmd' ),
				'group' => 'Typography',
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Counter Size', 'vslmd' ),
				'param_name' => 'counter_size',
				'description' => __( 'Enter font size.', 'vslmd' ),
				'group' => 'Typography',
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Counter Line Height', 'vslmd' ),
				'param_name' => 'counter_line_height',
				'description' => __( 'Enter line height.', 'vslmd' ),
				'group' => 'Typography',
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Counter Color', 'vslmd' ),
				'param_name' => 'counter_color',
				'description' => __( 'Select custom color for the number.', 'vslmd' ),
				'group' => 'Typography',
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Icon Size', 'vslmd' ),
				'param_name' => 'icon_size',
				'description' => __( 'Enter font size.', 'vslmd' ),
				'group' => 'Typography',
				'dependency' => array(
					'element' => 'checkicon',
					'value' => array( 'icon' ),
					),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Icon Line Height', 'vslmd' ),
				'param_name' => 'icon_line_height',
				'description' => __( 'Enter line height.', 'vslmd' ),
				'group' => 'Typography',
				'dependency' => array(
					'element' => 'checkicon',
					'value' => array( 'icon' ),
					),
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Icon Color', 'vslmd' ),
				'param_name' => 'icon_color',
				'description' => __( 'Select custom color for the icon.', 'vslmd' ),
				'group' => 'Typography',
				'dependency' => array(
					'element' => 'checkicon',
					'value' => array( 'icon' ),
					),
				),

		// Animation
			vc_map_add_css_animation(),

			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'vslmd' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'vslmd' ),
				),

			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'js_composer' ),
				'param_name' => 'css',
				'group' => __( 'Design Options', 'js_composer' ),
				),
			),
);
