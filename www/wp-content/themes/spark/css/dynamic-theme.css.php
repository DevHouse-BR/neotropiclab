<?php header("Content-type: text/css; charset=utf-8"); 


/*-----------------------------------------------------------------------------------*/
/*	00.	General Functions
/*-----------------------------------------------------------------------------------*/

$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

require_once( $path_to_wp . '/wp-load.php' );

/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	01.	Define Values
/*-----------------------------------------------------------------------------------*/

//Variables > Theme Options

$options = get_option('vslmd_options');

$global_color = $options['global_color'];

?>

/*-----------------------------------------------------------------------------------*/
/*	02.	Global Color - Default
/*-----------------------------------------------------------------------------------*/


/* Reset */

a {
	color: <?php echo $global_color ?>;
}

h2.entry-title a {
	color: <?php echo $global_color ?>;
}

.btn-primary {
	background-color: <?php echo $global_color ?>;
	border-color: <?php echo $global_color ?>;
}


/* Header Presentation */

.header-presentation .hp-background-color {
  background-color: <?php echo $global_color ?>;
}


/* Sidebar */

.widget-area aside.widget ol li a:hover, 
.widget-area aside.widget ul li a:hover {
          color: <?php echo $global_color ?>;
}


/* Tag Cloud */

.tagcloud a:hover {
	background-color: <?php echo $global_color ?>;
}


/* Read More Button */

.vslmd-read-more-link {
	color: <?php echo $global_color ?>;
	border-color: <?php echo $global_color ?>;
}

.vslmd-read-more-link:hover {
	background-color: <?php echo $global_color ?>;
	border-color: <?php echo $global_color ?>;
}


/* Pagination */

.pagination>li>a, 
.pagination>li>span,
.pagination>li>a:focus, 
.pagination>li>a:hover, 
.pagination>li>span:focus, 
.pagination>li>span:hover {
  color: <?php echo $global_color ?>;
}

.pagination>.active>a, 
.pagination>.active>a:focus, 
.pagination>.active>a:hover, 
.pagination>.active>span, 
.pagination>.active>span:focus, 
.pagination>.active>span:hover {
  background-color: <?php echo $global_color ?>;
  border-color: <?php echo $global_color ?>;
}

/*-----------------------------------------------------------------------------------*/
/*	03.	Deprecated Shortcodes
/*-----------------------------------------------------------------------------------*/


/* Portfolio */

ul.portfolio li figure {
  background-color: <?php echo $global_color ?>;
}

/* Icon Boxes */

.services div:hover, .services div:hover a {
  background-color: <?php echo $global_color ?>;
}

/* Highlights */

.highlight1 {
  background-color: <?php echo $global_color ?>;
}


/*-----------------------------------------------------------------------------------*/
/*	04.	Global Color - Light and Dark
/*-----------------------------------------------------------------------------------*/


/* Menu */

@media (min-width: 768px) {

	.light .navbar-nav.b_link .active > a,
	.light .navbar-nav.b_link .active > a:focus,
	.light .navbar-nav.b_link .active > a:hover,
	.dark .navbar-nav.b_link .active > a,
	.dark .navbar-nav.b_link .active > a:focus,
	.dark .navbar-nav.b_link .active > a:hover {
		background-color: <?php echo $global_color ?> !important;
	}
    .light .navbar-nav.t_link .active > a,
	.light .navbar-nav.t_link .active > a:focus,
	.light .navbar-nav.t_link .active > a:hover,
    .light .navbar-nav.t_link li:hover a.dropdown-toggle,
	.dark .navbar-nav.t_link .active > a,
	.dark .navbar-nav.t_link .active > a:focus,
	.dark .navbar-nav.t_link .active > a:hover,
    .dark .navbar-nav.t_link li:hover a.dropdown-toggle,
	.navbar-default .navbar-nav.t_link li a:focus,
	.navbar-default .navbar-nav.t_link li a:hover,
    .navbar-inverse .navbar-nav.t_link li a:focus,
	.navbar-inverse .navbar-nav.t_link li a:hover {
		color: <?php echo $global_color ?> !important;
	}

}


/* Social Icons Widget */

.light .vslmd-widget-container li a,
.light .vslmd-widget-container li span i,
.dark .vslmd-widget-container li a,
.dark .vslmd-widget-container li span i {
	color: <?php echo $global_color ?>;
}


/* Footer */

.wrapper-footer.light .widgets-footer ol li a:hover, 
.wrapper-footer.light .widgets-footer ul li a:hover,
.wrapper-footer.dark .widgets-footer ol li a:hover, 
.wrapper-footer.dark .widgets-footer ul li a:hover  {
	color: <?php echo $global_color ?>;
}


/* Top Footer > Breadcrumb */

.light .top-footer .breadcrumbs-footer .breadcrumb > li a:hover,
.dark .top-footer .breadcrumbs-footer .breadcrumb > li a:hover {
	color: <?php echo $global_color ?> !important;
}

/* Bottom Footer */

.light .bottom-footer a,
.dark .bottom-footer a {
	color: <?php echo $global_color ?> !important;
}

/*-----------------------------------------------------------------------------------*/
/*	05.	WooCommerce
/*-----------------------------------------------------------------------------------*/

.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range {
	background-color: <?php echo $global_color ?>;
}

.woocommerce .widget_price_filter .price_slider_amount .button {
	color: <?php echo $global_color ?> !important;
}

/* WooCommerce - Cart Menu */

.cart-menu div.widget_shopping_cart_content p.buttons a.button.checkout {
	background-color: <?php echo $global_color ?> !important;
}

/*-----------------------------------------------------------------------------------*/
/*	06.	BBPress
/*-----------------------------------------------------------------------------------*/


.bbpress .bbp-search-form form input.button {
	background-color: <?php echo $global_color ?>;
	border-color: <?php echo $global_color ?>;
} 
