<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package vslmd
 */

$options = get_option('vslmd_options');
global $woocommerce; 

//Variables > Theme Options
$nav_position = (!empty($options['nav_position'])) ? $options['nav_position'] : 'horizontal-nav';
$top_header_columns = $options['top_header_columns'];
$header_color_scheme = $options['header_color_scheme'];
$extra_custom_post_types = $options['extra-custom-post-types'];
$sticky_menu = $options['sticky_menu'];
$alert_message_switch = $options['alert_message_switch'];
$side_navigation = (empty($options['side_navigation'])) ? '' : $options['side_navigation'];
$boxed_or_stretched = (!empty($options['boxed_or_stretched'])) ? $options['boxed_or_stretched'] : 'stretched-layout';
$boxed_or_stretched_header = (!empty($options['boxed_or_stretched_header'])) ? $options['boxed_or_stretched_header'] : 'container';
$header_layout = (!empty($options['header_layout'])) ? $options['header_layout'] : '2';
if(!empty($options['brand_image']['url'])){ $brand_image = $options['brand_image']['url']; }
if(!empty($options['brand_light']['url'])){ $brand_light = $options['brand_light']['url']; }
if(!empty($options['brand_dark']['url'])){ $brand_dark = $options['brand_dark']['url']; }
if(!empty($options['brand_mobile']['url'])){ $brand_mobile = $options['brand_mobile']['url']; }
if(!empty($options['custom_css'])){ $custom_css = $options['custom_css']; }
if(!empty($options['custom_analytics'])){ $custom_analytics = $options['custom_analytics']; }
$link_color_style = (!empty($options['link_color_style'])) ? $options['link_color_style'] : 't_link';
if(!empty($options['header_height'])){ $header_height = $options['header_height']; } else { $header_height = 'header-medium';}
if(!empty($options['post_type_share_switch'])){ $post_type_share_switch = $options['post_type_share_switch']; } else { $post_type_share_switch = '';}
$page_404 = $options['404_switch'];

//Header Menu(s) Position

$navbar_position = '';  
if ($header_layout == '1') {
    $navbar_position = 'navbar-left';    
    $main_navigation_remove = '';
} else if ($header_layout == '2') {
    $navbar_position = 'navbar-right';  
    $main_navigation_remove = '';   
} else if ($header_layout == '3') {
    $navbar_position_left = 'navbar-right'; 
    $navbar_position_right = 'navbar-left'; 
    $main_navigation_remove = 'hidden-md hidden-lg hidden-sm';    
} else if ($header_layout == '4') {
    $navbar_position_left = 'navbar-left'; 
    $navbar_position_right = 'navbar-right';  
    $main_navigation_remove = 'hidden-md hidden-lg hidden-sm';     
} else if ($header_layout == '5') {
    $navbar_position = 'navbar-center';    
    $main_navigation_remove = 'hidden-md hidden-lg hidden-sm';    
}


//Header Color Scheme

if ($header_color_scheme == 'light') {
    $navbar_mode = 'navbar-default';    
} else {
    $navbar_mode = 'navbar-inverse';    
}

//Sticky Menu

if ($sticky_menu == '1') {
    $sticky_menu = 'data-spy="affix" data-offset-top="300"';
} else {
    $sticky_menu = '';
}

$menu_overlay_switch = "";


if ( $page_404 == '1' && is_404() ) {
    
    //Variables > 404 Theme Options
    $custom_header_title_height = (!empty($options['404_custom_header_title_height'])) ? $options['404_custom_header_title_height'] : 'medium';
    $title_editor = $options['404_title_editor'];
    $caption_editor = $options['404_caption_editor'];
    $layout_header_title = $options['404_layout_header_title'];
    $header_bg_color = $options['404_header_title_color_overlay'];
    $header_bg_image = $options['404_header_title_background'];
    $slider_rev_header = $options['404_slider_rev_header'];
    $menu_overlay_switch = $options['404_menu_overlay_switch'];
    $layout_structure = '4';
    
} elseif ( is_singular() ) {

    //Variables > Page Options
    $custom_header_title_height = redux_post_meta( "vslmd_options", $post->ID, "custom_header_title_height" ); $custom_header_title_height = (!empty($custom_header_title_height)) ? $custom_header_title_height : 'medium';
    $layout_structure = redux_post_meta( "vslmd_options", $post->ID, "layout_structure" ); $layout_structure = (!empty($layout_structure)) ? $layout_structure : '4';    
    $title_editor = redux_post_meta( "vslmd_options", $post->ID, "title_editor" );
    $caption_editor = redux_post_meta( "vslmd_options", $post->ID, "caption_editor" );
    $layout_header_title = redux_post_meta( "vslmd_options", $post->ID, "layout_header_title" );
    $header_bg_color = redux_post_meta( "vslmd_options", $post->ID, "header_title_color_overlay" );
    $header_bg_image = redux_post_meta( "vslmd_options", $post->ID, "header_title_background" );
    $slider_rev_header = redux_post_meta( "vslmd_options", $post->ID, "slider_rev_header" );
    $menu_overlay_switch = redux_post_meta( "vslmd_options", $post->ID, "menu_overlay_switch" );
    $change_menu = redux_post_meta( "vslmd_options", $post->ID, "change_menu" );

} elseif ( $woocommerce && is_shop() ) {
    
    //Variables > WooCommerce Theme Options
    $custom_header_title_height = (!empty($options['woo_custom_header_title_height'])) ? $options['woo_custom_header_title_height'] : 'medium';
    $title_editor = $options['woo_title_editor'];
    $caption_editor = $options['woo_caption_editor'];
    $layout_header_title = $options['woo_layout_header_title'];
    $header_bg_color = $options['woo_header_title_color_overlay'];
    $header_bg_image = $options['woo_header_title_background'];
    $slider_rev_header = $options['woo_slider_rev_header'];
    if(!empty($options['woo_menu_overlay_switch'])){ $menu_overlay_switch = $options['woo_menu_overlay_switch']; } else { $menu_overlay_switch = 'no_overlay';}
    $layout_structure = '4';
    
} else {

    $layout_structure = '4';
    $layout_header_title = '1';

}
    

// WooCommerce & 404 Header Background Image
    
if(!empty($header_bg_image)) {
    
    //Variables > Run
        
    $header_background_image = $header_bg_image['background-image'];
    $header_background_repeat = $header_bg_image['background-repeat'];
    $header_background_position = $header_bg_image['background-position'];
    $header_background_size = $header_bg_image['background-size'];
    $header_background_attachment = $header_bg_image['background-attachment'];

    $header_background_image = 'background-image: url('.$header_background_image.');';
    if(!empty($header_background_repeat)){ $header_background_repeat = 'background-repeat:'.$header_background_repeat.';'; }
    if(!empty($header_background_position)){ $header_background_position = 'background-position:'.$header_background_position.';'; }
    if(!empty($header_background_size)){ $header_background_size = 'background-size:'.$header_background_size.';'; }
    if(!empty($header_background_attachment)){ $header_background_attachment = 'background-attachment:'.$header_background_attachment.';'; }

    $header_bg_image = 'style="'. $header_background_image .' '. $header_background_position .' '. $header_background_size .' '. $header_background_attachment.'"';

}


/* WooCommerce & 404 Header Background Color */

if(!empty($header_bg_color)) {
    $header_bg_color = 'style="background-color: '. $header_bg_color['rgba'] .'"';
}




/* Change Page Menu */
    
if(empty($change_menu)) {
    $change_menu = 'primary';
}



?> 


<!-- ******************* Variables > Run End ******************* -->


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Custom CSS -->
<?php if(!empty($custom_css)) echo '<style type="text/css">'. $custom_css .'</style>'; ?> 
<!-- Google Analytics -->
<?php if(!empty($custom_analytics)) echo $custom_analytics; ?> 

<!-- Share Content Scripts -->
<?php if( $post_type_share_switch == '1' && isset($options['post_type_share']) ) { 
    if(in_array(get_post_type(), $options['post_type_share'])) {
        get_template_part('vslmd/share/share');
    }
} ?>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site <?php echo $boxed_or_stretched.' '.$nav_position; ?>">
<?php if($alert_message_switch == '1') { get_template_part('module-templates/alert-message'); } ?>
<?php if($side_navigation != '') { get_template_part('widget-templates/side-navigation'); } ?>

<?php if($layout_structure == '3' || $layout_structure == '4') { ?>

    <!-- ******************* The Navbar Area ******************* -->
    <div class="wrapper-fluid wrapper-navbar horizontal-header <?php echo $menu_overlay_switch; ?>" id="wrapper-navbar">

        <nav class="site-navigation">

            <?php if( $top_header_columns != '0' ){ ?> <!-- Top header -->
            
                <div class="header-top <?php echo $header_color_scheme .' '. $navbar_mode; ?>">
            
                    <div class="<?php echo $boxed_or_stretched_header; ?>">
            
                        <div class="row vertical-centering">
                            <?php get_template_part('widget-templates/top-header'); ?>
                        </div>
                
                    </div>
                
                </div>
            
            <?php } ?> <!-- Top header end -->

                            
            <div class="header-bottom navbar <?php echo $header_color_scheme.' '.$navbar_mode.' '.$header_height.' '.$main_navigation_remove; ?>" <?php echo $sticky_menu; ?>>
            
                <div class="<?php echo $boxed_or_stretched_header; ?>">
            
                    <div class="row">
            
                        <div class="col-xs-12">
            
                            <div class="navbar-header">
            
                                <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
            
                                <!-- Your site title as branding in the menu -->
                                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                    <?php if(!empty($brand_image)){ ?>
                                        <img class="brand-default" src='<?php echo $brand_image; ?>'>
                                        <?php if(!empty($brand_light)){ ?> <img class="brand-light" src='<?php echo $brand_light; ?>'> <?php } ?>
                                        <?php if(!empty($brand_dark)){ ?> <img class="brand-dark" src='<?php echo $brand_dark; ?>'> <?php } ?>
                                        <?php if(!empty($brand_mobile)){ ?> <img class="brand-mobile" src='<?php echo $brand_mobile; ?>'> <?php } ?>
                                    <?php } else{ bloginfo( 'name' ); } ?>
                                </a>
            
                            </div>
            
                            <!-- The WordPress Menu goes here -->

                            <div class="collapse navbar-collapse navbar-responsive-collapse">

                                <?php get_template_part('module-templates/nav-extra-elements'); ?>

                                <?php wp_nav_menu(
                                        array(
                                            'menu' => 'primary',
                                            'theme_location' => $change_menu,
                                            'depth' => 4,
                                            'container_class' => '',
                                            'menu_class' => $link_color_style.' '.$navbar_position.' nav navbar-nav',
                                            'fallback_cb' => '',
                                            'menu_id' => 'main-menu',
                                            'walker' => new wp_bootstrap_navwalker()
                                        )
                                ); ?>

                            </div>
            
                        </div> <!-- .col-md-11 or col-md-12 end -->
            
                    </div> <!-- .row end -->
            
                </div> <!-- .container -->
                            
            </div><!-- .navbar -->

            <?php if ($header_layout == '3' || $header_layout == '4') { ?>

                <div class="header-bottom centered-header navbar hidden-xs <?php echo $header_color_scheme .' '. $navbar_mode .' '. $header_height; ?>" <?php echo $sticky_menu; ?>>
                
                    <div class="<?php echo $boxed_or_stretched_header; ?>">
                
                        <div class="row">
                
                            <div class="col-xs-12">
                
                                <!-- The WordPress Menu goes here -->

                                    <div class="collapse navbar-collapse navbar-responsive-collapse centered-header-menu">

                                        <div class="centered-header-left-menu">

                                            <?php wp_nav_menu(
                                                    array(
                                                        'theme_location' => 'left_menu',
                                                        'depth' => 4,
                                                        'container_class' => '',
                                                        'menu_class' => $link_color_style.' '.$navbar_position_left.' '.'nav navbar-nav',
                                                        'fallback_cb' => '',
                                                        'menu_id' => 'centered-header-left-menu',
                                                        'walker' => new wp_bootstrap_navwalker()
                                                    )
                                            ); ?>

                                        </div>

                                        <div class="navbar-header">
                    
                                            <!-- Your site title as branding in the menu -->
                                            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                                <?php if(!empty($brand_image)){ ?>
                                                    <img class="brand-default" src='<?php echo $brand_image; ?>'>
                                                    <?php if(!empty($brand_light)){ ?> <img class="brand-light" src='<?php echo $brand_light; ?>'> <?php } ?>
                                                    <?php if(!empty($brand_dark)){ ?> <img class="brand-dark" src='<?php echo $brand_dark; ?>'> <?php } ?>
                                                    <?php if(!empty($brand_mobile)){ ?> <img class="brand-mobile" src='<?php echo $brand_mobile; ?>'> <?php } ?>
                                                <?php } else{ bloginfo( 'name' ); } ?>
                                            </a>
                        
                                        </div>

                                        <div class="centered-header-right-menu">

                                            <?php get_template_part('module-templates/nav-extra-elements'); ?>

                                            <?php wp_nav_menu(
                                                    array(
                                                        'theme_location' => 'right_menu',
                                                        'depth' => 4,
                                                        'container_class' => '',
                                                        'menu_class' => $link_color_style.' '.$navbar_position_right.'  nav navbar-nav',
                                                        'fallback_cb' => '',
                                                        'menu_id' => 'centered-header-right-menu',
                                                        'walker' => new wp_bootstrap_navwalker()
                                                    )
                                            ); ?>

                                        </div>

                                    </div>
                
                            </div> <!-- .col-md-11 or col-md-12 end -->
                
                        </div> <!-- .row end -->
                
                    </div> <!-- .container -->
                                
                </div><!-- .navbar -->

            <?php } else if ($header_layout == '5') { ?>

                <div class="header-bottom centered-under navbar hidden-xs <?php echo $header_color_scheme .' '. $navbar_mode .' '. $header_height; ?>" <?php echo $sticky_menu; ?>>
                
                    <div class="<?php echo $boxed_or_stretched_header; ?>">
                
                        <div class="row">
                
                            <div class="col-xs-12">
                
                                <!-- The WordPress Menu goes here -->

                                    <div class="collapse navbar-collapse navbar-responsive-collapse centered-header-menu-under">

                                        <div class="centered-header-top">

                                            <div class="col-md-4 col-md-offset-4">

                                                <div class="navbar-header">
                            
                                                    <!-- Your site title as branding in the menu -->
                                                    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                                        <?php if(!empty($brand_image)){ ?>
                                                            <img class="brand-default" src='<?php echo $brand_image; ?>'>
                                                            <?php if(!empty($brand_light)){ ?> <img class="brand-light" src='<?php echo $brand_light; ?>'> <?php } ?>
                                                            <?php if(!empty($brand_dark)){ ?> <img class="brand-dark" src='<?php echo $brand_dark; ?>'> <?php } ?>
                                                            <?php if(!empty($brand_mobile)){ ?> <img class="brand-mobile" src='<?php echo $brand_mobile; ?>'> <?php } ?>
                                                        <?php } else{ bloginfo( 'name' ); } ?>
                                                    </a>

                                                </div>
                            
                                            </div>

                                            <div class="col-md-4">
                                                <?php get_template_part('module-templates/nav-extra-elements'); ?>
                                            </div>

                                        </div>

                                        <div class="centered-header-bottom col-md-12">

                                            <?php wp_nav_menu(
                                                    array(
                                                        'menu' => 'primary',
                                                        'theme_location' => $change_menu,
                                                        'depth' => 4,
                                                        'container_class' => '',
                                                        'menu_class' => $link_color_style.' '.$navbar_position.' nav navbar-nav',
                                                        'fallback_cb' => '',
                                                        'menu_id' => 'main-menu',
                                                        'walker' => new wp_bootstrap_navwalker()
                                                    )
                                            ); ?>

                                        </div>

                                    </div>
                
                            </div> <!-- .col-md-11 or col-md-12 end -->
                
                        </div> <!-- .row end -->
                
                    </div> <!-- .container -->
                                
                </div><!-- .navbar -->

            <?php } ?>
            
        </nav><!-- .site-navigation -->
        
    </div><!-- .wrapper-navbar end -->

    <?php if( $layout_header_title != '1' ) { ?>

        <?php if( ($layout_header_title == '2' || $layout_header_title == '3') && ( !empty($title_editor) || !empty($caption_editor) ) ) { ?>

                <section class="header-presentation <?php echo $custom_header_title_height; ?>" <?php if (!empty($header_bg_image) && $layout_header_title == '3') { echo $header_bg_image; } ?> >
                    <div class="hp-background-color" <?php if (!empty($header_bg_color)) { echo $header_bg_color; } ?>>
                        <div class="container"> 
                            <div class="hp-content">
                                <?php if( $title_editor != ''){
                                    echo '<h1>' . $title_editor . '</h1>';
                                }
                                if( $caption_editor != ''){
                                    echo '<p>' . $caption_editor . '</p>';
                                } ?>
                            </div>
                        </div> 
                    </div>  
                </section><!-- Header Presentation end -->

        <?php } else if( $layout_header_title == '4' ) {

                    if ( !empty($slider_rev_header) ) { ?>

                        <section class="hp-slider-revolution">
                            <?php putRevSlider($slider_rev_header) ?>
                        </section><!-- Slider end -->

                    <?php } else { ?>

                        <div class="container">

                            <div class="row" style="padding: 100px 0;">
                                    <div class="alert alert-warning alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong><?php _e( 'No Slider Found!', 'vslmd' ); ?></strong> <?php _e( 'Please go to your page editor area and apply your slider show build with revolution slider on Page Options > Layout > Slider Revolution.', 'vslmd' ); ?>
                                    </div>
                            </div>

                        </div><!-- Alert end -->

                    <?php } ?>

        <?php } else if( $layout_header_title == '5' ) { ?>

            <section class="header-presentation simple-slider">
                <div id="galleryCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php
                        $i = 0;
                        foreach(redux_post_meta( "vslmd_options", $post->ID, "simple_slider" ) as $slide) {
                            if($i == 0){ $class_active = 'class="active"';} else { $class_active = ''; } 
                                ?><li data-target="#galleryCarousel" data-slide-to="<?php echo $i; ?>"<?php echo $class_active; ?>></li><?php             
                            $i++;
                        }
                        ?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $s = 0;
                        foreach(redux_post_meta( "vslmd_options", $post->ID, "simple_slider" ) as $slide) {
                            if($s == 0){ $item_active = ' active';} else { $item_active = ''; } ?>
                            <div class="item<?php echo $item_active; ?>">
                                <img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>">
                                 <div class="carousel-caption hp-content"> 
                                    <?php if( $slide['title'] != ''){
                                        echo '<h1>' . $slide['title'] . '</h1>';
                                    }
                                    if( $slide['description'] != ''){
                                        echo '<p>' . $slide['description'] . '</p>';
                                    } ?>
                                </div> 
                            </div>

                            <?php $s++;
                        }
                        ?>   
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

            </section>

        <?php } ?>

    <?php } ?>

<?php } ?> <!-- Header condition end -->
<?php if($nav_position == 'vertical-nav') { get_template_part('module-templates/vertical-header'); } ?> <!-- Vertical Header -->




