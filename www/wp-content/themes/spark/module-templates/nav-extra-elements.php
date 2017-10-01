<?php
/**
 * Navigation Extra Elements.
 *
 * Search, Cart, Side Navigation...
 *
 * @package vslmd
 */
global $yith_wcwl, $woocommerce;

$options = get_option('vslmd_options');
$search_header = (empty($options['search_header'])) ? '0' : $options['search_header'];
$woocart = (empty($options['woocart'])) ? '0' : $options['woocart'];
$side_navigation = (empty($options['side_navigation'])) ? '' : $options['side_navigation'];
$link_color_style = (!empty($options['link_color_style'])) ? $options['link_color_style'] : 't_link';
$wishlist = (empty($options['wishlist'])) ? '0' : $options['wishlist'];

?>

<div class="menu-extra-elements-menu-container">

    <ul id="extra-elements-menu" class="<?php echo $link_color_style; ?> nav navbar-nav navbar-right hidden-xs">


        <!-- Wishlist -->

        <?php if (class_exists('YITH_WCWL')) { ?>
        <?php if ( $wishlist == '1') { ?>
        <li class="wishlist-button">
            <a href="<?php echo esc_url($yith_wcwl->get_wishlist_url()); ?>">
                <span><i class="fa fa-heart-o"></i></span>
                <span class="wishlist_items_number"><?php echo yith_wcwl_count_products(); ?></span>
            </a>
        </li>                           
        <?php } ?>
        <?php } ?>

        <!-- Cart Menu -->

        <?php if($woocommerce && $woocart == '1') { ?>

        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                    <span class="cart-content-count"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
                </a>
                <ul role="menu" class="dropdown-menu extra-md-menu">
                    <li class="cart-menu">
                        <div class="widget_shopping_cart_content"></div>    
                    </li>
                </ul>
            </li>
        </ul>

        <?php } ?>

        <!-- Search Middle Screen -->

        <?php if($search_header == '1') { ?>

        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                <ul role="menu" class="dropdown-menu extra-md-menu">
                    <li>
                        <form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>" role="search">
                            <div class="input-group">
                                <input type="text" class="field form-control" name="s" id="s" placeholder="<?php _e( 'Search &hellip;', 'vslmd' ); ?>" />
                                <span class="input-group-btn">
                                    <input type="submit" class="submit btn btn-primary" name="submit" id="searchsubmit" value="<?php _e( 'Search', 'vslmd' ); ?>" />
                                </span>
                            </div>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>

        <?php } ?>

        <!-- Side Navigation -->

        <?php if( $side_navigation != '' && is_active_sidebar( 'side-navigation' ) ) { ?>

        <ul class="nav navbar-nav side-navigation-link">
            <li>
                <a id="open-side-navigation" href="#"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </li>
        </ul>

        <?php } ?>

    </ul>

</div>