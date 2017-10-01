<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Testimonials
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_testimonial_section extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
      extract( shortcode_atts( array(
	  	'title' => '',
		'occupation' => '',
		'photo' => '',
		'content' => $content,
		'testimonial_color' => '',
		'testimonial_name_color' => '',
		'testimonial_occupation_color' => '',
	  	//Static
		'el_class' => '',
		'css' => '',
		'css_animation' => ''
      ), $atts ) );
      $output = '';

      // Picture
	  
	  $img = wp_get_attachment_image_src( $photo, 'thumbnail' );
      $imgSrc = $img[0];
	  
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

	  if($testimonial_color != '') {
	  	$testimonial_color = 'style= "color:'.$testimonial_color.'"';
	  } else {
	  	$testimonial_color = '';
	  }

	  if($testimonial_name_color != '') {
	  	$testimonial_name_color = 'style= "color:'.$testimonial_name_color.'"';
	  } else {
	  	$testimonial_name_color = '';
	  }

	  if($testimonial_occupation_color != '') {
	  	$testimonial_occupation_color = 'style= "color:'.$testimonial_occupation_color.'"';
	  } else {
	  	$testimonial_occupation_color = '';
	  }

	  
	  $output .= '<li class="'.$css_class.'">';
	  $output .= '<p '.$testimonial_color.' class="testimonial-quote">'.$content.'</p>';
	  if(!empty($photo)){ $output .= '<p class="testimonial-photo"><img src="'.$imgSrc.'" /></p>'; }
	  $output .= '<p '.$testimonial_name_color.' class="testimonial-title">'.$title.'</p>';
	  $output .= '<p '.$testimonial_occupation_color.' class="testimonial-occupation">'.$occupation.'</p>';
	  $output .= '</li>';
	  
	return $output;
	}
}

class WPBakeryShortCode_ve_testimonial_container extends WPBakeryShortCodesContainer {
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

	  
	  $output .= '<div class="testimonial-builder'.' '.$css_class.'">
	  			  	<div class="testimonials">
						<div class="testimonials-container">
							<div class="testimonial">
								<ul class="slides">'.wpb_js_remove_wpautop($content).'</ul>
							</div>
						</div>
	  			  	</div>
				</div>';
	  
	return $output;
	}
}

vc_map( array(
	'name' => __( 'Testimonial', 'js_composer' ),
	'base' => 've_testimonial_container',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
    "as_parent" => array('only' => 've_testimonial_section'),
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
	'category' => __( 'Visual Elements', 'js_composer' ),
	'description' => __( 'Display testimonials', 'js_composer' ),
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
    "name" => __("Testimonial Section", 'js_composer'),
	'description' => __( 'Testimonial content panels item.', 'js_composer' ),
    "base" => "ve_testimonial_section",
	'icon' => plugins_url('shortcodes-icon-sec.png', __FILE__),
    "content_element" => true,
    "as_child" => array('only' => 've_testimonial_container'), 
    "params" => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Name', 'js_composer' ),
			'param_name' => 'title',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Occupation', 'js_composer' ),
			'param_name' => 'occupation',
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Photo', 'js_composer' ),
			'param_name' => 'photo',
			'value' => '',
			'description' => __( 'Select image from media library.', 'js_composer' ),
		),
        array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => __( 'Content', 'js_composer' ),
			'param_name' => 'content',
			'value' => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' ),
		),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Testimonial Color', 'js_composer' ),
			'param_name' => 'testimonial_color',
			'description' => __( 'Select testimonial content color.', 'js_composer' ),
			'group' => 'Color',
			),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Testimonial Name Color', 'js_composer' ),
			'param_name' => 'testimonial_name_color',
			'description' => __( 'Select testimonial name color.', 'js_composer' ),
			'group' => 'Color',
			),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Testimonial Occupation Color', 'js_composer' ),
			'param_name' => 'testimonial_occupation_color',
			'description' => __( 'Select testimonial occupation color.', 'js_composer' ),
			'group' => 'Color',
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