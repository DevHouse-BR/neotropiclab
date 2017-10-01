<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Portfolio
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_portfolio extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'portfolio_layout' => '', 
			'portfolio_item_no_space' => '', 
			'link_portfolio_item' => '', 
			'portfolio_columns_count' => '2clm', 
			'portfolio_post_number' => 'all', 
			'portfolio_post_link' => '', 
			'portfolio_sortable_name' => 'All Projects', 
			'portfolio_sortable_mode' => 'yes', 
			'portfolio_image_effect' => 'effect-none', 
			'portfolio_sortable_icons' => 'yes',
			'portfolio_categories' => '', 
			'orderby' => NULL, 
			'order' => 'DESC', 
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
	  	
	  	global $post;
	  	
	  // Narrow by categories
	  	if($portfolio_categories == 'portfolio')
	  		$portfolio_categories = '';
	  	
	  // Post teasers count
	  	if ( $portfolio_post_number != '' && !is_numeric($portfolio_post_number) ) $portfolio_post_number = -1;
	  	if ( $portfolio_post_number != '' && is_numeric($portfolio_post_number) ) $portfolio_post_number = $portfolio_post_number;
	  	
	  // Add Custom Class For Portfolio

	  	$portfolio_full = null;
	  	if ($portfolio_item_no_space==true) {
	  		$portfolio_full = ' portfolio-full-width';

	  		if ( $portfolio_columns_count=="2clm") { $portfolio_columns_count = 'col-md-6'; }
	  		if ( $portfolio_columns_count=="3clm") { $portfolio_columns_count = 'col-md-4'; }
	  		if ( $portfolio_columns_count=="4clm") { $portfolio_columns_count = 'col-md-3'; }
	  		if ( $portfolio_columns_count=="6clm") { $portfolio_columns_count = 'col-md-2'; }
	  	} else {
	  		if ( $portfolio_columns_count=="2clm") { $portfolio_columns_count = 'col-md-6'; }
	  		if ( $portfolio_columns_count=="3clm") { $portfolio_columns_count = 'col-md-4'; }
	  		if ( $portfolio_columns_count=="4clm") { $portfolio_columns_count = 'col-md-3'; }
	  		if ( $portfolio_columns_count=="6clm") { $portfolio_columns_count = 'col-md-2'; }
	  	}

	  	$args = array( 
	  		'posts_per_page' => $portfolio_post_number, 
	  		'post_type' => 'portfolio',
	  		'portfolio-category' => $portfolio_categories,
	  		'orderby' => $orderby,
	  		'order' => $order
	  		);

	  // Run query
	  	$my_query = new WP_Query($args);
	  	
	  	$output .= '<div class="'. $css_class .'">';
	  	
	  	if($portfolio_sortable_mode == "yes") {

		// Sortable

	  		$output .= '<div class="navbar navbar-inverse nav-portfolio">

	  		<div class="container-fluid">

	  			<div class="navbar-header">

	  				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" aria-expanded="false" data-target=".navbar-portfolio-collapse">
	  					<span class="sr-only">Toggle navigation</span>
	  					<span class="icon-bar"></span>
	  					<span class="icon-bar"></span>
	  					<span class="icon-bar"></span>
	  				</button>

	  				<!-- Your site title as branding in the menu -->
	  				<a href="javascript:void(0)" class="navbar-brand active" data-filter=".all" title="'.$portfolio_sortable_name.'" rel="home">'.$portfolio_sortable_name.'</a>

	  			</div>
	  			<div id="portfolio-filter" class="portfolio-items-icon'.$portfolio_full.' desktop-filter">
	  				<div class="portfolio-nav collapse navbar-collapse navbar-portfolio-collapse">
	  					<ul class="nav navbar-nav option-set" data-option-key="filter">';
	  						if($portfolio_sortable_icons == "yes") {
	  							$output .= '<li class="category"><a class="selected drop-selected" href="#filter" data-option-value="*"><i class="fa fa-th"></i>'. $portfolio_sortable_name . '</a></li> ';
	  							$list_categories = get_categories("taxonomy=portfolio-category");
	  							foreach ($list_categories as $list_category) :
	  								if(empty($portfolio_categories)){
	  									$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  									$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '"><i class="' . $term_meta['category_icon'] .'"></i>' . $list_category->name . '</a></li> ';
	  								}
	  								else{
	  									if(strstr($portfolio_categories, $list_category->slug)){	
	  										$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  										$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '"><i class="' . $term_meta['category_icon'] .'"></i>' . $list_category->name . '</a></li> ';
	  									}
	  								}
	  								endforeach;
	  							} else if($portfolio_sortable_icons == "no") {
	  								$output .= '<li class="category"><a class="selected drop-selected" href="#filter" data-option-value="*">'. $portfolio_sortable_name . '</a></li> ';
	  								$list_categories = get_categories("taxonomy=portfolio-category");
	  								foreach ($list_categories as $list_category) :
	  									if(empty($portfolio_categories)){
	  										$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  										$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '">' . $list_category->name . '</a></li> ';
	  									}
	  									else{
	  										if(strstr($portfolio_categories, $list_category->slug)){	
	  											$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  											$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '">' . $list_category->name . '</a></li> ';
	  										}
	  									}
	  									endforeach;	
	  								}
	  								$output .= '			</ul>	
	  							</div>
	  						</div>

	  					</div> 

	  				</div>';		

	  // Sortable end

	  			}

	  			$sortable_class = '';
	  			if ($portfolio_sortable_mode == "no") {
	  				$sortable_class = ' no-sortable';
	  			}

	  			$output .= '<div class="row '.$portfolio_full.'">';
	  			$output .= '<div id="portfolio-projects" class="'.$sortable_class.' '.$portfolio_layout .'">';
	  			$output .= '<ul id="projects">';



	  			while($my_query->have_posts()) : $my_query->the_post();

	  			$terms = get_the_terms($post->id,"portfolio-category");
	  			$list_categories = NULL;

	  			if ( !empty($terms) ){
	  				foreach ( $terms as $term ) {
	  					$list_categories .= strtolower($term->slug) . ' ';
	  				}
	  			}

	  			$attrs = get_the_terms( $post->ID, 'portfolio-tag' );
	  			$attributes_fields = NULL;

	  			if ( !empty($attrs) ){
	  				foreach ( $attrs as $attr ) {
	  					$attributes_fields[] = $attr->name;
	  				}

	  				$on_attributes = join( " - ", $attributes_fields );
	  			}

	  			$post_id = $my_query->post->ID;

	  			$img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
	  			$img_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-thumb' );
	  			$img_wall_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'portfolio-wall-thumb' );

	  			$fancy_video = get_post_meta($post->ID, '_vslmd_fancy_video', true);
	  			$fancy_gallery = get_post_meta($post->ID, '_vslmd_fancy_gallery', true);
	  			$fancy_image_popup = get_post_meta($post->ID, '_vslmd_fancy_image_full', true);
	  			$fancy_image_gallery = get_post_meta($post->ID, '_vslmd_fancy_image_gallery', true);

	  			$images = explode(',', $fancy_image_gallery);

	  			$customFancyImg = (!empty($fancy_image_popup)) ? $fancy_image_popup : $img_url[0];

	  			if($portfolio_post_link == "link_fancybox") {
	  				$access_mode = $customFancyImg;
	  				$access_mode_class = 'portfolio-zoom-cursor';
	  			} else {
	  				$access_mode = get_permalink($post_id);
	  				$access_mode_class = '';
	  			}

	  			if(!empty($fancy_gallery)) { $fancy_gallery = 'data-fancybox-group="'. strtolower($fancy_gallery) .'"'; }

	  			$output .= '<li class="item-project '.$portfolio_columns_count. ' ' . $list_categories .'">';
		  			$output .= '<figure class="item-container hover-wrap '. $portfolio_image_effect .'">';

				  			if ($portfolio_layout == "masonry-portfolio") {
				  				$output .= '<img src="'. $img_url[0] .'" width="'.$img_url[1].'" height="'.$img_url[2].'" alt="'. get_the_title() .'" class="img-responsive" />';
				  			} else {
				  				if ($portfolio_item_no_space==true) {
				  					$output .= '<img src="'. $img_wall_thumb[0] .'" width="'.$img_wall_thumb[1].'" height="'.$img_wall_thumb[2].'" alt="'. get_the_title() .'" class="img-responsive" />';
				  				} else {
				  					$output .= '<img src="'. $img_thumb[0] .'" width="'.$img_thumb[1].'" height="'.$img_thumb[2].'" alt="'. get_the_title() .'" class="img-responsive" />';
				  				}
				  			}

				  			$output .= '<figcaption class="project-name"><a class="fancybox portfolio-style-access '.$access_mode_class.'" href="'. $access_mode .'" title="'. get_the_title() .'" '. $fancy_gallery .'><div class="va">';	
				  			$output .= '<a class="project-title" href="'. get_permalink($post_id) .'" title="'. get_the_title() .'">';
				  			$output .= '<h3>'. get_the_title() .'</h3>';
				  			if(!empty($on_attributes)){$output .= '<span>'. $on_attributes .'</span>';}
				  			$output .= '</a>';
				  			$output .= '</div></a></figcaption>';

			  		$output .= '</figure>';
		  		$output .= '</li>';

	  		endwhile;

	  		wp_reset_query();


	  		$output .= '</ul>';
	  		$output .= '</div>';
	  		$output .= '</div>';
	  		$output .= '</div>';


	  		return $output;
	  	}
	  }

	  return array(
	  	'name' => __( 'Portfolio', 'vslmd' ),
	  	'base' => 've_portfolio',
	  	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	  	'is_container' => false,
	  	'show_settings_on_create' => true,
	  	'category' => __( 'Visual Elements', 'vslmd' ),
	  	'description' => __( 'Add a creative portfolio', 'vslmd' ),
	  	'params' => array(

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Layout Mode', 'vslmd'),
	  			'param_name' => 'portfolio_layout',
	  			'value' => array(
	  				__('Grid', 'vslmd') => 'grid-portfolio', 
	  				__('Masonry', 'vslmd') => 'masonry-portfolio',
	  				),
	  			'admin_label' => false,
	  			'description' => __('Select Portfolio Layout Mode', 'vslmd')
	  			),

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Columns', 'vslmd'),
	  			'param_name' => 'portfolio_columns_count',
	  			'value' => array(
	  				__('2 Columns', 'vslmd') => '2clm', 
	  				__('3 Columns', 'vslmd') => '3clm', 
	  				__('4 Columns', 'vslmd') => '4clm', 
	  				__('6 Columns', 'vslmd') => '6clm',
	  				),
	  			'admin_label' => false,
	  			'description' => __('How many columns should be displayed?', 'vslmd')
	  			),

	  		array(
	  			'type' => 'checkbox',
	  			'heading' => __('Remove Space of the Portfolio Items?', 'vslmd'),
	  			'param_name' => 'portfolio_item_no_space',
	  			'value' => array(
	  				__('Select it', 'vslmd') => 'yes',
	  				),
	  			'description' => __('Enable or Disable the space between thSe single portfolio items.', 'vslmd')
	  			),

	  		array(
	  			'type' => 'checkbox',
	  			'heading' => __('Remove Link to Single Portfolio Item?', 'vslmd'),
	  			'param_name' => 'link_portfolio_item',
	  			'value' => array(
	  				__('Select it', 'vslmd') => 'yes',
	  				),
	  			'description' => __('Enable or Disable the link for the single portfolio item page.', 'vslmd')
	  			),

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Access Mode', 'vslmd'),
	  			'param_name' => 'portfolio_post_link',
	  			'value' => array(
	  				__('Link to Portfolio Post', 'vslmd') => 'link_post', 
	  				__('Zoom to Portfolio Image', 'vslmd') => 'link_fancybox',
	  				),
	  			'admin_label' => false,
	  			'description' => __('When clicking on an item:', 'vslmd')
	  			),

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Sortable', 'vslmd'),
	  			'param_name' => 'portfolio_sortable_mode',
	  			'value' => array(
	  				__('Yes', 'vslmd') => 'yes', 
	  				__('No', 'vslmd') => 'no',
	  				),
	  			'admin_label' => false,
	  			'description' => __('Should the sorting options based on categories be displayed? Disable if you want display a custom portfolio categories.', 'vslmd')
	  			),

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Icons On Sortable', 'vslmd'),
	  			'param_name' => 'portfolio_sortable_icons',
	  			'value' => array(
	  				__('Yes', 'vslmd') => 'yes',
	  				__('No', 'vslmd') => 'no'
	  				),
	  			'admin_label' => false,
	  			'description' => __('Enable or Disable Icons on Sortable', 'vslmd'),
	  			'dependency' => array(
	  				'element' => 'portfolio_sortable_mode', 
	  				'value' => array('yes'),
	  				),
	  			),	

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Image Effect', 'vslmd'),
	  			'param_name' => 'portfolio_image_effect',
	  			'value' => array(
	  				__('None', 'vslmd') => 'effect-none', 
	  				__('To Right', 'vslmd') => 'effect-right',  
	  				__('Zoom', 'vslmd') => 'effect-zoom', 
	  				__('Zoom Out', 'vslmd') => 'effect-zoom-out',  
	  				__('Zoom Out Right', 'vslmd') => 'effect-zoom-out-right',  
	  				__('Hyper Zoom', 'vslmd') => 'effect-hyper-zoom',
	  				),
	  			'admin_label' => false,
	  			'description' => __('Select an effect animation.', 'vslmd')
	  			),

	  		array(
	  			'type' => 'textfield',
	  			'heading' => __('Portfolio Sortable Name', 'vslmd'),
	  			'param_name' => 'portfolio_sortable_name',
	  			'value' => 'All Projects',
	  			'admin_label' => false,
	  			'description' => __('Enter sortable name. Default value is All Projects', 'vslmd'),
	  			'dependency' => array(
	  				'element' => 'portfolio_sortable_mode', 
	  				'value' => array('yes'),
	  				)
	  			),

	  		array(
	  			'type' => 'textfield',
	  			'heading' => __('Post Number', 'vslmd'),
	  			'param_name' => 'portfolio_post_number',
	  			'admin_label' => false,
	  			'description' => __('How many post to show? Enter number or word "All". Default value is All.', 'vslmd')
	  			),

	  		array(
	  			'type' => 'textfield',
	  			'heading' => __('Portfolio Categories', 'vslmd'),
	  			'param_name' => 'portfolio_categories',
	  			'admin_label' => false,
	  			'description' => __('If you want to show only certain portfolio categories, not the entire portfolio, please write the categories in this field, separated by commas. Please use the <strong>category slug</strong>, not the title.', 'vslmd')
	  			),

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Order by', 'vslmd'),
	  			'param_name' => 'orderby',
	  			'value' => array( 
	  				'', 
	  				__('Date', 'vslmd') => 'date', 
	  				__('ID', 'vslmd') => 'ID', 
	  				__('Author', 'vslmd') => 'author', 
	  				__('Title', 'vslmd') => 'title', 
	  				__('Modified', 'vslmd') => 'modified', 
	  				__('Random', 'vslmd') => 'rand', 
	  				__('Comment count', 'vslmd') => 'comment_count', 
	  				__('Menu order', 'vslmd') => 'menu_order',
	  				),
	  			'admin_label' => false,
	  			'description' => sprintf(__('Select how to sort retrieved posts. More at %s.', 'vslmd'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
	  			),

	  		array(
	  			'type' => 'dropdown',
	  			'heading' => __('Order way', 'vslmd'),
	  			'param_name' => 'order',
	  			'value' => array( 
	  				__('Descending', 'vslmd') => 'DESC', 
	  				__('Ascending', 'vslmd') => 'ASC',
	  				),
	  			'admin_label' => false,
	  			'description' => sprintf(__('Designates the ascending or descending order. More at %s.', 'vslmd'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
	  			),

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
	  		)
);
