<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Icons
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_icons extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'direction' => 'row',
			'justify_content' => 'flex-start',
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

	  	



	  	$output .= '<div class="ve-icons '.$css_class.'" style="justify-content:'.$justify_content.'; flex-direction:'.$direction.'">';
	  	$output .= wpb_js_remove_wpautop($content);
	  	$output .= '</div>';

	  return $output;
	}
}


vc_map( array(
	'name' => __( 'Icons', 'js_composer' ),
	'base' => 've_icons',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	"as_parent" => array('only' => 've_icon'),
	"content_element" => true,
	"show_settings_on_create" => false,
	"is_container" => true,
	'category' => __( 'Visual Elements', 'js_composer' ),
	'description' => __( 'Add and manage multiple icons', 'js_composer' ),
	'params' => array(

		array(
			'type' => 'dropdown',
			'heading' => __( 'Direction', 'js_composer' ),
			'param_name' => 'direction',
			'value' => array(
				__( 'Row', 'js_composer' ) => 'row',
				__( 'Row Reverse', 'js_composer' ) => 'row-reverse',
				__( 'Column', 'js_composer' ) => 'column',
				__( 'Column Reverse', 'js_composer' ) => 'column-reverse',
				),
			'description' => __( 'Select the direction icons list.', 'js_composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Justify Content', 'js_composer' ),
				'param_name' => 'justify_content',
				'value' => array(
					__( 'Left', 'js_composer' ) => 'flex-start',
					__( 'Right', 'js_composer' ) => 'flex-end',
					__( 'Center', 'js_composer' ) => 'center',
					__( 'Space Around', 'js_composer' ) => 'space-around',
					__( 'Space Between', 'js_composer' ) => 'space-between',
					),
				'description' => __( 'Select icons alignment.', 'js_composer' ),
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
			),
	"js_view" => 'VcColumnView'
	) );