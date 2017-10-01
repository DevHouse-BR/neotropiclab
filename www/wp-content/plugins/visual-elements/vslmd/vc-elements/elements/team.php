<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Team
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_team extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'animation_loading' => '', 
			'animation_loading_effects' => '',
			'team_columns_count' => '2clm', 
			'team_post_number' => 'all', 
			'team_categories' => '', 
			'team_sortable_mode' => 'no', 
			'team_sortable_name' => 'All Team', 
			'team_sortable_icons' => 'yes',
			'orderby' => NULL, 
			'order' => 'DESC', 
			'background' => '',
			'structure' => 'content-block',
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

	  // Background
	  	if($background != '') {
	  		$background = 'style="background-color:'.$background.';"';
	  	} else {
	  		$background = '';
	  	}

	  // Post teasers count
	  	if ( $team_post_number != '' && !is_numeric($team_post_number) ) $team_post_number = -1;
	  	if ( $team_post_number != '' && is_numeric($team_post_number) ) $team_post_number = $team_post_number;

	  	if ( $team_columns_count=="2clm") { $team_columns_count = 'col-md-6'; }
	  	if ( $team_columns_count=="3clm") { $team_columns_count = 'col-md-4'; }
	  	if ( $team_columns_count=="4clm") { $team_columns_count = 'col-md-3'; }

	  	$args = array( 
	  		'posts_per_page' => $team_post_number, 
	  		'post_type' => 'team',
	  		'team-category' => $team_categories,
	  		'orderby' => $orderby,
	  		'order' => $order
	  		);

	  // Run query
	  	$my_query = new WP_Query($args);

	  	$output .= '<div class="'. $css_class .'">';

	  	if($team_sortable_mode == "yes") {

		// Sortable

	  		$output .= '<div class="navbar navbar-inverse nav-team">

	  		<div class="container-fluid">

	  			<div class="navbar-header">

	  				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" aria-expanded="false" data-target=".navbar-team-collapse">
	  					<span class="sr-only">Toggle navigation</span>
	  					<span class="icon-bar"></span>
	  					<span class="icon-bar"></span>
	  					<span class="icon-bar"></span>
	  				</button>

	  				<!-- Your site title as branding in the menu -->
	  				<a href="javascript:void(0)" class="navbar-brand active" data-filter=".all" title="'.$team_sortable_name.'" rel="home">'.$team_sortable_name.'</a>

	  			</div>
	  			<div id="team-filter" class="team-items-icon desktop-filter">
	  				<div class="team-nav collapse navbar-collapse navbar-team-collapse">
	  					<ul class="nav navbar-nav option-set" data-option-key="filter">';
	  						if($team_sortable_icons == "yes") {
	  							$output .= '<li class="category"><a class="selected drop-selected" href="#filter" data-option-value="*"><i class="fa fa-th"></i>'. $team_sortable_name . '</a></li> ';
	  							$list_categories = get_categories("taxonomy=team-category");
	  							foreach ($list_categories as $list_category) :
	  								if(empty($team_categories)){
	  									$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  									$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '"><i class="' . $term_meta['category_icon'] .'"></i>' . $list_category->name . '</a></li> ';
	  								}
	  								else{
	  									if(strstr($team_categories, $list_category->slug)){	
	  										$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  										$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '"><i class="' . $term_meta['category_icon'] .'"></i>' . $list_category->name . '</a></li> ';
	  									}
	  								}
	  								endforeach;
	  							} else if($team_sortable_icons == "no") {
	  								$output .= '<li class="category"><a class="selected drop-selected" href="#filter" data-option-value="*">'. $team_sortable_name . '</a></li> ';
	  								$list_categories = get_categories("taxonomy=team-category");
	  								foreach ($list_categories as $list_category) :
	  									if(empty($team_categories)){
	  										$term_meta = get_option( 'taxonomy_'.$list_category->cat_ID );
	  										$output .= '<li class="category"><a href="#filter" data-option-value=".' . strtolower(str_replace(" ","-", ($list_category->slug))) . '">' . $list_category->name . '</a></li> ';
	  									}
	  									else{
	  										if(strstr($team_categories, $list_category->slug)){	
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
	  			if ($team_sortable_mode == "no") {
	  				$sortable_class = ' no-sortable';
	  			}

	  			$output .= '<div class="row">';
	  			$output .= '<div id="team-people" class="'. $sortable_class .'">';
	  			$output .= '<ul id="people">';



	  			while($my_query->have_posts()) : $my_query->the_post();

	  //Career
	  			$meta_box_team_career = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-career" );

	  //Email & Social Networks
	  			$meta_box_team_email = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-email" );
	  			$meta_box_team_facebook = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-facebook" );
	  			$meta_box_team_github = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-github" );
	  			$meta_box_team_google_plus = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-google-plus" );
	  			$meta_box_team_instagram = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-instagram" );
	  			$meta_box_team_linkedin = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-linkedin" );
	  			$meta_box_team_twitter = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-twitter" );
	  			$meta_box_team_vimeo = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-vimeo" );
	  			$meta_box_team_youtube = redux_post_meta( "vslmd_options", $post->ID, "meta-box-team-youtube" );

	  			$terms = get_the_terms($post->id,"team-category");
	  			$team_category = NULL;

	  			if ( !empty($terms) ){
	  				foreach ( $terms as $term ) {
	  					$team_category .= strtolower($term->slug) . ' ';
	  				}
	  			}


	  			$attrs = get_the_terms( $post->ID, 'team-tag' );
	  			$team_tag = NULL;

	  			if ( !empty($attrs) ){
	  				foreach ( $attrs as $attr ) {

	  					$team_tag[] = $attr->name;
	  				}

	  				$on_team_tags = join( " / ", $team_tag );
	  			}

	  			$post_id = $my_query->post->ID;

	  			$img_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'team-thumb' );

	  			$animation_loading_class = null;
	  			if ($animation_loading == "yes") {
	  				$animation_loading_class = 'animated-content';
	  			}

	  			$animation_effect_class = null;
	  			if ($animation_loading == "yes") {
	  				$animation_effect_class = $animation_loading_effects;
	  			}

	  			$output .= '<li class="single-people '.$team_columns_count. ' ' . $team_category .'">
	  			<figure class="item-container '. $animation_loading_class .' '. $animation_effect_class .' '.$structure.'">';

	  				$output .= '<div class="hover-wrap">
	  				<img src="'. $img_thumb[0] .'" width="'.$img_thumb[1].'" height="'.$img_thumb[2].'" alt="'. get_the_title() .'" class="img-responsive" />';
	  				$output .= '<figcaption class="team-caption" '.$background.'>
	  				<a class="team-title" href="'. get_permalink($post_id) .'" title="'. get_the_title() .'"><h3>'. get_the_title() .'</h3></a>';
	  				if(!empty($meta_box_team_career)){$output .= '<p class="team-occupation">'. $meta_box_team_career .'</p>';}
	  				if(!empty($on_team_tags)){$output .= '<p class="team-skills">'. $on_team_tags .'</p>';}


	  				$output .= '<div class="team-contact">';

	  				if($meta_box_team_email != '') {
	  					$output .= '<span><a href="'. $meta_box_team_email .'"><i class="fa fa-envelope"></i></a></span>';
	  				}
	  				if($meta_box_team_facebook != '') {
	  					$output .= '<span><a href="'. $meta_box_team_facebook .'"><i class="fa fa-facebook"></i></a></span>';
	  				}
	  				if($meta_box_team_github != '') {
	  					$output .= '<span><a href="'. $meta_box_team_github .'"><i class="fa fa-github-alt"></i></a></span>';
	  				}
	  				if($meta_box_team_google_plus != '') {
	  					$output .= '<span><a href="'. $meta_box_team_google_plus .'"><i class="fa fa-google-plus"></i></a></span>';
	  				}
	  				if($meta_box_team_instagram != '') {
	  					$output .= '<span><a href="'. $meta_box_team_instagram .'"><i class="fa fa-instagram"></i></a></span>';
	  				}
	  				if($meta_box_team_linkedin != '') {
	  					$output .= '<span><a href="'. $meta_box_team_linkedin .'"><i class="fa fa-linkedin"></i></a></span>';
	  				}
	  				if($meta_box_team_twitter != '') {
	  					$output .= '<span><a href="'. $meta_box_team_twitter .'"><i class="fa fa-twitter"></i></a></span>';
	  				}
	  				if($meta_box_team_vimeo != '') {
	  					$output .= '<span><a href="'. $meta_box_team_vimeo .'"><i class="fa fa-vimeo"></i></a></span>';
	  				}
	  				if($meta_box_team_youtube != '') {
	  					$output .= '<span><a href="'. $meta_box_team_youtube .'"><i class="fa fa-youtube-play"></i></a></span>';
	  				}

	  				$output .= '
	  			</div>

	  		</figcaption>
	  	</div>';

	  	$output .= '</figure>
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
	'name' => __( 'Team', 'vslmd' ),
	'base' => 've_team',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	'is_container' => false,
	'show_settings_on_create' => true,
	'category' => __( 'Visual Elements', 'vslmd' ),
	'description' => __( 'Show your team members', 'vslmd' ),
	'params' => array(
		
		array(
			'type' => 'dropdown',
			'heading' => __('Columns', 'vslmd'),
			'param_name' => 'team_columns_count',
			'value' => array(
				__('2 Columns', 'vslmd') => '2clm', 
				__('3 Columns', 'vslmd') => '3clm', 
				__('4 Columns', 'vslmd') => '4clm'),
			'admin_label' => false,
			'description' => __('How many columns should be displayed?', 'vslmd')
			),

		array(
			'type' => 'dropdown',
			'heading' => __('Sortable', 'vslmd'),
			'param_name' => 'team_sortable_mode',
			'value' => array(
				__('No', 'vslmd') => 'no',
				__('Yes', 'vslmd') => 'yes'
				),		  		
			'admin_label' => false,
			'description' => __('Should the sorting options based on categories be displayed? Disable if you want display a custom team categories.', 'vslmd')
			),
		
		array(
			'type' => 'dropdown',
			'heading' => __('Icons On Sortable', 'vslmd'),
			'param_name' => 'team_sortable_icons',
			'value' => array(
				__('Yes', 'vslmd') => 'yes',
				__('No', 'vslmd') => 'no'
				),
			'admin_label' => false,
			'description' => __('Enable or Disable Icons on Sortable', 'vslmd'),
			'dependency' => array(
				'element' => 'team_sortable_mode', 
				'value' => array('yes'),
				),
			),	

		array(
			'type' => 'textfield',
			'heading' => __('Team Sortable Name', 'vslmd'),
			'param_name' => 'team_sortable_name',
			'value' => 'All Team',
			'admin_label' => false,
			'description' => __('Enter sortable name. Default value is All Team', 'vslmd'),
			'dependency' => array('element' => 'team_sortable_mode', 'value' => array('yes'))
			),

		array(
			'type' => 'textfield',
			'heading' => __('Team Number', 'vslmd'),
			'param_name' => 'team_post_number',
			'admin_label' => false,
			'description' => __('How many post to show? Enter number or word "All". Default value is All.', 'vslmd')
			),

		array(
			'type' => 'textfield',
			'heading' => __('Team Categories', 'vslmd'),
			'param_name' => 'team_categories',
			'admin_label' => false,
			'description' => __('If you want to show only certain team categories, not the entire team, please write the categories in this field, separated by commas. Please use the <strong>category slug</strong>, not the title.', 'vslmd')
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

		array(
			'type' => 'dropdown',
			'heading' => __('Structure', 'vslmd'),
			'param_name' => 'structure',
			'value' => array(
				__('Content Block', 'vslmd') => 'content-block', 
				__('Content Overlay', 'vslmd') => 'content-overlay', 
				),
			'admin_label' => false,
			'description' => __('Select the better structure for your page design.', 'vslmd'),
			'group' => 'Personal Info Design Options',
			),

		array(
			'type' => 'colorpicker',
			'heading' => __( 'Background Color', 'js_composer' ),
			'param_name' => 'background',
			'description' => __( 'Select background color.', 'js_composer' ),
			'group' => 'Personal Info Design Options',
			'dependency' => array(
				'element' => 'structure', 
				'value' => array('content-block'),
				),
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
