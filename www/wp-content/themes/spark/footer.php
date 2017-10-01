<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package vslmd
 */
?>
<?php 

//Variables > Theme Options

$options = get_option('vslmd_options');
$footerColumns = $options['footer_widget_columns']; 
$footer_color_scheme = $options['footer_color_scheme']; 
$footer_text = $options['footer_text']; 
$footer_breadcrumbs = $options['footer_breadcrumbs']; 

//Variables > Page Options

$layout_structure = redux_post_meta( "vslmd_options", $post->ID, "layout_structure" ); $layout_structure = (!empty($layout_structure)) ? $layout_structure : '4';  

?>

<?php if($layout_structure == '2' || $layout_structure == '4') { ?>

	<div class="footer-background-image">

		<div class="wrapper wrapper-footer footer-background-color <?php echo $footer_color_scheme; ?>">
	    
		    <div class="container">

		        <div class="row">

		            <div class="col-md-12">
		    
		                <footer id="colophon" class="site-footer" role="contentinfo">
		                	
		                    <?php if ( !is_front_page() && $footer_breadcrumbs == '1' ) { ?>
		                    <div class="top-footer col-md-12">
		                        <div class="breadcrumbs-footer col-md-9">
		                            <?php if (function_exists('vslmd_breadcrumbs')) vslmd_breadcrumbs(); ?>
		                        </div>
		                        <div class="bottom-to-top col-md-3 text-right">
		                            <span><i class="fa fa-angle-up"></i></span>
		                        </div>
		                    </div>
		                    <?php } elseif ( is_front_page() || ( $footer_breadcrumbs != '' || $footer_breadcrumbs != '0' ) ) { ?>
		                    <div class="top-footer col-md-12">
		                    	<div class="bottom-to-top text-center">
		                            <span><i class="fa fa-angle-up"></i></span>
		                        </div>
		                    </div>
		                    <?php } ?>
		                
		                    <div class="widgets-footer">
		                    <?php
							
							get_template_part('widget-templates/before-footer');
							
							if($footerColumns == '1'){ ?>
							
								<div class="col-md-12">
								<?php if ( is_active_sidebar( 'first-footer' ) ) { ?>
									<?php dynamic_sidebar('first-footer'); ?>
								<?php } ?>
								</div>
								
							<?php } else if($footerColumns == '2'){ ?>
							
								<div class="col-md-6">
								<?php if ( is_active_sidebar( 'first-footer' ) ) { ?>
									<?php dynamic_sidebar('first-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-6">
								<?php if ( is_active_sidebar( 'second-footer' ) ) { ?>
									<?php dynamic_sidebar('second-footer'); ?>
								<?php } ?>
								</div>
								
							<?php } else if($footerColumns == '3'){ ?>
							
								<div class="col-md-4">
								<?php if ( is_active_sidebar( 'first-footer' ) ) { ?>
									<?php dynamic_sidebar('first-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-4">
								<?php if ( is_active_sidebar( 'second-footer' ) ) { ?>
									<?php dynamic_sidebar('second-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-4">
								<?php if ( is_active_sidebar( 'third-footer' ) ) { ?>
									<?php dynamic_sidebar('third-footer'); ?>
								<?php } ?>
								</div>
								
							<?php } else if($footerColumns == '4'){ ?>
							
								<div class="col-md-3">
								<?php if ( is_active_sidebar( 'first-footer' ) ) { ?>
									<?php dynamic_sidebar('first-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-3">
								<?php if ( is_active_sidebar( 'second-footer' ) ) { ?>
									<?php dynamic_sidebar('second-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-3">
								<?php if ( is_active_sidebar( 'third-footer' ) ) { ?>
									<?php dynamic_sidebar('third-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-3">
								<?php if ( is_active_sidebar( 'fourth-footer' ) ) { ?>
									<?php dynamic_sidebar('fourth-footer'); ?>
								<?php } ?>
								</div>
								
							<?php } else if($footerColumns == '5'){ ?>
							
								<div class="col-md-8">
								<?php if ( is_active_sidebar( 'first-footer' ) ) { ?>
									<?php dynamic_sidebar('first-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-4">
								<?php if ( is_active_sidebar( 'second-footer' ) ) { ?>
									<?php dynamic_sidebar('second-footer'); ?>
								<?php } ?>
								</div>
								
							<?php } else if($footerColumns == '6'){ ?>
							
								<div class="col-md-4">
								<?php if ( is_active_sidebar( 'first-footer' ) ) { ?>
									<?php dynamic_sidebar('first-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-8">
								<?php if ( is_active_sidebar( 'second-footer' ) ) { ?>
									<?php dynamic_sidebar('second-footer'); ?>
								<?php } ?>
								</div>
								
							<?php } else if($footerColumns == '7'){ ?>
							
								<div class="col-md-3">
								<?php if ( is_active_sidebar( 'first-footer' ) ) { ?>
									<?php dynamic_sidebar('first-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-6">
								<?php if ( is_active_sidebar( 'second-footer' ) ) { ?>
									<?php dynamic_sidebar('second-footer'); ?>
								<?php } ?>
								</div>
								
								<div class="col-md-3">
								<?php if ( is_active_sidebar( 'third-footer' ) ) { ?>
									<?php dynamic_sidebar('third-footer'); ?>
								<?php } ?>
								</div>
								
							<?php } ?>
							
		                    <?php get_template_part('widget-templates/after-footer'); ?>
		                    
		                    </div>
		                    
		                    <div class="site-info bottom-footer col-md-12">
	                        	<div class="row vertical-centering">
	                        	<div class="col-md-6 copyright-footer-item">
	                            <?php if(empty($footer_text)) { ?>
		                        <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'vslmd' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'vslmd' ), 'WordPress' ); ?></a>
		                        <span class="sep"> | </span>
		                        <?php printf( __( 'Theme: %1$s by %2$s.', 'vslmd' ), 'Mastergen', '<a href="https://visualmodo.com/" rel="designer">visualmodo.com</a>' ); ?>
	                            <?php } else { ?>
	                            	<span><?php echo $footer_text ?></span>
	                            <?php } ?>
	                            </div>
	                            <?php get_template_part('widget-templates/copyright-footer'); ?>
	                            </div>
		                    </div><!-- .site-info -->
		                    
		                </footer><!-- #colophon -->

		            </div><!--col end -->

		        </div><!-- row end -->
		        
		    </div><!-- container end -->

		    </div><!-- background color end -->
	    
	</div><!-- wrapper end -->

<?php } ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>
