<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Modal
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_modal extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'modal_title' => '',
			'modal_size' => '',
			'button_title' => 'Modal Button',
			'button_text_color' => '#ffffff',
			'button_background_color' => '',
			'button_shape' => 'rounded',
			'button_size' => 'btn-lg',
			'button_extra_size' => '',
			'button_alignment' => 'text-center',
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

	  	$modal_item_id = strtolower(str_replace(' ', '_', $modal_title));

	  	//Button

	  	if( $button_shape == 'rounded' || $button_shape == 'square' || $button_shape == 'round' ){
	  		if($button_background_color != '') {
	  			$button_background_color = 'background-color:'.$button_background_color.';';
	  			$global_button_background_color = '';
	  		} else {
	  			$button_background_color = '';
	  			$global_button_background_color = $ve_global_background_color;
	  		}
	  	} else {
	  		if($button_background_color != '') {
	  			$button_background_color = 'border-width: 2px;border-style: solid;border-color:'.$button_background_color.';';
	  			$global_button_background_color = '';
	  		} else {
	  			$button_background_color = 'border-width: 2px;border-style: solid;';
	  			$global_button_background_color = $ve_global_border_color;
	  		}
	  	}

	  	$modal_button_content = '<div class="'.$button_alignment.'"><a style="'.$button_background_color.' color:'.$button_text_color.';padding:'.$button_extra_size.';" class="'.$global_button_background_color.' '.$button_shape.' modal-button btn '.$button_size.'" data-toggle="modal" data-target="#'.$modal_item_id.'">'.$button_title.'</a></div>';



	  	$output .= '<div class="ve-modal '.$css_class.'">';
	  	$output .= $modal_button_content;
	  	

	  	$output .= '<div class="modal fade" id="'.$modal_item_id.'" tabindex="-1" role="dialog" aria-labelledby="'.$modal_item_id.'_label">
	  	<div class="modal-dialog '.$modal_size.'" role="document">
	  		<div class="modal-content">
	  			<div class="modal-header">
	  				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				<h4 class="modal-title" id="'.$modal_item_id.'_label">'.$modal_title.'</h4>
	  			</div>
	  			<div class="modal-body">
	  				'.wpb_js_remove_wpautop($content).'
	  			</div>
	  			<div class="modal-footer">
	  				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
	  			</div>
	  		</div>
	  	</div>
	  </div>';

	  $output .= '</div>';

	  return $output;
	}
}


vc_map( array(
	'name' => __( 'Modal', 'js_composer' ),
	'base' => 've_modal',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	"as_parent" => array('only' => 'vc_row'),
	"content_element" => true,
	"show_settings_on_create" => true,
	"is_container" => true,
	'category' => __( 'Visual Elements', 'js_composer' ),
	'description' => __( 'Add modal in your content', 'js_composer' ),
	'params' => array(

		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'vslmd' ),
			'param_name' => 'modal_title',
			'description' => __( 'Enter the title here.', 'vslmd' ),		
			),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Size', 'js_composer' ),
			'param_name' => 'modal_size',
			'value' => array(
				__( 'Default', 'js_composer' ) => '',
				__( 'Small', 'js_composer' ) => 'modal-sm',
				__( 'Large', 'js_composer' ) => 'modal-lg',
				),
			'description' => __( 'Modals have three optional sizes.', 'js_composer' ),
			),

			/*
		 * Button Tab
		 */

			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'vslmd' ),
				'param_name' => 'button_title',
				'description' => __( 'Enter the title here.', 'vslmd' ),
				'group' => 'Button',			
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Text Color', 'js_composer' ),
				'param_name' => 'button_text_color',
				'description' => __( 'Select button text color.', 'js_composer' ),
			//CURIOSIDADE'param_holder_class' => 'vc_colored-dropdown vc_btn3-colored-dropdown',
				'value' => '#ffffff',
				'group' => 'Button',
				),

			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background Color', 'js_composer' ),
				'param_name' => 'button_background_color',
				'description' => __( 'Select button background color.', 'js_composer' ),
				'group' => 'Button',
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Shape', 'js_composer' ),
				'description' => __( 'Select button shape.', 'js_composer' ),
				'param_name' => 'button_shape',
				'group' => 'Button',
				'value' => array(
					__( 'Rounded', 'js_composer' ) => 'rounded',
					__( 'Square', 'js_composer' ) => 'square',
					__( 'Round', 'js_composer' ) => 'round',
					__( 'Outline Rounded', 'js_composer' ) => 'outline-rounded',
					__( 'Outline Square', 'js_composer' ) => 'outline-square',
					__( 'Outline Round', 'js_composer' ) => 'outline-round',
					),
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Size', 'js_composer' ),
				'param_name' => 'button_size',
				'value' => array(
					__( 'Extra Small', 'js_composer' ) => 'btn-xs',
					__( 'Small', 'js_composer' ) => 'btn-sm',
					__( 'Medium', 'js_composer' ) => 'btn-md',
					__( 'Large', 'js_composer' ) => 'btn-lg',
					__( 'Block', 'js_composer' ) => 'btn-block',
					),
				'description' => __( 'Select button display size.', 'js_composer' ),
				'group' => 'Button',
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'Extra Size', 'vslmd' ),
				'param_name' => 'button_extra_size',
				'description' => __( 'Enter extra size.', 'vslmd' ),
				'group' => 'Button',			
				),

			array(
				'type' => 'dropdown',
				'heading' => __( 'Alignment', 'js_composer' ),
				'param_name' => 'button_alignment',
				'value' => array(
					__( 'Left', 'js_composer' ) => 'text-left',
					__( 'Right', 'js_composer' ) => 'text-right',
					__( 'Center', 'js_composer' ) => 'text-center',
					),
				'description' => __( 'Select button alignment.', 'js_composer' ),
				'group' => 'Button',
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