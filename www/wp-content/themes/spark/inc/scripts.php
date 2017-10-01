<?php
/**
 * vslmd - load the scripts
 *
 * @package vslmd
 */

    function vslmd_scripts() {
        wp_enqueue_style( 'vslmd-theme', get_stylesheet_directory_uri() . '/css/theme.css', array(), '0.1', false );
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'vslmd-navigation', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20120206', true );
        wp_enqueue_script( 'vslmd-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

add_action( 'wp_enqueue_scripts', 'vslmd_scripts' );