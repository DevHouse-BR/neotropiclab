<?php
/**
 * vslmd enqueue scripts
 *
 * @package vslmd
 */
 
 
// Async load
function vslmd_async_scripts($url)
{
    if ( strpos( $url, '#asyncload') === false )
        return $url;
    else if ( is_admin() )
        return str_replace( '#asyncload', '', $url );
    else
	return str_replace( '#asyncload', '', $url )."' async='async"; 
    }
add_filter( 'clean_url', 'vslmd_async_scripts', 11, 1 );

// Scripts
function vslmd_scripts() {
    wp_enqueue_style( 'vslmd-theme', get_template_directory_uri() . '/css/theme.min.css#asyncload', array(), '1.0.0');
	

    // Now load it 
    wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'vslmd-theme-js', get_template_directory_uri() . '/js/theme.min.js', array(), '20120206', true );
    
	/* 
    wp_enqueue_script( 'vslmd-navigation', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20120206', true );

    wp_enqueue_script( 'vslmd-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	*/
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', 'vslmd_scripts' );

// Removing the fuc!?$% emoji´s
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
