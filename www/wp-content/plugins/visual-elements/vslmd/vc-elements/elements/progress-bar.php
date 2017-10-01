<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_progress_bar extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'field' => '',
			'percentage' => '',
			'height' => '22px',
			'style' => 'progress-rounded',
			'bgcolor' => '',
			'checkicon' => '',
			'icon' => '',
			'custombarcolor' => '',
        //Static
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
			), $atts ) );
		$output = '';
      	$ve_global_color = 've-global-color'; //General Color
	  	$ve_global_border_color = 've-global-border-color'; //Border Color
	  	$ve_global_background_color = 've-global-background-color'; //Background Color

	  if ($bgcolor=="custom") { 
	  	$bgcolor = ' background-color: '.$custombarcolor.';'; 
	  	$default_bgcolor = '';
	  } else {
	  	$bgcolor = ''; 
	  	$default_bgcolor = $ve_global_background_color; 
	  }

	  if ($checkicon=="custom_icon") { $icon = '<i class="'.$icon.'"></i>'; } else { $icon = ""; }

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

	  	$output .= '<div class="'.$css_class.'">';
	  	$output .= '<span class="progress-bar-title">'.$field.'</span>';
	  	$output .= '<div class="ve-progress-bar '.$style.'">';
	  	$output .= '<div class="progress-stripe" style="height:'.$height.';">';
	  	$output .= '<span class="bar '.$default_bgcolor.'" data-width="'.$percentage.'" style="width: '.$percentage.'; line-height:'.$height.'; '.$bgcolor.'"> <p class="field">'.$icon.'</p> <strong><i>' . $percentage . '</i>%</strong> </span>';
	  	$output .= '</div></div></div>';

	  	return $output;
	  }
	}

	return array(
		'name' => __( 'Progress Bar', 'vslmd' ),
		'base' => 've_progress_bar',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		'show_settings_on_create' => true,
		'category' => __( 'Visual Elements', 'vslmd' ),
		'description' => __( 'Animated progress bar', 'vslmd' ),
		'params' => array(

			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'vslmd' ),
				'param_name' => 'field',
				'description' => __( 'Enter the Progress Bar Field title here.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Progress in %', 'vslmd' ),
				'param_name' => 'percentage',
				'description' => __( 'Enter a number between 0 and 100', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'vslmd' ),
				'param_name' => 'height',
				'description' => __( 'Enter a value for height.', 'vslmd' ),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'js_composer' ),
				'description' => __( 'Select style.', 'js_composer' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Rounded', 'js_composer' ) => 'progress-rounded',
					__( 'Square', 'js_composer' ) => 'progress-square',
					__( 'Round', 'js_composer' ) => 'progress-round',
					),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Bar color', 'vslmd' ),
				'param_name' => 'bgcolor',
				'value' => array(
					__( 'Preset Color', 'vslmd' ) => '',
					__( 'Custom Color', 'vslmd' ) => 'custom',
					),
				'description' => __( 'Choose a color for your progress bar here.', 'vslmd' ),
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Bar Custom Color', 'vslmd' ),
				'param_name' => 'custombarcolor',
				'description' => __( 'Select custom background color for bar.', 'vslmd' ),
				'dependency' => array(
					'element' => 'bgcolor',
					'value' => array( 'custom' ),
					),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'vslmd' ),
				'param_name' => 'checkicon',
				'value' => array(
					__( 'No', 'vslmd' ) => 'no_icon',
					__( 'Yes', 'vslmd' ) => 'custom_icon',
					),
				'description' => __( 'Should an icon be displayed at the left side of the progress bar.', 'vslmd' ),
				),

			array(
				'type' => 'iconmanager',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon',
				'description' => __( 'Select icon from library.', 'js_composer' ),
				'dependency' => array(
					'element' => 'checkicon',
					'value' => 'custom_icon'
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
