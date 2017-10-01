<?php
/**
 * Visual Elements Shortcodes settings Lazy mapping
 *
 * @package VisualElements
 *
 */
$ve_config_path = dirname(__FILE__) . "/elements/";

/*-----------------------------------------------------------------------------------*/
/*	Free Elements
/*-----------------------------------------------------------------------------------*/

vc_lean_map( 've_alert', null, $ve_config_path . 'alert.php' );
vc_lean_map( 've_circular_progress_bar', null, $ve_config_path . 'circular-progress-bar.php' );
vc_lean_map( 've_counter', null, $ve_config_path . 'counter.php' );
vc_lean_map( 've_icon', null, $ve_config_path . 'icon.php' );
vc_lean_map( 've_infobox', null, $ve_config_path . 'infobox.php' );
vc_lean_map( 've_list', null, $ve_config_path . 'list.php' );
vc_lean_map( 've_pricing', null, $ve_config_path . 'pricing.php' );
vc_lean_map( 've_progress_bar', null, $ve_config_path . 'progress-bar.php' );
vc_lean_map( 've_svg', null, $ve_config_path . 'svg.php' );

/*-----------------------------------------------------------------------------------*/
/*	Premium Elements
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Visualmodo Elements
/*-----------------------------------------------------------------------------------*/

vc_lean_map( 've_blog', null, $ve_config_path . 'blog.php' );
vc_lean_map( 've_knowledgebase', null, $ve_config_path . 'knowledgebase.php' );
vc_lean_map( 've_portfolio', null, $ve_config_path . 'portfolio.php' );
vc_lean_map( 've_team', null, $ve_config_path . 'team.php' );

/*-----------------------------------------------------------------------------------*/
/*	Nested Shortcodes
/*-----------------------------------------------------------------------------------*/

require_once $ve_config_path . 'icons.php';
require_once $ve_config_path . 'list-group.php';
require_once $ve_config_path . 'modal.php';
require_once $ve_config_path . 'testimonial.php';
require_once $ve_config_path . 'restaurant-menu.php';

/*-----------------------------------------------------------------------------------*/
/*	Vendor Shortcodes
/*-----------------------------------------------------------------------------------*/

if (class_exists('TwitterOAuth')) {
vc_lean_map( 've_tweets', null, $ve_config_path . 'tweets.php' );
}