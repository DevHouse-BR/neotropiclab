<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Knowledgebase
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_knowledgebase extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'knowledgebase_columns_count' => '', 
			'knowledgebase_sortable_mode' => 'yes', 
			'knowledgebase_sortable_icons' => 'yes',
			'knowledgebase_sortable_name' => 'Knowledgebases', 
			'knowledgebase_post_number' => 'all', 
			'knowledgebase_categories' => '', 
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
	  	if($knowledgebase_categories == 'knowledgebase')
	  		$knowledgebase_categories = '';

	  // Post teasers count
	  	if ( $knowledgebase_post_number != '' && !is_numeric($knowledgebase_post_number) ) $knowledgebase_post_number = -1;
	  	if ( $knowledgebase_post_number != '' && is_numeric($knowledgebase_post_number) ) $knowledgebase_post_number = $knowledgebase_post_number;

	  // Add Custom Class For Knowledgebase

	  	if ( $knowledgebase_columns_count=="2clm") { $knowledgebase_columns_count = 'col-md-6'; }
	  	if ( $knowledgebase_columns_count=="3clm") { $knowledgebase_columns_count = 'col-md-4'; }
	  	if ( $knowledgebase_columns_count=="4clm") { $knowledgebase_columns_count = 'col-md-3'; }
	  	if ( $knowledgebase_columns_count=="5clm") { $knowledgebase_columns_count = 'col-md-3'; }
	  	if ( $knowledgebase_columns_count=="6clm") { $knowledgebase_columns_count = 'col-md-3'; }

	  	$args = array( 
	  		'posts_per_page' => $knowledgebase_post_number, 
	  		'post_type' => 'knowledgebase',
	  		'knowledgebase-category' => $knowledgebase_categories,
	  		'orderby' => $orderby,
	  		'order' => $order
	  		);

	  // Run query
	  	$my_query = new WP_Query($args);

	  	$output .= '<div class="'. $css_class .'">';

	  	if($knowledgebase_sortable_mode == "yes") {

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
	  				<a href="javascript:void(0)" class="navbar-brand active" data-filter=".all" title="'.$knowledgebase_sortable_name.'" rel="home">'.$knowledgebase_sortable_name.'</a>

	  			</div>
	  			<div id="portfolio-filter" class="portfolio-items-icon desktop-filter">
	  				<div class="portfolio-nav collapse navbar-collapse navbar-portfolio-collapse">
	  					<ul class="nav navbar-nav option-set" data-option-key="filter">';
	  						if($knowledgebase_sortable_icons == "yes") {
	  							$output .= '<li class="category"><a class="selected drop-selected" href="#filter" data-option-value="*"><i class="fa fa-th"></i>'. $knowledgebase_sortable_name . '</a></li> ';
	  							$list_categories = get_categories("taxonomy=knowledgebase-category");
	  							foreach ($list_categories as $list_category) :
	  								if(empty($knowledgebase_categories)){
	  									$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  									$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '"><i class="' . $term_meta['category_icon'] .'"></i>' . $list_category->name . '</a></li> ';
	  								}
	  								else{
	  									if(strstr($knowledgebase_categories, $list_category->slug)){	
	  										$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  										$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '"><i class="' . $term_meta['category_icon'] .'"></i>' . $list_category->name . '</a></li> ';
	  									}
	  								}
	  								endforeach;
	  							} else if($knowledgebase_sortable_icons == "no") {
	  								$output .= '<li class="category"><a class="selected drop-selected" href="#filter" data-option-value="*">'. $knowledgebase_sortable_name . '</a></li> ';
	  								$list_categories = get_categories("taxonomy=knowledgebase-category");
	  								foreach ($list_categories as $list_category) :
	  									if(empty($knowledgebase_categories)){
	  										$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  										$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '">' . $list_category->name . '</a></li> ';
	  									}
	  									else{
	  										if(strstr($knowledgebase_categories, $list_category->slug)){	
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
	  			if ($knowledgebase_sortable_mode == "no") {
	  				$sortable_class = ' no-sortable';
	  			}

	  			$output .= '<div class="row '. $el_class .'">';
	  			$output .= '<div id="portfolio-projects" class="'.$sortable_class.'">';
	  			$output .= '<ul id="knowledgebase">';



	  			while($my_query->have_posts()) : $my_query->the_post();

	  			$terms = get_the_terms($post->ID,"knowledgebase-category");
	  			$list_categories = NULL;

	  			if ( !empty($terms) ){
	  				foreach ( $terms as $term ) {
	  					$list_categories .= strtolower($term->slug) . ' ';
	  				}
	  			}

	  			$attrs = get_the_terms( $post->ID, 'knowledgebase-tag' );
	  			$attributes_fields = NULL;

	  			if ( !empty($attrs) ){
	  				foreach ( $attrs as $attr ) {
	  					$attributes_fields[] = $attr->name;
	  				}

	  				$on_attributes = join( " / ", $attributes_fields );
	  			}

	  			$post_id = $my_query->post->ID;

	  			if(redux_post_meta( "vslmd_options", $post->ID, "meta-box-header-custom-icon" ) == '') {
	  				$cover_icon = redux_post_meta( "vslmd_options", $post->ID, "meta-box-icon-menu" );
	  			} 
	  			else {
	  				$cover_icon = redux_post_meta( "vslmd_options", $post->ID, "meta-box-header-custom-icon" );
	  			}
	  			$fancy_gallery = get_post_meta($post->ID, '_vslmd_fancy_gallery', true);

	  			$kb_description = redux_post_meta( "vslmd_options", $post->ID, "meta-box-kb-description" );

	  			$cover_icon = '<i class="kb-icon '. $cover_icon .' '.$ve_global_color.'"></i>';


	  			$output .= '<li class="item-project '.$knowledgebase_columns_count. ' ' . $list_categories .'">
	  			<div class="item-container knowledgebase-item-container">';

	  				$output .= '<div class="knowledgebase-content-wrap">';

	  				$output .= '<div class="knowledgebase-name">
	  				<div class="va">';

	  					$output .= '<a class="project-title" href="'. get_permalink($post_id) .'" title="'. get_the_title() .'">';
	  					if(!empty($cover_icon)){$output .= $cover_icon;}
	  					$output .= '<h4>'. get_the_title() .'</h4>';
	  					if(!empty($kb_description)){$output .= '<p class="kb-description">'. $kb_description .'</p>';}
	  					if(!empty($on_attributes)){$output .= '<span>'. $on_attributes .'</span>';}
	  					$output .= '</a>

	  				</div>
	  			</div>
	  		</div>';





	  		$output .= '</div>
	  	</li>';

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
		'name' => __( 'Knowledgebase', 'vslmd' ),
		'base' => 've_knowledgebase',
		'icon' => plugins_url('shortcodes-icon.png', __FILE__),
		'is_container' => false,
		'show_settings_on_create' => true,
		'category' => __( 'Visual Elements', 'vslmd' ),
		'description' => __( 'Add a knowledgebase', 'vslmd' ),
		'params' => array(

			array(
				'type' => 'dropdown',
				'heading' => __('Columns', 'vslmd'),
				'param_name' => 'knowledgebase_columns_count',
				'value' => array(
					__('2 Columns', 'vslmd') => '2clm', 
					__('3 Columns', 'vslmd') => '3clm', 
					__('4 Columns', 'vslmd') => '4clm', 
					__('5 Columns (Only Wall Effect Enabled)', 'vslmd') => '5clm', 
					__('6 Columns (Only Wall Effect Enabled)', 'vslmd') => '6clm'),
				'admin_label' => false,
				'description' => __('How many columns should be displayed?', 'vslmd')
				),

			array(
				'type' => 'dropdown',
				'heading' => __('Sortable', 'vslmd'),
				'param_name' => 'knowledgebase_sortable_mode',
				'value' => array(
					__('Yes', 'vslmd') => 'yes', 
					__('No', 'vslmd') => 'no',
					),
				'admin_label' => false,
				'description' => __('Should the sorting options based on categories be displayed? Disable if you want display a custom knowledgebase categories.', 'vslmd')
				),

			array(
				'type' => 'dropdown',
				'heading' => __('Icons On Sortable', 'vslmd'),
				'param_name' => 'knowledgebase_sortable_icons',
				'value' => array(
					__('Yes', 'vslmd') => 'yes',
					__('No', 'vslmd') => 'no'
					),
				'admin_label' => false,
				'description' => __('Enable or Disable Icons on Sortable', 'vslmd'),
				'dependency' => array(
					'element' => 'knowledgebase_sortable_mode', 
					'value' => array('yes'),
					),
				),	

			array(
				'type' => 'textfield',
				'heading' => __('Knowledgebase Sortable Name', 'vslmd'),
				'param_name' => 'knowledgebase_sortable_name',
				'value' => 'Knowledgebases',
				'admin_label' => false,
				'description' => __('Enter sortable name. Default value is All Knowledgebase', 'vslmd'),
				'dependency' => array('element' => 'knowledgebase_sortable_mode', 'value' => array('yes'))
				),

			array(
				'type' => 'textfield',
				'heading' => __('Post Number', 'vslmd'),
				'param_name' => 'knowledgebase_post_number',
				'admin_label' => false,
				'description' => __('How many post to show? Enter number or word "All". Default value is All.', 'vslmd')
				),

			array(
				'type' => 'textfield',
				'heading' => __('Knowledgebase Categories', 'vslmd'),
				'param_name' => 'knowledgebase_categories',
				'admin_label' => false,
				'description' => __('If you want to show only certain knowledgebase categories, not the entire knowledgebase, please write the categories in this field, separated by commas. Please use the <strong>category slug</strong>, not the title.', 'vslmd')
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
					__('Menu order', 'vslmd') => 'menu_order' ),
				'admin_label' => false,
				'description' => sprintf(__('Select how to sort retrieved posts. More at %s.', 'vslmd'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
				),

			array(
				'type' => 'dropdown',
				'heading' => __('Order way', 'vslmd'),
				'param_name' => 'order',
				'value' => array( 
					__('Descending', 'vslmd') => 'DESC', 
					__('Ascending', 'vslmd') => 'ASC' ),
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