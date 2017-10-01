<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	List
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_list extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'list_item_1' => '',
			'list_item_2' => '',
			'list_item_3' => '',
			'list_item_4' => '',
			'list_item_5' => '',
			'list_item_6' => '',
			'list_item_7' => '',
			'list_item_8' => '',
			'list_item_9' => '',
			'list_item_10' => '',
			'list_item_11' => '',
			'list_item_12' => '',
			'list_item_13' => '',
			'list_item_14' => '',
			'list_item_15' => '',
			'list_item_16' => '',
			'list_item_17' => '',
			'list_item_18' => '',
			'list_item_19' => '',
			'list_item_20' => '',
			'icon' => '',
			'icon_color' => '',
			'custom_icon_color' => '',
			'alignment' => 'text-left',
			'tag' => 'h4',
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


	  // List Items

	  	$icon = isset( $icon ) ? esc_attr( $icon ) : 'fa fa-adjust';

	  	if($icon_color != '') {
	  		$custom_icon_color = 'style="color:'.$custom_icon_color.';"';
	  		$global_icon_color = '';
	  	} else {
	  		$icon_color = '';
	  		$global_icon_color = 've-global-color';
	  	}

	  	$list_items_counter = 1;
	  	$list_items = '';

	  	while( $list_items_counter <= 20 ){
	  		if(${'list_item_' . $list_items_counter} != ''){
	  			$list_items = $list_items .'<li><'.$tag.'><i '.$custom_icon_color.' class="'.$icon.' '.$global_icon_color.'"></i>'.${'list_item_' . $list_items_counter}.'</'.$tag.'></li>';
	  		}
	  		$list_items_counter++;
	  	}


	  	$list_items_content = '<ul>'.$list_items.'</ul>';


	  	$output .= '<div class="ve-list '.$css_class.' '.$alignment.'">';
	  	$output .= $list_items_content;
	  	$output .= '</div>';

	  	return $output;
	  }
	}

	return array(
		'name' => __( 'List', 'vslmd' ),
		'base' => 've_list',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		'show_settings_on_create' => true,
		'category' => __( 'Visual Elements', 'vslmd' ),
		'description' => __( 'Make your lists appealing', 'vslmd' ),
		'params' => array(

			array(
				'type' => 'dropdown',
				'heading' => __( 'Alignment', 'js_composer' ),
				'param_name' => 'alignment',
				'value' => array(
					__( 'Left', 'js_composer' ) => 'text-left',
					__( 'Right', 'js_composer' ) => 'text-right',
					__( 'Center', 'js_composer' ) => 'text-center',
					),
				'description' => __( 'Select alignment.', 'js_composer' ),
				),

			array(
			'type' => 'dropdown',
			'heading' => __( 'Tag', 'vslmd' ),
			'param_name' => 'tag',
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
			'default' => 'h3',
			'description' => __( 'Select tag.', 'vslmd' ),
			),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 1', 'vslmd' ),
				'param_name' => 'list_item_1',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 2', 'vslmd' ),
				'param_name' => 'list_item_2',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 3', 'vslmd' ),
				'param_name' => 'list_item_3',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 4', 'vslmd' ),
				'param_name' => 'list_item_4',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 5', 'vslmd' ),
				'param_name' => 'list_item_5',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 6', 'vslmd' ),
				'param_name' => 'list_item_6',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 7', 'vslmd' ),
				'param_name' => 'list_item_7',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 8', 'vslmd' ),
				'param_name' => 'list_item_8',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 9', 'vslmd' ),
				'param_name' => 'list_item_9',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 10', 'vslmd' ),
				'param_name' => 'list_item_10',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 11', 'vslmd' ),
				'param_name' => 'list_item_11',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 12', 'vslmd' ),
				'param_name' => 'list_item_12',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 13', 'vslmd' ),
				'param_name' => 'list_item_13',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 14', 'vslmd' ),
				'param_name' => 'list_item_14',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 15', 'vslmd' ),
				'param_name' => 'list_item_15',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 16', 'vslmd' ),
				'param_name' => 'list_item_16',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 17', 'vslmd' ),
				'param_name' => 'list_item_17',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 18', 'vslmd' ),
				'param_name' => 'list_item_18',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 19', 'vslmd' ),
				'param_name' => 'list_item_19',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

			array(
				'type' => 'textfield',
				'heading' => __( 'List Item 20', 'vslmd' ),
				'param_name' => 'list_item_20',
				'description' => __( 'Enter list item.', 'vslmd' ),
				),

		/*
		 * Icon Tab
		 */

		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'js_composer' ),
			'group' => 'Icon',
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
			'group' => 'Icon',
			),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Icon Color', 'js_composer' ),
			'param_name' => 'custom_icon_color',
			'description' => __( 'Select custom icon color.', 'js_composer' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_color',
				'value' => array( 'custom' ),
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
