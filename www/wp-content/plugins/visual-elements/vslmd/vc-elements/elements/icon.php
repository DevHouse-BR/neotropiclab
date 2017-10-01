<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Icon
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_icon extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'icon' => '',
			'icon_color' => '',
			'custom_icon_color' => '',
			'shape' => '',
			'color_shape' => '',
			'icon_size' => '',
			'spacing' => '',
			'icon_alignment' => 'left',
			'link' => '',
			//Static
			'el_class' => '',
			'css' => '',
			'css_animation' => ''
			), $atts ) );
		$output = '';
      	$ve_global_color = 've-global-color'; //General Color
	  	$ve_global_border_color = 've-global-border-color'; //Border Color
	  	$ve_global_background_color = 've-global-background-color'; //Background Color

	  
	  // URL Builder

	  $link = vc_build_link( $link );


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


	  $color = $default_color = '';	
	  if($icon_color == 'custom') {
	  	$color = 'color:'.$custom_icon_color.';';
	  } else {
	  	$default_color = ' '.$ve_global_color;
	  }

	  $font_size_reference = $icon_size;
	  if($icon_size != '') {
	  	$icon_size = ' font-size:'.$icon_size.';';
	  } else {
	  	$icon_size = ' font-size:4rem;';
	  }

	  
	  if($icon_alignment != '') {
	  	$icon_alignment = 'text-align:'.$icon_alignment.';';
	  }

	  if($shape != '') {

	  	if($shape == 'rounded' || $shape == 'square' || $shape == 'round') {

	  		if($color_shape != '') {
	  			$color_shape = 'background-color:'.$color_shape.';';
	  			$default_color_shape = '';
	  		} else {
	  			$color_shape = '';
	  			$default_color_shape = 've-global-background-color';
	  		}

	  	} else {

	  		if($color_shape != '') {    
	  			$color_shape = 'border-color:'.$color_shape.';';
	  			$default_color_shape = '';
	  		} else {
	  			$color_shape = '';
	  			$default_color_shape = 've-global-border-color';
	  		}

	  	}

	  } else {
	  	$color_shape = '';
	  	$default_color_shape = '';
	  }

	  if($spacing != '') {
	  	$spacing = 'height:'.$spacing.'; width:'.$spacing.';';
	  } else {
	  	$spacing = 'height:calc('.$font_size_reference.' + 2em); width:calc('.$font_size_reference.' + 2em);';
	  }


	  $output .= '<div class="background-shape '.$css_class.'" style="'.$icon_alignment.'">';
	  if($link['url'] != ''){$output .= '<a href="'.esc_attr( $link['url'] ).'">';}
	  $output .= '<div style="'.$color_shape.''.$spacing.'" class="single-icon '.$shape.' '.$default_color_shape.'">';
	  $output .= '<i class="'.$icon.$default_color.'" style="'.$color.$icon_size.'" aria-hidden="true"></i>';
	  $output .= '</div>';
	  if($link['url'] != ''){$output .= '</a>';}
	  $output .= '</div>';

	  return $output;
	}
}

return array(
	'name' => __( 'Icon', 'js_composer' ),
	'base' => 've_icon',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	'show_settings_on_create' => true,
	'category' => __( 'Visual Elements', 'js_composer' ),
	'description' => __( 'Eye catching icons from libraries', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'js_composer' ),
			),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon color', 'js_composer' ),
			'param_name' => 'icon_color',
			'value' => array(
				__( 'Preset Color', 'js_composer' ) => '',
				__( 'Custom Color', 'js_composer' ) => 'custom',
				),
			'description' => __( 'Select icon color.', 'js_composer' ),
			),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Icon Color', 'js_composer' ),
			'param_name' => 'custom_icon_color',
			'description' => __( 'Select custom icon color.', 'js_composer' ),
			'dependency' => array(
				'element' => 'icon_color',
				'value' => array( 'custom' ),
				),
			),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Shape', 'js_composer' ),
			'description' => __( 'Select icon shape.', 'js_composer' ),
			'param_name' => 'shape',
			'value' => array(
				__( 'None', 'js_composer' ) => '',
				__( 'Rounded', 'js_composer' ) => 'rounded',
				__( 'Square', 'js_composer' ) => 'square',
				__( 'Round', 'js_composer' ) => 'round',
				__( 'Outline Rounded', 'js_composer' ) => 'outline-rounded',
				__( 'Outline Square', 'js_composer' ) => 'outline-square',
				__( 'Outline Round', 'js_composer' ) => 'outline-round',
				),
			),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Color Shape', 'js_composer' ),
			'param_name' => 'color_shape',
			'description' => __( 'Select custom shape background color.', 'js_composer' ),
			'dependency' => array(
				'element' => 'shape',
				'value' => array( 'rounded','square','round','outline-rounded','outline-square','outline-round',  ),
				),
			),
		array(
			'type' => 'textfield',
			'heading' => __( 'Size', 'js_composer' ),
			'param_name' => 'icon_size',
			'description' => __( 'Icon size. Default value is 16px.', 'js_composer' ),
			),
		array(
			'type' => 'textfield',
			'heading' => __( 'Spacing', 'js_composer' ),
			'param_name' => 'spacing',
			'description' => __( 'Select icon spacing.', 'js_composer' ),
			),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Alignment', 'js_composer' ),
			'param_name' => 'icon_alignment',
			'value' => array(
				__( 'Left', 'js_composer' ) => 'left',
				__( 'Right', 'js_composer' ) => 'right',
				__( 'Center', 'js_composer' ) => 'center',
				),
			'description' => __( 'Select icon alignment.', 'js_composer' ),
			),
		array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'js_composer' ),
			'param_name' => 'link',
			'description' => __( 'Add link to icon.', 'js_composer' ),
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
