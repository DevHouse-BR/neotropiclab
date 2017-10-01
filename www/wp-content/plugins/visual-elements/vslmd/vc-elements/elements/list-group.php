<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	List Group
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_list_group extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
	  	//Static
		'el_class' => '',
		'css' => '',
		'css_animation' => ''
      ), $atts ) );
      $output = '';
	  
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

	  
	  $output .= '<div class="ve-list-group'.' '.$css_class.'">';
	  $output .= '<div class="list-group">'.wpb_js_remove_wpautop($content).'</div>';
	  $output .= '</div>';
	  
	return $output;
	}
}

class WPBakeryShortCode_ve_list_group_item extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
      	'title' => '',
      	'link' => '',
      	'icon' => '',
	  	//Static
		'el_class' => '',
		'css' => '',
		'css_animation' => ''
      ), $atts ) );
      $output = '';

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

	  // Icon

	  if ($icon != '') {
	  	$icon = '<i class="'.$icon.'" aria-hidden="true"></i>';
	  } else {
	  	$icon = '';
	  }
	  
	  if($link['url'] != ''){
	  	$output .= '<a href="'.esc_attr( $link['url'] ).'" class="list-group-item '.$css_class.'">'.$icon.''.$title.'</a>';
	  } else {
	  	$output .= '<a href="#" class="list-group-item '.$css_class.'">'.$icon.''.$title.'</a>';
	  }
	  
	return $output;
	}
}

vc_map( array(
	'name' => __( 'List Group', 'js_composer' ),
	'base' => 've_list_group',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
    "as_parent" => array('only' => 've_list_group_item'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
	'category' => __( 'Visual Elements', 'js_composer' ),
	'description' => __( 'Show a flexible and powerful list', 'js_composer' ),
	'params' => array(
		
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
    "js_view" => 'VcColumnView'
) );

vc_map( array(
    "name" => __("List Item", 'js_composer'),
	'description' => __( 'Display List Group Item', 'js_composer' ),
    "base" => "ve_list_group_item",
	'icon' => plugins_url('shortcodes-icon-sec.png', __FILE__),
    "content_element" => true,
    "as_child" => array('only' => 've_list_group'), 
    "params" => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'js_composer' ),
			'param_name' => 'title',
		),

		array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'js_composer' ),
			'param_name' => 'link',
			'description' => __( 'Add link to List Item.', 'js_composer' ),
			),

		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'js_composer' ),
			),

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
    )
) );