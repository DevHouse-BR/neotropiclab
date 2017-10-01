<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Restaurant Menu
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_restaurant_menu_block extends WPBakeryShortCodesContainer {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
			'title_tag' => 'h3',
			'title_size' => '',
			'title_line_height' => '',
			'title_spacing' => '',
			'title_alignment' => '',
			'title_color' => '',
			'caption' => '',
			'caption_tag' => 'div',
			'caption_size' => '',
			'caption_line_height' => '',
			'caption_spacing' => '',
			'caption_alignment' => '',
			'caption_color' => '',
			'icon_display' => '',
			'custom_image_icon' => '',
			'custom_svg_icon' => '',
			'icon' => '',
			'icon_color' => '',
			'custom_icon_color' => '',
			'shape' => '',
			'color_shape' => '',
			'icon_size' => '8rem',
			'icon_spacing' => '',
			'icon_alignment' => 'left',
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
	  	$title_content = '<'.$title_tag.' style="font-size:'.$title_size.';line-height:'.$title_line_height.';margin:'.$title_spacing.';text-align:'.$title_alignment.';color:'.$title_color.';">'.$title.'</'.$title_tag.'>';

	  	// Caption
	  	$caption_content = '<'.$caption_tag.' style="font-size:'.$caption_size.';line-height:'.$caption_line_height.';margin:'.$caption_spacing.';text-align:'.$caption_alignment.';color:'.$caption_color.';">'.$caption.'</'.$caption_tag.'>';


	  	// Icon
	  	if ($icon_display == 'image_icon') {

	  		if($icon_alignment != '') {
	  			$icon_alignment = 'text-align:'.$icon_alignment.';';
	  		}

	  		$default_src = vc_asset_url( 'vc/no_image.png' );
	  		$img = wp_get_attachment_image_src( $custom_image_icon );
	  		$src = $img[0];
	  		$custom_src = $src ? esc_attr( $src ) : $default_src;

	  		$icon_content = '<div style="'.$icon_alignment.'"><img src="'.$custom_src.'" ></div>';

	  	} elseif ($icon_display == 'svg_icon') {

	  		if($icon_alignment != '') {
	  			$icon_alignment = 'text-align:'.$icon_alignment.';';
	  		}

	  		$default_src = vc_asset_url( 'vc/no_image.png' );
	  		$img = wp_get_attachment_image_src( $custom_svg_icon );
	  		$src = $img[0];
	  		$custom_src = $src ? esc_attr( $src ) : $default_src;

	  		$icon_content = '<div class="elvn" style="'.$icon_alignment.'"><img class="vesvg" src="'.$custom_src.'" ></div>';

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

	  		if($icon_alignment != '') {
	  			$icon_alignment = 'text-align:'.$icon_alignment.';display: block;';
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

	  			$shape_render_start = '<div style="'.$icon_alignment.'"><div class="icon-pricing '.$shape.' '.$default_color_shape.'" style="'.$color_shape.''.$icon_spacing.'">';
	  			$shape_render_finish = '</div></div>';

	  		} else {
	  			$shape_render_start = '';
	  			$shape_render_finish = '';
	  		}

	  		$icon_content = ''.$shape_render_start.'<span style="'.$custom_icon_color.' '.$icon_size.' '.$icon_alignment.'" class="vc_icon_element-icon '.$global_icon_color.' '.$iconClass.'"></span>'.$shape_render_finish.'';
	  	}


	  	$output .= '<div class="ve-restaurant-menu '.$css_class.'">';
	  	$output .= $icon_content;
	  	$output .= $title_content;
	  	$output .= $caption_content;
	  	$output .= '<div class="ve-restaurant-menu-item-block">'.wpb_js_remove_wpautop($content).'</div>';
	  	$output .= '</div>';

	  	return $output;
	  }
	}

	class WPBakeryShortCode_ve_restaurant_menu_item extends WPBakeryShortCode {
		protected function content( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'title' => '',
				'price' => '',
				'tags' => '',
				'short_description' => '',
				'extra_information' => '',
				'icon_display' => '',
				'custom_image_icon' => '',
				'custom_svg_icon' => '',
				'icon' => '',
				'icon_color' => '',
				'custom_icon_color' => '',
				'icon_size' => '8rem',
				'icon_gap' => '0',
				'image' => '',
				'nutrition_fact_1' => '',
				'nutrition_fact_2' => '',
				'nutrition_fact_3' => '',
				'nutrition_fact_4' => '',
				'nutrition_fact_5' => '',
				'nutrition_fact_6' => '',
				'nutrition_fact_7' => '',
				'nutrition_fact_8' => '',
				'nutrition_fact_9' => '',
				'nutrition_fact_10' => '',
				'nutrition_fact_11' => '',
				'nutrition_fact_12' => '',
				'nutrition_fact_13' => '',
				'nutrition_fact_14' => '',
				'nutrition_fact_15' => '',
				'nutrition_fact_16' => '',
				'nutrition_fact_17' => '',
				'nutrition_fact_18' => '',
				'nutrition_fact_19' => '',
				'nutrition_fact_20' => '',
				'title_size' => '1.5rem',
				'title_color' => '',
				'short_description_size' => '1.3rem',
				'short_description_color' => '#818b92',
				'price_size' => '1.5rem',
				'price_color' => '',
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


	  // Cover

	  	$img = wp_get_attachment_image_src( $image, 'full' );
	  	$imgSrc = $img[0];


	  //Tags

	  	$tags = explode(", ", $tags); 
	  	$tag_content = '';
	  	foreach($tags as $tag){
		    $tag_content =  $tag_content . '<span class="btn btn-default btn-sm">'.$tag.'</span>';
		}

	  //Nutrition Fact

	  $nutrition_fact_list ='';
	  $nutrition_fact_counter = 1;

	  while( $nutrition_fact_counter <= 20 ){
	  	if(${'nutrition_fact_' . $nutrition_fact_counter} != ''){
	  		$nutrition_fact_list = $nutrition_fact_list .'<div>'.${'nutrition_fact_' . $nutrition_fact_counter}.'</div>';
	  	}
	  	$nutrition_fact_counter++;
	  }


	  $nutrition_fact_content = '<h4 class="nutrition-facts-title">Nutrition Facts</h4><div class="nutrition-facts">'.$nutrition_fact_list.'</div>';

	  // Gap

	  	$icon_gap = 'style="padding:'.$icon_gap.';"';

	  // Icon
	  	if ($icon_display == 'image_icon') {

	  		$default_src = vc_asset_url( 'vc/no_image.png' );
	  		$img = wp_get_attachment_image_src( $custom_image_icon, 'thumbnail' );
	  		$src = $img[0];
	  		$custom_src = $src ? esc_attr( $src ) : $default_src;

	  		$icon_content = '<div><img src="'.$custom_src.'" ></div>';

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

	  			$shape_render_start = '<div><div class="icon-pricing '.$shape.' '.$default_color_shape.'" style="'.$color_shape.''.$icon_spacing.'">';
	  			$shape_render_finish = '</div></div>';

	  		} else {
	  			$shape_render_start = '';
	  			$shape_render_finish = '';
	  		}

	  		$icon_content = ''.$shape_render_start.'<span style="'.$custom_icon_color.' '.$icon_size.'" class="vc_icon_element-icon '.$global_icon_color.' '.$iconClass.'"></span>'.$shape_render_finish.'';
	  	}


	  	$restaurant_item_id = strtolower(str_replace(' ', '_', $title));

	  	if($extra_information == '') {
	  	$output .= '<div class="ve-restaurant-menu-item '.$css_class.'" data-toggle="modal" data-target="#'.$restaurant_item_id.'">';
	  	} else {
	  	$output .= '<div class="ve-restaurant-menu-item '.$css_class.'">';
	  	} 
	  	if($icon_content == '') {
	  	$output .= '<div class="ve-restaurant-menu-item-preview-image col-md-2 text-center" '.$icon_gap.'>';
	  	$output .= $icon_content;
	  	$output .= '</div>';
	    }
	  	$output .= '<div class="ve-restaurant-menu-item-inner col-md-10">';
	  	$output .= '<div class="ve-restaurant-menu-item-header"><span style="font-size:'.$title_size.';color:'.$title_color.';" class="ve-restaurant-menu-item-title">'.$title.'</span><span style="font-size:'.$price_size.';color:'.$price_color.';" class="ve-restaurant-menu-item-price '.$ve_global_color.'">'.$price.'</span></div>';
	  	$output .= '<div style="font-size:'.$short_description_size.';color:'.$short_description_color.';" class="ve-restaurant-menu-item-short-description">'.$short_description.'</div>';
	  	$output .= '</div>';
	  	$output .= '</div>';

	  	if($extra_information == '') {
	  	$output .= '
	  	<div class="modal fade" id="'.$restaurant_item_id.'" tabindex="-1" role="dialog" aria-labelledby="'.$restaurant_item_id.'_label">
	  		<div class="modal-dialog" role="document">
	  			<div class="modal-content">
	  				<div class="modal-header" style="background: url('.$imgSrc.') no-repeat;background-position: center center;background-size: cover;background-attachment: scroll;">
	  					<h2 class="modal-title" id="'.$restaurant_item_id.'_label">'.$title.'</h2>
	  					<div class="modal-price">'.$price.'</div>
	  				</div>
	  				<div class="modal-body">
	  				<div class="modal-body-tags">'.$tag_content.'</div>
	  				<div class="modal-body-content">'.$content.$nutrition_fact_content.'</div>			
	  				</div>
	  				<div class="modal-footer">
	  					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  				</div>
	  			</div>
	  		</div>
	  	</div>
	  	';
	  }

	  	return $output;
	  }
	}

	vc_map( array(
		'name' => __( 'Restaurant Menu', 'js_composer' ),
		'base' => 've_restaurant_menu_block',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		"as_parent" => array('only' => 've_restaurant_menu_item'),
		"content_element" => true,
		"show_settings_on_create" => false,
		"is_container" => true,
		'category' => __( 'Visual Elements', 'js_composer' ),
		'description' => __( 'Add a amazing menu for your restaurant business', 'js_composer' ),
		'params' => array(

			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'js_composer' ),
				'param_name' => 'title',
				),
			array(
				'type' => 'textfield',
				'heading' => __( 'Caption', 'js_composer' ),
				'param_name' => 'caption',
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
				'value' => array( 'rounded','boxed','rounded-less','rounded-outline','boxed-outline','rounded-less-outline'  ),
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
			'heading' => __( 'Icon Spacing', 'js_composer' ),
			'param_name' => 'icon_spacing',
			'description' => __( 'Select icon spacing. e.g. 16px.', 'js_composer' ),
			'dependency' => array(
				'element' => 'icon_display',
				'value' => array( 'icon_manager' ),
				),
			'group' => 'Icon',
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

		array(
			'type' => 'dropdown',
			'heading' => __( 'Caption Tag', 'vslmd' ),
			'param_name' => 'caption_tag',
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
			'description' => __( 'Select caption tag.', 'vslmd' ),
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Caption Font Size', 'vslmd' ),
			'param_name' => 'caption_size',
			'description' => __( 'Enter font size.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Caption Line Height', 'vslmd' ),
			'param_name' => 'caption_line_height',
			'description' => __( 'Enter line height.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Caption Spacing', 'js_composer' ),
			'param_name' => 'caption_spacing',
			'description' => __( 'Select caption spacing. e.g. 16px.', 'js_composer' ),
			'group' => 'Typography',
			),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Caption Alignment', 'js_composer' ),
			'param_name' => 'caption_alignment',
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
			'heading' => __( 'Caption Color', 'vslmd' ),
			'param_name' => 'caption_color',
			'description' => __( 'Select custom color for the caption.', 'vslmd' ),
			'group' => 'Typography',
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

vc_map( array(
	"name" => __("Menu Item", 'js_composer'),
	'description' => __( 'Restaurant menu item', 'js_composer' ),
	"base" => "ve_restaurant_menu_item",
	'icon' => plugins_url('shortcodes-icon-sec.png', __FILE__),
	"content_element" => true,
	"as_child" => array('only' => 've_restaurant_menu_block'), 
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'js_composer' ),
			'param_name' => 'title',
			),
		array(
			'type' => 'textfield',
			'heading' => __( 'Price', 'js_composer' ),
			'param_name' => 'price',
			),
		array(
			'type' => 'textfield',
			'heading' => __( 'Tags', 'js_composer' ),
			'param_name' => 'tags',
			'description' => __( 'Add comma separated tags when writing.', 'vslmd' ),
			),
		array(
			'type' => 'textfield',
			'heading' => __( 'Short Description', 'js_composer' ),
			'param_name' => 'short_description',
			),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => __( 'Long Description', 'js_composer' ),
			'param_name' => 'content',
			'value' => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' ),
			),
		array(
			'type' => 'checkbox',
			'heading' => __('Disable Extra Information', 'js_composer'),
			'param_name' => 'extra_information',
			'value' => array(
				__( 'Dont show extra information.', 'js_composer' ) => 'disable_extra_information',
				),
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
			'group' => 'Preview Image',
			),

		array(
			'type' => 'attach_image',
			'heading' => __( 'Upload Image Icon', 'js_composer' ),
			'param_name' => 'custom_image_icon',
			'description' => __( 'Upload the custom image icon.', 'js_composer' ),
			'group' => 'Preview Image',
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
			'group' => 'Preview Image',
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
			'group' => 'Preview Image',
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
			'group' => 'Preview Image',
			),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Icon Color', 'js_composer' ),
			'param_name' => 'custom_icon_color',
			'description' => __( 'Select custom icon color.', 'js_composer' ),
			'group' => 'Preview Image',
			'dependency' => array(
				'element' => 'icon_color',
				'value' => array( 'custom' ),
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
			'group' => 'Preview Image',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Gap', 'js_composer' ),
			'param_name' => 'icon_gap',
			'description' => __( 'Enter gap. e.g. 16px.', 'js_composer' ),
			'group' => 'Preview Image',
			),

		/*
		 * Cover
		 */

		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'js_composer' ),
			'param_name' => 'image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'js_composer' ),
			'group' => 'Cover',
			),

		/*
		 * Nutrition Facts
		 */

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 1', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_1',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 2', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_2',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 3', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_3',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 4', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_4',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 5', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_5',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 6', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_6',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 7', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_7',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 8', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_8',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 9', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_9',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 10', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_10',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 11', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_11',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 12', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_12',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 13', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_13',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 14', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_14',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 15', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_15',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 16', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_16',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 17', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_17',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 18', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_18',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 19', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_19',
			'group' => 'Nutrition Facts',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Nutrition Fact 20', 'js_composer' ),
			'description' => __( 'Enter nutrition fact.', 'js_composer' ),
			'param_name' => 'nutrition_fact_20',
			'group' => 'Nutrition Facts',
			),

		/*
		 * Typography Tab
		 */

		array(
			'type' => 'textfield',
			'heading' => __( 'Title Font Size', 'vslmd' ),
			'param_name' => 'title_size',
			'description' => __( 'Enter font size.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Title Color', 'vslmd' ),
			'param_name' => 'title_color',
			'description' => __( 'Select custom color for the title.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Short Description Font Size', 'vslmd' ),
			'param_name' => 'short_description_size',
			'description' => __( 'Enter font size.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Short Description Color', 'vslmd' ),
			'param_name' => 'short_description_color',
			'description' => __( 'Select custom color for the description.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'textfield',
			'heading' => __( 'Price Font Size', 'vslmd' ),
			'param_name' => 'price_size',
			'description' => __( 'Enter font size.', 'vslmd' ),
			'group' => 'Typography',
			),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Price Color', 'vslmd' ),
			'param_name' => 'price_color',
			'description' => __( 'Select custom color for the price.', 'vslmd' ),
			'group' => 'Typography',
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