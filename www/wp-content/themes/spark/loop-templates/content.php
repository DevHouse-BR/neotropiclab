<?php
/**
 * @package vslmd
 */
?>
<?php if(get_post_format() == '' || get_post_format() == 'standard') { ?> 
<article id="post-<?php the_ID(); ?>" <?php post_class('wrapper-content'); ?>>
    
	<header class="entry-header">
    
    	<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?> 
        
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta wrapper-meta">
				<?php vslmd_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>
        
	</header><!-- .entry-header -->
    
		<div class="entry-content">

	            <?php
	                the_excerpt();
	            ?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'vslmd' ),
					'after'  => '</div>',
				) );
			?>
	        
		</div><!-- .entry-content -->
    
</article><!-- #post-## -->
<?php } ?> 