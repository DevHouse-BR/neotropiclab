<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	SVG Icon
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_svg extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'svg' => '',
			'svg_alignment' => 'left',
	  		//Static
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
			), $atts ) );
		$output = '';
      	$ve_global_color = 've-global-color'; //General Color
	  	$ve_global_border_color = 've-global-border-color'; //Border Color
	  	$ve_global_background_color = 've-global-background-color'; //Background Color
	  	
	  	if($svg_alignment == 'left') {
	  		$svg_alignment = 'text-left';
	  	}else if($svg_alignment == 'right') {
	  		$svg_alignment = 'text-right'; 
	  	}else {
	  		$svg_alignment = 'text-center'; 
	  	}
	  	
	  	$svg_img = wp_get_attachment_image_src( $svg );
	  	$svg_src = $svg_img[0];
	  	
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
	  	
	  	$output .= '<div class="'.$css_class.'">
	  	<div class="elvn '. $svg_alignment.'"><img class="vesvg" src="'.$svg_src.'"/></div>
	  </div>';

	  return $output;
	}
}

return array(
	'name' => __( 'SVG', 'js_composer' ),
	'base' => 've_svg',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	'show_settings_on_create' => true,
	'category' => __( 'Visual Elements', 'js_composer' ),
	'description' => __( 'Animated or static SVG for your content', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'attach_image',
			'heading' => __( 'SVG', 'js_composer' ),
			'param_name' => 'svg',
			'description' => __( 'Select a SVG Icon from media library.', 'js_composer' ),
			),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Alignment', 'js_composer' ),
			'param_name' => 'svg_alignment',
			'value' => array(
				__( 'Left', 'js_composer' ) => 'left',
				__( 'Right', 'js_composer' ) => 'right',
				__( 'Center', 'js_composer' ) => 'center',
				),
			'description' => __( 'Select icon alignment.', 'js_composer' ),
			),

		// Animation
		vc_map_add_css_animation(),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
			),
		
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'js_composer' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'js_composer' ),
			),
		),
	);
