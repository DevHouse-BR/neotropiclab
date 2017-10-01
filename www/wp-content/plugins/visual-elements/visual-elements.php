<?php
/*
Plugin Name: Visual Elements
Plugin URI: https://visualmodo.com
Description: Extend Visual Composer elements.
Version: 1.0.0
Author: Jared S Dias
Author URI: https://visualmodo.com
License: GPLv3 or later
Text Domain: vslmd
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

if ( ! defined( 'VE_VERSION' ) ) define( 'VE_VERSION', '1.0.0' );

// Visual Elements Base
$ve_core = dirname(__FILE__) . "/vslmd";
require_once( $ve_core . "/modules/icon-manager/icon-manager.php");
require_once( $ve_core . "/modules/updater/updater.php");
require_once( $ve_core . "/options/init.php");
require_once( $ve_core . "/modules/svg/svg.php");
// Visual Elements Menu

add_action( 'admin_menu', 'visual_elements_admin_menu' );

function visual_elements_admin_menu() {
	add_menu_page( 'Visual Elements', 'Visual Elements', 'manage_options', 'visual-elements.php', 'visual_elements_home', 'dashicons-admin-generic', 99  );
}

function visual_elements_home(){ ?>
<div class="wrap ve-page-welcome about-wrap">
  <h1><?php echo sprintf( __( 'Welcome to Visual Elements %s', 'js_composer' ), isset( $matches[0] ) ? $matches[0] : VE_VERSION ) ?></h1>

  <div class="about-text">
  <?php _e( 'Congratulations! Within minutes you can build complex layouts on the basis of our content elements and without touching a single line of code.', 'js_composer' ) ?>
  </div>
  <div class="wp-badge ve-page-logo">
    <?php echo sprintf( __( 'Version %s', 'js_composer' ), VE_VERSION ) ?>
  </div>
  <p class="ve-page-actions">
    <a href="<?php echo esc_attr( admin_url( 'admin.php?page=VisualElementsSettings' ) ) ?>"
      class="button button-primary ve-button-settings"><?php _e( 'Settings', 'js_composer' ) ?></a>
      <a href="https://twitter.com/share" class="twitter-share-button"
      data-via="visualmodo"
      data-text="Take full control over your WordPress site with Visual Elements"
      data-url="http://visualmodo.com" data-size="large">Tweet</a>
      <script>! function ( d, s, id ) {
        var js, fjs = d.getElementsByTagName( s )[ 0 ], p = /^http:/.test( d.location ) ? 'http' : 'https';
        if ( ! d.getElementById( id ) ) {
          js = d.createElement( s );
          js.id = id;
          js.src = p + '://platform.twitter.com/widgets.js';
          fjs.parentNode.insertBefore( js, fjs );
        }
      }( document, 'script', 'twitter-wjs' );</script>
    </p>
  </div>
  <?php
}

class VCExtendAddonClass {
  function __construct() {
        // We safely integrate with VC with this hook
    add_action( 'init', array( $this, 'integrateWithVC' ) );
    $ve_core = dirname(__FILE__) . "/vslmd";
    require_once( $ve_core . "/vc-params/iconmanager.php");

    add_action('admin_enqueue_scripts',array($this,'icon_manager_scripts'));

        // Register CSS and JS
    add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
  }

  function icon_manager_scripts($hook) {
    wp_enqueue_style('ve_backend_extend_style', plugins_url('assets/css/backend.min.css', __FILE__) );

    // enqueue css files on backend
    if($hook == "post.php" || $hook == "post-new.php" || $hook == 'visual-composer_page_vc-roles'){
      if((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || is_ssl()) {
        $scheme = 'https';
      }
      else {
        $scheme = 'http';
      }
      $this->paths = wp_upload_dir();
      $this->paths['fonts']   = 've_icon_fonts';
      $this->paths['fonturl'] = set_url_scheme($this->paths['baseurl'].'/'.$this->paths['fonts'], $scheme);
      $fonts = get_option('ve_icon_fonts');
      if(is_array($fonts))
      {
        foreach($fonts as $font => $info)
        {
          if(strpos($info['style'], 'http://' ) !== false) {
            wp_enqueue_style('ve-'.$font,$info['style']);
          } else {
            wp_enqueue_style('ve-'.$font,trailingslashit($this->paths['fonturl']).$info['style']);
          }
        }
      }
    }
  }

  public function integrateWithVC() {
        // Check if Visual Composer is installed
    if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
      add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
      return;
    }

    $ve_core = dirname(__FILE__) . "/vslmd";
    require_once( $ve_core . "/vc-elements/lean-map.php");
  }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__), array(), VE_VERSION );
      wp_enqueue_style( 'vc_extend_style' );

      // If you need any javascript files on front end, here is how you can load them.
      wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array(), VE_VERSION, true );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
      $plugin_data = get_plugin_data(__FILE__);
      echo '
      <div class="updated">
        <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
      </div>';
    }
  }
// Finally initialize code
  new VCExtendAddonClass();