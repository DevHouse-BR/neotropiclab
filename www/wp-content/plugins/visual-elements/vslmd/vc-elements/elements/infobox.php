<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Infobox
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_infobox extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'link' => '',
			'icon_display' => '',
			'custom_image_icon' => '',
			'custom_svg_icon' => '',
			'icon' => '',
			'icon_color' => '',
			'custom_icon_color' => '',
			'shape' => '',
			'color_shape' => '',
			'icon_size' => '',
			'icon_spacing' => '',
			'icon_gap' => '0',
			'style' => 'column',
			'alignment' => 'flex-start',
			'icon_animation' => '',
			'title_tag' => 'h3',
			'title_size' => '',
			'title_line_height' => '',
			'title_spacing' => '',
			'title_alignment' => '',
			'title_color' => '',	
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

	  // Title
	  	if($link != '') {
	  		$link = vc_build_link( $link );
	  		$link_start = '<a href="'.esc_attr( $link['url'] ).'">';
	  		$link_finish = '</a>';
	  	} else {
	  		$link_start = '';
	  		$link_finish = '';
	  	}

	  	if ($title_color == '') {
	  		$title_color = '';
	  		$default_title_color = $ve_global_color;
	  	} else {
	  		$title_color = 'color:'.$title_color.';';
	  		$default_title_color = '';
	  	}

	  	if ($title_size != '') {
	  		$title_size = 'font-size:'.$title_size.';';
	  	} else {
	  		$title_size = '';
	  	}

	  	if ($title_line_height != '') {
	  		$title_line_height = 'line-height:'.$title_line_height.';';
	  	} else {
	  		$title_line_height = '';
	  	}

	  	if ($title_spacing != '') {
	  		$title_spacing = 'margin:'.$title_spacing.';';
	  	} else {
	  		$title_spacing = '';
	  	}

	  	if ($title_alignment != '') {
	  		$title_alignment = 'text-align:'.$title_alignment.';';
	  	} else {
	  		$title_alignment = '';
	  	}

	  	$title_content = ''.$link_start.'<'.$title_tag.' class="'.$default_title_color.'" style="'.$title_size.$title_line_height.$title_spacing.$title_alignment.$title_color.'">'.$title.'</'.$title_tag.'>'.$link_finish.'';


	  // Icon
	  	if ($icon_display == 'image_icon') {

	  		$default_src = vc_asset_url( 'vc/no_image.png' );
	  		$img = wp_get_attachment_image_src( $custom_image_icon );
	  		$src = $img[0];
	  		$custom_src = $src ? esc_attr( $src ) : $default_src;

	  		$icon_content = '<img src="'.$custom_src.'" >';

	  	} elseif ($icon_display == 'svg_icon') {

	  		$default_src = vc_asset_url( 'vc/no_image.png' );
	  		$img = wp_get_attachment_image_src( $custom_svg_icon );
	  		$src = $img[0];
	  		$custom_src = $src ? esc_attr( $src ) : $default_src;

	  		$icon_content = '<div class="elvn"><img class="vesvg" src="'.$custom_src.'" ></div>';

	  	} else {

	  		$iconClass = isset( $icon ) ? esc_attr( $icon ) : 'fa fa-adjust';

	  		if($icon_color != '') {
	  			$custom_icon_color = 'color:'.$custom_icon_color.';';
	  			$global_icon_color = '';
	  		} else {
	  			$icon_color = '';
	  			$global_icon_color = 've-global-color';
	  		}

	  		$font_size_reference = $icon_size;

	  		if($icon_size != '') {
	  			$icon_size = 'font-size:'.$icon_size.';';
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

	  			if($icon_spacing != '') {
	  				$icon_spacing = 'height:'.$icon_spacing.'; width:'.$icon_spacing.';';
	  			} else {
	  				$icon_spacing = 'height:calc('.$font_size_reference.' + 2em); width:calc('.$font_size_reference.' + 2em);';
	  			}

	  			$shape_render_start = '<div class="icon-infobox '.$shape.' '.$default_color_shape.'" style="'.$color_shape.''.$icon_spacing.'">';
	  			$shape_render_finish = '</div>';

	  		} else {
	  			$shape_render_start = '';
	  			$shape_render_finish = '';
	  		}

	  		$icon_content = ''.$shape_render_start.'<span style="'.$custom_icon_color.' '.$icon_size.'" class="vc_icon_element-icon '.$global_icon_color.' '.$iconClass.' '.$icon_animation.'"></span>'.$shape_render_finish.'';
	  	}

	  // Gap

	  	$icon_gap = 'style="margin:'.$icon_gap.';"';

	  // Style

	  	$style_alignment = 'style="flex-direction:'.$style.'; align-items:'.$alignment.';"';

	  //Output
	  	$output .= '<div class="infobox '.$css_class.'" '.$style_alignment.'>';
	  	$output .= '<div class="infobox-icon" '.$icon_gap.'>';
	  	$output .= $icon_content;
	  	$output .= '</div>';
	  	$output .= '<div class="infobox-content">';
	  	$output .= $title_content;
	  	$output .= $content;
	  	$output .= '</div>';
	  	$output .= '</div>';

	  	return $output;
	  }
	}

	return array(
		'name' => __( 'Infobox', 'vslmd' ),
		'base' => 've_infobox',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		'show_settings_on_create' => true,
		'category' => __( 'Visual Elements', 'vslmd' ),
		'description' => __( 'Create nice looking infoboxes', 'vslmd' ),
		'params' => array(

			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'vslmd' ),
				'param_name' => 'title',
				'description' => __( 'Enter the title here.', 'vslmd' ),
				),

			array(
				'type' => 'vc_link',
				'heading' => __( 'URL (Link)', 'js_composer' ),
				'param_name' => 'link',
				'description' => __( 'Add link to infobox title.', 'js_composer' ),
				),

			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __( 'Description', 'js_composer' ),
				'param_name' => 'content',
				'description' => __( 'Provide the description for this Infobox.', 'js_composer' ),
				'value' => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' ),
				),

		/*
		 * Icon Tab
		 */

		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon to display', 'vslmd' ),
			'param_name' => 'icon_display',
			'value' => array(
				__( 'Icon Manager', 'vslmd' ) => 'icon_manager',
				__( 'Image Icon', 'vslmd' ) => 'image_icon',
				__( 'SVG Icon', 'vslmd' ) => 'svg_icon',
				),
			'description' => __( 'Enable Icon Library.', 'vslmd' ),
			'group' => 'Icon',
			),

		array(
			'type' => 'attach_image',
			'heading' => __( 'Upload Image Icon', 'js_composer' ),
			'param_name' => 'custom_image_icon',
			'description' => __( 'Upload the custom image icon.', 'js_composer' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'image_icon' ),
				),
			),

		array(
			'type' => 'attach_image',
			'heading' => __( 'Upload SVG Icon', 'js_composer' ),
			'param_name' => 'custom_svg_icon',
			'description' => __( 'Upload the custom svg icon.', 'js_composer' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'svg_icon' ),
				),
			),

		array(
			'type' => 'iconmanager',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon',
			'description' => __( 'Select icon from library.', 'js_composer' ),
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
				),
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
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
				),
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
		array(
			'type' => 'dropdown',
			'heading' => __( 'Shape', 'js_composer' ),
			'description' => __( 'Select icon shape.', 'js_composer' ),
			'param_name' => 'shape',
			'group' => 'Icon',
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
				),
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
			'group' => 'Icon',
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
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
				),
			'group' => 'Icon',
			),
		array(
			'type' => 'textfield',
			'heading' => __( 'Spacing', 'js_composer' ),
			'param_name' => 'icon_spacing',
			'description' => __( 'Select icon spacing. e.g. 16px.', 'js_composer' ),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
				),
			'group' => 'Icon',
			),
		array(
			'type' => 'textfield',
			'heading' => __( 'Gap', 'js_composer' ),
			'param_name' => 'icon_gap',
			'description' => __( 'Select icon gap. e.g. 16px.', 'js_composer' ),
			'group' => 'Icon',
			),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'vslmd' ),
			'param_name' => 'style',
			'value' => array(
				__( 'Icon at Top', 'vslmd' ) => 'column',
				__( 'Icon at Bottom', 'vslmd' ) => 'column-reverse',
				__( 'Icon at Left', 'vslmd' ) => 'row',
				__( 'Icon at Right', 'vslmd' ) => 'row-reverse',
				),
			'description' => __( 'Select icon position. Icon box style will be changed according to the icon position.', 'vslmd' ),
			'group' => 'Icon',
			),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Alignment', 'js_composer' ),
			'param_name' => 'alignment',
			'value' => array(
				__( 'Start', 'js_composer' ) => 'flex-start',
				__( 'Center', 'js_composer' ) => 'center',
				__( 'End', 'js_composer' ) => 'flex-end',
				),
			'description' => __( 'Select icon alignment.', 'js_composer' ),
			'group' => 'Icon',
			),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon Animation', 'vslmd' ),
			'param_name' => 'icon_animation',
			'value' => array(
				__( 'No Animation', 'vslmd' ) => '',
				__( 'Bounce', 'vslmd' ) => 'bounce',
				__( 'Bounce Up', 'vslmd' ) => 'bounce-up',
				__( 'Pulse', 'vslmd' ) => 'pulse',
				__( 'Zoom', 'vslmd' ) => 'zoom',
				
				),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
				),
			'description' => __( 'Select the type of animation you want on hover.', 'vslmd' ),
			'group' => 'Icon',
			),

		/*
		 * Typography Tab
		 */

		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Tag', 'vslmd' ),
			'param_name' => 'title_tag',
			'group' => 'Typography',
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
			'description' => __( 'Select title tag.', 'vslmd' ),
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Title Font Size', 'vslmd' ),
			'param_name' => 'title_size',
			'description' => __( 'Enter font size.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Title Line Height', 'vslmd' ),
			'param_name' => 'title_line_height',
			'description' => __( 'Enter line height.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Title Spacing', 'js_composer' ),
			'param_name' => 'title_spacing',
			'description' => __( 'Select title spacing. e.g. 16px.', 'js_composer' ),
			'group' => 'Typography',
			),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Title Alignment', 'js_composer' ),
			'param_name' => 'title_alignment',
			'value' => array(
				__( 'Left', 'js_composer' ) => 'left',
				__( 'Right', 'js_composer' ) => 'right',
				__( 'Center', 'js_composer' ) => 'center',
				),
			'description' => __( 'Select title alignment.', 'js_composer' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'vslmd' ),
			'param_name' => 'title_color',
			'description' => __( 'Select custom color for the title.', 'vslmd' ),
			'group' => 'Typography',
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
