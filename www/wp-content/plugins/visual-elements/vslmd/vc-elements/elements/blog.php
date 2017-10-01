<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Blog
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_blog extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'blog_layout' => 'standard_blog',
			'post_columns_count' => '2clm',
			'pagination_blog' => '',
			'post_number' => '',
			'post_categories' => '',
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
	  	$masonry_class = '';

		// Post teasers count
	  	if ( $post_number != '' && !is_numeric($post_number) ) $post_number = -1;
	  	elseif ( $post_number != '' && is_numeric($post_number) ) $post_number = $post_number;

		// Blog Type
	  	if($blog_layout == 'masonry_blog'){
	  		$blog_type = 'masonry-blog';
	  		$masonry_class = ' class="masonry-area"';

	  		if ( $post_columns_count=="2clm") { $post_columns_count = 'col-md-6'; }
	  		elseif ( $post_columns_count=="3clm") { $post_columns_count = 'col-md-4'; }
	  		elseif ( $post_columns_count=="4clm") { $post_columns_count = 'col-md-3'; }

	  	}

	  	elseif($blog_layout == 'standard_blog'){
	  		$blog_type = 'standard-blog';
	  	}


	  	if ( get_query_var('paged') ) {
	  		$paged = get_query_var('paged');
	  	} elseif ( get_query_var('page') ) {
	  		$paged = get_query_var('page');
	  	} else {
	  		$paged = 1;
	  	}

		//incase only all was selected
	  	if($post_categories == 'all') {
	  		$post_categories = null;
	  	}

	  	$args = array( 
	  		'posts_per_page' => $post_number,
	  		'post_type' => 'post',
	  		'category_name' => $post_categories,
	  		'paged'=> $paged
	  		);

	  	$wp_query = new WP_Query(); 
	  	$wp_query->query( $args );

	  	$output .= '
	  	<section id="blog" class="'. $blog_type .' '. $css_class .'">
	  		<div class="row">
	  			<div id="post-area" '. $masonry_class .'>
	  				';

	  				if($blog_layout == null) { $blog_layout = 'standard-blog'; }

	  				?>          
	  				<!-- Content Post Types -->
	  				<?php while($wp_query->have_posts()) : $wp_query->the_post();

	  				if( get_post_format() == 'quote' ) {$format = 'quote';}
	  				elseif( get_post_format() == 'aside' ) {$format = 'aside';}
	  				elseif( get_post_format() == 'video' ) {$format = 'video';}
	  				elseif( get_post_format() == 'audio' ) {$format = 'audio';}
	  				elseif( get_post_format() == 'image' ) {$format = 'image';}
	  				elseif( get_post_format() == 'gallery' ) {$format = 'gallery';}
	  				elseif( get_post_format() == 'link' ) {$format = 'link';}
	  				else {$format = 'standard';}

	  				$output .= '
	  				<article class="item-blog ' . $post_columns_count .' '. join( ' ', get_post_class() ) .'"'. ' id="post-'. $post->ID .'">
	  					';
	  					$output .= '
	  					<div class=' . '"' . $format . ' post-container">
	  						';

				/* Audio Post Format
				---------------------------------------------------------- */

				if($format == 'audio') {
					
					$mp3 = redux_post_meta( "vslmd_options", $post->ID, "meta-box-audio-url" ); 
					if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
						$output .= '
						<div class="post-thumb">
							<a title="' . get_the_title() . '" class="hover-wrap">' . get_the_post_thumbnail() . '</a>
						</div>
						';
					}
					$output .= '
					<div class="post-audio">
						' . do_shortcode('[audio src="'.$mp3.'"]') . '
					</div>
					';
				}
				
				/* Video Post Format
				---------------------------------------------------------- */
				
				elseif($format == 'video') {
					
					$webm = redux_post_meta( "vslmd_options", $post->ID, "meta-box-video-webm-url" );
					$mp4 = redux_post_meta( "vslmd_options", $post->ID, "meta-box-video-mp4-url" );
					$ogv = redux_post_meta( "vslmd_options", $post->ID, "meta-box-video-ogv-url" );
					$video_embed = redux_post_meta( "vslmd_options", $post->ID, "meta-box-video-embedded-code" );	
					
					if(!empty($webm)) {
						$webm = 'webm="'.$webm.'"';
					}
					
					if(!empty($mp4)) {
						$mp4 = 'mp4="'.$mp4.'"';
					}
					
					if(!empty($ogv)) {
						$ogv = 'ogv="'.$ogv.'"';
					}
					
					if( !empty( $video_embed ) ) {
						
						$output .= '
						<div class="post-video">
							<div class="embed-responsive embed-responsive-16by9">
								' . wp_oembed_get($video_embed) . '
							</div>
						</div>
						';
					} else {
						$output .= '
						<div class="post-video">
							<div class="video-self-hosted">
								' . do_shortcode('[video '.$webm.' '.$mp4.' '.$ogv.']') . '
							</div>
						</div>
						';
					}
					
					$output .= '
					<div class="post-card-content">
						<div class="post-name">
							<h4 class="entry-title">
								<a class="ve-global-color" href="'. get_permalink($post->ID) .'" title="'. get_the_title() .'">'. get_the_title() .'</a>
							</h4>
						</div>
						<div class="entry-content"><p>'. wp_trim_words( get_the_content(), 50, '...' ) .'</p></div>
						
						<div class="entry-meta entry-header">
							<span class="published"><i class="fa fa-calendar"></i>'. get_the_date() .'</span>
							<span class="comment-count pull-right"><i class="fa fa-comment-o"></i>'. get_comments_number( $post->ID ).'</span>
						</div>
					</div>';
				}
				
				/* Gallery Post Format
				---------------------------------------------------------- */

				elseif($format == 'gallery') {
					$output .= '
					<div class="post-gallery">
						<div id="galleryCarousel" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								';
								$i = 0;
								foreach(redux_post_meta( "vslmd_options", $post->ID, "meta-box-gallery" ) as $slide) {
									if($i == 0){ $class_active = 'class="active"';} else { $class_active = ''; }
									$output .= '<li data-target="#galleryCarousel" data-slide-to="'.$i.'" '.$class_active.'></li>';					
									$i++;
								}

								$output .= '
							</ol>
							<div class="carousel-inner" role="listbox">
								';
								$s = 0;
								foreach(redux_post_meta( "vslmd_options", $post->ID, "meta-box-gallery" ) as $slide) {
									if($s == 0){ $item_active = ' active';} else { $item_active = ''; }
									$output .= '
									<div class="item'.$item_active.'">
										<img src="'.$slide['image'].'" alt="'.$slide['title'].'">
									</div>
									';

									$s++;
								}	
								$output .= '
							</div>
							<a class="left carousel-control" href="#galleryCarousel" role="button" data-slide="prev">
								<span class="icon-prev" aria-hidden="true"><i class="fa fa-angle-left"></i></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#galleryCarousel" role="button" data-slide="next">
								<span class="icon-next" aria-hidden="true"><i class="fa fa-angle-right"></i></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
						';

						$output .= '
						<div class="post-card-content">
							<div class="post-name">
								<h4 class="entry-title">
									<a class="ve-global-color" href="'. get_permalink($post->ID) .'" title="'. get_the_title() .'">'. get_the_title() .'</a>
								</h4>
							</div>
							<div class="entry-content"><p>'. wp_trim_words( get_the_content(), 50, '...' ) .'</p></div>

							<div class="entry-meta entry-header">
								<span class="published"><i class="fa fa-calendar"></i>'. get_the_date() .'</span>
								<span class="comment-count pull-right"><i class="fa fa-comment-o"></i>'. get_comments_number( $post->ID ).'</span>
							</div>
						</div>
					</div>';
				}
				
				/* Quote Post Format
				---------------------------------------------------------- */
				
				elseif($format == 'quote') {
					$quote = redux_post_meta( "vslmd_options", $post->ID, "meta-box-post-quote-text" );
					$output .= '
					<div class="post-card-content ve-global-background-color post-quote">
						<h3 class="entry-title">'. $quote .'</h3>                    
						<span class="quote-source"><a href="'. get_permalink($post->ID) .'" title="'. get_the_author() .'">'. get_the_author() .'</a></span>
						<span class="pull-right"><i class="fa fa-quote-left"></i></span>
					</div>
					';
				}
				
				/* Image Post Format
				---------------------------------------------------------- */

				elseif($format == 'image') {
					if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
						$output .= '
						<div class="post-thumb">
							<a title="' . get_the_title() . '" href="' . get_permalink($post->ID) . '" class="hover-wrap">
								' . get_the_post_thumbnail() . '
							</a>
						</div>
						';
					}
				}
				
				/* Link Post Format
				---------------------------------------------------------- */
				
				elseif($format == 'link') {
					$link_url = redux_post_meta( "vslmd_options", $post->ID, "meta-box-link-url" );
					$output .= '
					<div class="post-card-content ve-global-background-color post-link">

						<h3 class="entry-title">
							<a href="'. $link_url .'" title="'. get_the_title() .'" target="_blank">'. get_the_title() .'</a>
						</h3>

						<span><a href="'. $link_url .'" target="_blank">'. $link_url .'</a></span>
						<span class="pull-right"><i class="fa fa-link"></i></span>

					</div>
					';
				}
				
				/* Aside Post Format
				---------------------------------------------------------- */
				
				elseif($format == 'aside') {
					$aside = redux_post_meta( "vslmd_options", $post->ID, "meta-box-post-aside-text" );
					$output .= '
					<div class="post-card-content post-aside">
						<div class="entry-content"><p>'. $aside .'</p></div>

						<div class="entry-meta entry-header">
							<span class="published"><i class="fa fa-calendar"></i>'. get_the_date() .'</span>
							<span class="pull-right"><i class="fa fa-file-text-o"></i></span>
						</div>
					</div>';
				}
				
				/* Standard Post Format
				---------------------------------------------------------- */
				
				else {
					if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
						$output .= '
						<div class="post-thumb">
							<a title="' . get_the_title() . '" href="' . get_permalink($post->ID) . '" class="hover-wrap">
								' . get_the_post_thumbnail() . '
							</a>
						</div>
						';
					}
					$output .= '
					<div class="post-card-content">
						<div class="post-name">
							<h4 class="entry-title">
								<a class="ve-global-color" href="'. get_permalink($post->ID) .'" title="'. get_the_title() .'">'. get_the_title() .'</a>
							</h4>
						</div>
						<div class="entry-content"><p>'. wp_trim_words( get_the_content(), 50, '...' ) .'</p></div>

						<div class="entry-meta entry-header">
							<span class="published"><i class="fa fa-calendar"></i>'. get_the_date() .'</span>
							<span class="comment-count pull-right"><i class="fa fa-comment-o"></i>'. get_comments_number( $post->ID ).'</span>
						</div>
					</div>';
				}

				$output .= '  
			</div>
		</article>
		';	

		endwhile;

		$output .= '
	</div> 
</div>
';

if($pagination_blog == 'yes') {
	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1; 
	$total_pages = $wp_query->max_num_pages; 

	if ($total_pages > 1){  

		$permalink_structure = get_option('permalink_structure');
		$query_type = (count($_GET)) ? '&' : '?';	
		$format = empty( $permalink_structure ) ? $query_type.'paged=%#%' : 'page/%#%/';  

		$output .= '<div class="pagination-blog text-center">';
		$pages = paginate_links( array(
			'base' => get_pagenum_link(1) . '%_%',
			'format' => $format, 
			'current' => $current, 
			'total' => $total_pages, 
			'prev_next' => false,
			'type'  => 'array',
			'prev_next'   => TRUE,
			'prev_text'    => __('«'),
			'next_text'    => __('»'),
			) );
		if( is_array( $pages ) ) {
			$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			$output .= '<ul class="pagination">';
			foreach ( $pages as $page ) {
				$output .= '<li>'.$page.'</li>';
			}
			$output .= '</ul>';
		}
		$output .= '</div>';

	}  
}
wp_reset_query();

$output .= ' 
</section>
';


return $output;
}
}

return array(
	'name' => __( 'Blog', 'js_composer' ),
	'base' => 've_blog',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	'is_container' => false,
	'show_settings_on_create' => true,
	'category' => __( 'Visual Elements', 'js_composer' ),
	'description' => __( 'Custom blog layout', 'js_composer' ),
	'params' => array(
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout', 'js_composer' ),
			'param_name' => 'blog_layout',
			'value' => array(
				__( 'Standard Blog', 'js_composer' ) => 'standard_blog',
				__( 'Masonry Blog', 'js_composer' ) => 'masonry_blog',
				),
			'description' => __( 'Please select the scheme you prefer for the blog.', 'js_composer' ),
			),

		array(
			'type' => 'dropdown',
			'heading' => __( 'Columns', 'js_composer' ),
			'param_name' => 'post_columns_count',
			'value' => array(
				__( '2 Columns', 'js_composer' ) => '2clm',
				__( '3 Columns', 'js_composer' ) => '3clm',
				__( '4 Columns', 'js_composer' ) => '4clm',
				),
			'description' => __( 'How many columns should be displayed? Just for Masonry scheme!', 'js_composer' ),
			'dependency' => array(
				'element' => 'blog_layout',
				'value' => 'masonry_blog',
				),
			),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Pagination', 'js_composer' ),
			'param_name' => 'pagination_blog',
			'value' => array(
				__( 'No', 'js_composer' ) => 'no',
				__( 'Yes', 'js_composer' ) => 'yes',
				),
			'description' => __( 'How want pagination for your blog?', 'js_composer' ),
			),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Post Number Per Page', 'js_composer' ),
			'param_name' => 'post_number',
			'description' => __( 'How many post to show? Enter number or word "All". Default value is 10.', 'js_composer' ),
			),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Categories', 'js_composer' ),
			'param_name' => 'post_categories',
			'description' => __( 'If you want to show only certain posts categories, not the entire blog, please write the categories in this field, separated by commas. Please use the <strong>category slug</strong>, not the title.', 'js_composer' ),
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
	);