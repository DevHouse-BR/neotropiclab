<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Circular Progress Bar
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_circular_progress_bar extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'style' => '',
			'title' => '',
			'number' => '',
			'icon' => '',
			'size' => '',
			'thickness' => '',
			'color' => '',
			'title_color' => '',
			'bar_color' => '',
			'track_color' => '',
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


	  	if($thickness != ''){
	  		$thickness = 'thickness="'.$thickness.'"';
	  	} else {
	  		$thickness = 'thickness="5"'; 
	  	}

	  	if($color != '') {
	  		$color = 'color:'.$color.';';
	  		$color_default = '';
	  	} else {
	  		$color_default = 've-global-color';
	  	}

	  	if($title_color != '') {
	  		$title_color = 'style="color:'.$title_color.';"';
	  		$title_color_default = '';
	  	} else {
	  		$title_color_default = 've-global-color';
	  	}

	  	if($bar_color != '') {
	  		$data_bar_color = 'data-bar-color="'.$bar_color.'"';
	  	} else {
	  		$data_bar_color = 'data-bar-color="#3379fc"';
	  	}

	  	if($track_color != '') {
	  		$data_track_color = 'data-track-color="'.$track_color.'"';
	  	} else {
	  		$data_track_color = 'data-track-color="#f9f9f9"';
	  	}

	  	$size_chart = $size;
	  	if($size != '') {
	  		$size = 'size="'.$size.'"';
	  	} else {
	  		$size = 'size="150"';
	  	}




	  	$output .= '<div class="circular-progress-bar text-center">';
	  	$output .= '<div style="height:'.$size_chart.'px; width:'.$size_chart.'px; line-height:'.$size_chart.'px;" class="chart easyPieChart'.$css_class.'" data-percent="'.$number.'" '.$size.' '.$thickness.' '.$data_bar_color.' '.$data_track_color.'>';

	  	if($style == 'icon') {
	  		$output .= '<span class="cpb-icon"><i style="line-height:'.$size_chart.'px;'.$color.'" class="'.$color_default.' '.$icon.'"></i></span>';
	  	} else {
	  		$output .= '<span style="line-height:'.$size_chart.'px;'.$color.'" class="percent '.$color_default.'">'.$number.'</span>';
	  	}
	  	$output .= '</div>';
	  	if($title != ''){ $output .= '<span '.$title_color.' class="cpb-title '.$title_color_default.'">'.$title.'</span>'; }
	  	$output .= '</div>';

	  	return $output;
	  }
	}

	return array(
		'name' => __( 'Circular Progress Bar', 'vslmd' ),
		'base' => 've_circular_progress_bar',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		'show_settings_on_create' => true,
		'category' => __( 'Visual Elements', 'vslmd' ),
		'description' => __( 'Animated circular progress bar', 'vslmd' ),
		'params' => array(

			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'vslmd' ),
				'param_name' => 'title',
				'description' => __( 'Enter the title here.', 'vslmd' ),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'vslmd' ),
				'param_name' => 'style',
				'value' => array(
					__( 'Count Number', 'vslmd' ) => 'count_number',
					__( 'Just Icon', 'vslmd' ) => 'icon',
					),
				'description' => __( 'Choose a style.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Count Number', 'vslmd' ),
				'param_name' => 'number',
				'description' => __( 'Enter a number between 0 and 100 here.', 'vslmd' ),
				),

			array(
				'type' => 'iconmanager',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon',
				'description' => __( 'Select icon from library.', 'js_composer' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array( 'icon' ),
					),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Size', 'vslmd' ),
				'param_name' => 'size',
				'description' => __( 'Enter the Circular Progress Bar total size.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Thickness', 'vslmd' ),
				'param_name' => 'thickness',
				'description' => __( 'Enter the thickness bar.', 'vslmd' ),
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Title Color', 'vslmd' ),
				'param_name' => 'title_color',
				'description' => __( 'Select custom color for the title.', 'vslmd' ),
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Percentage and Icon Color', 'vslmd' ),
				'param_name' => 'color',
				'description' => __( 'Select custom color for the percentage or icon.', 'vslmd' ),
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Bar Color', 'vslmd' ),
				'param_name' => 'bar_color',
				'description' => __( 'Select custom color for the bar.', 'vslmd' ),
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Track Color', 'vslmd' ),
				'param_name' => 'track_color',
				'description' => __( 'Select custom color for the track.', 'vslmd' ),
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
