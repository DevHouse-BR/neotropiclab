<?php
/**
 * @package vslmd
 */
?>

<?php

if ( is_singular('post') || 'gallery_item' == get_post_type() || 'page' == get_post_type() ) {
	
	//Variables > Page Options
	$layout_header_title = redux_post_meta( "vslmd_options", $post->ID, "layout_header_title" );
} else {
    $layout_header_title = '1';	
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('wrapper'); ?>>

    <?php if( $layout_header_title == '1' || $layout_header_title == '' ) { ?>
    
	<header class="entry-header">

		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<div class="entry-meta">

			<?php vslmd_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->
    
    <?php } ?>
    
	<div class="entry-content">

		<?php the_content(); ?>
		
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'vslmd' ),
				'after'  => '</div>',
			) );
		?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
