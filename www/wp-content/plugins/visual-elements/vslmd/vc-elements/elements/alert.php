<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Alert
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_alert extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'alert-success',
			'dismissible_alert' => '',
			'alert' => '',
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

	  	if ($dismissible_alert == 'dismissible') {
	  		$alert = 'alert-dismissible';
	  		$dismissible_button = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	  	} else {
	  		$alert = '';
	  		$dismissible_button = '';
	  	}


	  	$output .= '<div class="ve-alert '.$css_class.'">';
	  	$output .= '<div class="alert '.$type.' '.$alert.'" role="alert">';
	  	$output .= $dismissible_button;
	  	$output .= $content;
	  	$output .= '</div>';
	  	$output .= '</div>';

	  	return $output;
	  }
	}

	return array(
		'name' => __( 'Alert', 'vslmd' ),
		'base' => 've_alert',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		'show_settings_on_create' => true,
		'category' => __( 'Visual Elements', 'vslmd' ),
		'description' => __( 'Provide contextual feedback messages', 'vslmd' ),
		'params' => array(

			array(
				'type' => 'dropdown',
				'heading' => __( 'Type', 'js_composer' ),
				'param_name' => 'type',
				'value' => array(
					__( 'Success', 'js_composer' ) => 'alert-success',
					__( 'Info', 'js_composer' ) => 'alert-info',
					__( 'Warning', 'js_composer' ) => 'alert-warning',
					__( 'Danger', 'js_composer' ) => 'alert-danger',
					),
				'description' => __( 'Select context type.', 'js_composer' ),
				),

			array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => __( 'Message', 'js_composer' ),
			'param_name' => 'content',
			'description' => __( 'Enter short message.', 'vslmd' ),
			),

			array(
			'type' => 'checkbox',
			'heading' => __('Dismissible alert', 'js_composer'),
			'param_name' => 'dismissible_alert',
			'value' => array(
				__( 'Add close button.', 'js_composer' ) => 'dismissible',
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
