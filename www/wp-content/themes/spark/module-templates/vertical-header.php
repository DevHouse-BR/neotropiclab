<?php
/**
 * The vertical header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package vslmd
 */

$options = get_option('vslmd_options');

//Variables > Theme Options
$header_color_scheme = $options['header_color_scheme'];
if(!empty($options['brand_image']['url'])){ $brand_image = $options['brand_image']['url']; }
if(!empty($options['brand_light']['url'])){ $brand_light = $options['brand_light']['url']; }
if(!empty($options['brand_dark']['url'])){ $brand_dark = $options['brand_dark']['url']; }
if(!empty($options['brand_mobile']['url'])){ $brand_mobile = $options['brand_mobile']['url']; }
if(!empty($options['link_color_style'])){ $link_color_style = $options['link_color_style']; } else { $link_color_style = 't_link';}
if(!empty($options['header_height'])){ $header_height = $options['header_height']; } else { $header_height = 'header-medium';}

//Header Color Scheme

if ($header_color_scheme == 'light') {
	$navbar_mode = 'navbar-default';	
} else {
	$navbar_mode = 'navbar-inverse';	
}

if ( is_singular() ) {

    //Variables > Page Options
    $change_menu = redux_post_meta( "vslmd_options", $post->ID, "change_menu" );

}

/* Change Page Menu */

if(empty($change_menu)) {
    $change_menu = 'primary';
}


?> 

<!-- ******************* The Vertical Navbar Area ******************* -->
<aside class="vertical-header wrapper-fluid wrapper-navbar hidden-xs <?php echo $navbar_mode; ?>" id="wrapper-navbar">

    <nav class="site-navigation">

        <div class="navbar <?php echo $header_color_scheme .' '. $header_height; ?>">

            <div class="navbar-header">

                <!-- Your site title as branding in the menu -->
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                 <?php if(!empty($brand_image)){ ?>
                 <img class="brand-default" src='<?php echo $brand_image; ?>'>
                 <?php if(!empty($brand_light) && $header_color_scheme == 'light'){ ?> <img class="brand-light" src='<?php echo $brand_light; ?>'> <?php } ?>
                 <?php if(!empty($brand_dark) && $header_color_scheme == 'dark'){ ?> <img class="brand-dark" src='<?php echo $brand_dark; ?>'> <?php } ?>
                 <?php } else{ bloginfo( 'name' ); } ?>
             </a>

         </div>

         <!-- The WordPress Menu goes here -->
         <?php wp_nav_menu(
            array(
                'menu' => 'primary',
                'theme_location' => $change_menu,
                'depth' => 4,
                'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
                'menu_class' => $link_color_style.' '.'nav navbar-nav vertical-header-menu',
                'fallback_cb' => '',
                'menu_id' => 'main-menu',
                'walker' => new wp_bootstrap_navwalker()
                )
                ); ?>

            </div><!-- .navbar -->
            
        </nav><!-- .site-navigation -->

        <?php if ( is_active_sidebar( 'vertical-header' ) ) { ?>
            <div class="widget-area vertical-header-widget-area">
                <?php dynamic_sidebar( 'vertical-header' ); ?>
            </div>
        <?php } ?>
        
    </aside><!-- .wrapper-navbar end -->





