<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/*-----------------------------------------------------------------------------------*/
/*	Twitter
/*-----------------------------------------------------------------------------------*/

class WPBakeryShortCode_ve_tweets extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'twitter_username' => 'visualmodo',
			'tweets_number' => '1',
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

	  // Start Twitter Filter
	  	function TwitterFilter($string) {
	  		$content_array = explode(" ", $string);
	  		$tt_filter = '';

	  		foreach($content_array as $content) {
			  //starts with http://
	  			if(substr($content, 0, 7) == "http://")
	  				$content = '<a href="' . $content . '">' . $content . '</a>';

			  //starts with www.
	  			if(substr($content, 0, 4) == "www.")
	  				$content = '<a href="http://' . $content . '">' . $content . '</a>';

	  			if(substr($content, 0, 8) == "https://")
	  				$content = '<a href="' . $content . '">' . $content . '</a>';

	  			if(substr($content, 0, 1) == "#")
	  				$content = '<a href="https://twitter.com/search?src=hash&q=' . $content . '">' . $content . '</a>';

	  			if(substr($content, 0, 1) == "@")
	  				$content = '<a href="https://twitter.com/' . $content . '">' . $content . '</a>';

	  			$tt_filter .= " " . $content;
	  		}

	  		$tt_filter = trim($tt_filter);
	  		return $tt_filter;
	  	}

	  function attr($s,$attrname) { // return html attribute
	  	preg_match_all('#\s*('.$attrname.')\s*=\s*["|\']([^"\']*)["|\']\s*#i', $s, $x);
	  	if (count($x)>=3) return $x[2][0]; else return "";
	  }

	  // End Twitter Filter


	  $twitter_slides_class = '';
	  if ($tweets_number > '1') {
	  	$twitter_slides_class = ' class="slides"';
	  }

	  $tweets = getTweets(intval($tweets_number), $twitter_username);


	  $output .= '<div class="twitter-feed'.' '.$css_class.'">';
	  $output .= '<div class="twitter-symbol text-center"><i class="fa fa-twitter"></i></div><ul'.$twitter_slides_class.'>';
	  foreach($tweets as $tweet) {
	  	$output .= '<li>';
	  	$output .= '<p class="tweet-content text-center">' . TwitterFilter($tweet['text']) . '</p>';
	  	$output .= '<p class="tweet-username text-right"><a href="https://twitter.com/' . $twitter_username. '">— ' . $twitter_username . '</a></p>';
	  	$output .= '</li>';
	  }
	  $output .= '</ul></div>';

	  return $output;
	}
}

return array(
	'name' => __( 'Tweets', 'vslmd' ),
	'base' => 've_tweets',
	'icon' => plugins_url('shortcodes-icon.png', __FILE__),
	'is_container' => false,
	'show_settings_on_create' => true,
	'category' => __( 'Visual Elements', 'vslmd' ),
	'description' => __( 'Display tweets', 'vslmd' ),
	'params' => array(
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Twitter Username', 'vslmd' ),
			'param_name' => 'twitter_username',
			'description' => __( 'Insert here your twitter username only.', 'vslmd' ),
			),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'How many tweets?', 'vslmd' ),
			'param_name' => 'tweets_number',
			'description' => __( 'How many tweets you want?', 'vslmd' ),
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