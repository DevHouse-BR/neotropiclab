<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists( 'VE_Icon_Manager' ) ) {
	class VE_Icon_Manager {
		var $paths = array();
		var $svg_file;
		var $json_file;
		var $vc_fonts;
		var $vc_fonts_dir;
		var $font_name = 'unknown';
		var $svg_config = array();
		var $json_config = array();
		static $iconlist = array();

		function __construct() {
			$this->paths            = wp_upload_dir();
			$this->paths['fonts']   = 've_icon_fonts';
			$this->paths['temp']    = trailingslashit( $this->paths['fonts'] ) . 'vslmd_temp';
			$this->paths['fontdir'] = trailingslashit( $this->paths['basedir'] ) . $this->paths['fonts'];
			$this->paths['tempdir'] = trailingslashit( $this->paths['basedir'] ) . $this->paths['temp'];
			$this->paths['fonturl'] = set_url_scheme( trailingslashit( $this->paths['baseurl'] ) . $this->paths['fonts'] );
			$this->paths['tempurl'] = trailingslashit( $this->paths['baseurl'] ) . trailingslashit( $this->paths['temp'] );
			$this->paths['config']  = 'charmap.php';
			$this->vc_fonts         = trailingslashit( $this->paths['basedir'] ) . $this->paths['fonts'] . '/vslmd';
			$this->vc_fonts_dir     = plugin_dir_path( __FILE__ ) . 'assets/fonts/vslmd/';
			add_action( 'wp_ajax_vslmd_ajax_add_zipped_font', array( $this, 'add_zipped_font' ) );
			add_action( 'wp_ajax_vslmd_ajax_remove_zipped_font', array( $this, 'remove_zipped_font' ) );
			
			$defaults = get_option( 've_icon_fonts' );
			if ( ! $defaults ) {
				add_action( 'admin_init', array( $this, 'VSLMD_move_fonts' ) );
			}
		}

		function admin_scripts() {
			$upload_paths = wp_upload_dir();
			wp_enqueue_script( 'vslmd-admin-media', plugin_dir_url( __FILE__ ) . 'assets/js/icon-manager.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_media();
			wp_enqueue_style( 'vslmd-icon-manager-admin', plugin_dir_url( __FILE__ ) . 'assets/css/icon-manager.css' );
			$custom_fonts = get_option( 've_icon_fonts' );
			if ( is_array( $custom_fonts ) ) {
				foreach ( $custom_fonts as $font => $info ) {
					if ( strpos( $info['style'], 'http://' ) !== false ) {
						wp_enqueue_style( 'vslmd-' . $font, $info['style'], null, '1.0', 'all' );
					} else {
						wp_enqueue_style( 'vslmd-' . $font, trailingslashit( $upload_paths['baseurl'] . '/ve_icon_fonts/' ) . $info['style'], null, '1.0', 'all' );
					}
				}
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Icon Manager On Page Edit
		/*-----------------------------------------------------------------------------------*/

		public function get_icon_manager( $input_name, $icon ) {
			$font_manager = self::get_font_manager( $id );
			$output       = '<div class="my_param_block">';
			$output .= '<input name="' . $input_name . '" class="textinput ' . $input_name . ' text_field" type="text" value="' . $icon . '"/>';
			$output .= '</div>';
			$output .= '<script type="text/javascript">
			jQuery(document).ready(function(){

					//debugger;
					//alert("' . $id . '");
				jQuery(".icon-manager-preview-icon-' . $id . '").html("<i class=\'' . $icon . '\'></i>");
				jQuery(".icons-list-' . $id . ' li[data-icons=\'' . $icon . '\']").addClass("selected");
			});
			jQuery(".icons-list-' . $id . ' li").click(function() {
				jQuery(this).attr("class","selected").siblings().removeAttr("class");
				var icon = jQuery(this).attr("data-icons");
				jQuery("input[name=\'' . $input_name . '\']").val(icon);
				jQuery(".icon-manager-preview-icon-' . $id . '").html("<i class=\'"+icon+"\'></i>");
			});
		</script>';
		$output .= $font_manager;

		return $output;
	}

	public function get_font_manager( $id ) {

		$fonts  = get_option( 've_icon_fonts' );
		$output = '<div class="icon-manager-preview"><div class="icon-manager-preview-icon preview-icon-' . $id . '"><i class=""></i></div><input class="icon-manager-search-icon" type="text" placeholder="Search for a suitable icon.." /></div>';
		$output .= '<div id="icon-manager-search-icon-inner">';
		$output .= '<ul class="icons-list ve_icon icon-list-' . $id . '">';
		foreach ( $fonts as $font => $info ) {
			$icon_set   = array();
			$icons      = array();
			$upload_dir = wp_upload_dir();
			$path       = trailingslashit( $upload_dir['basedir'] );
			$file       = $path . $info['include'] . '/' . $info['config'];
			include( $file );
			if ( ! empty( $icons ) ) {
				$icon_set = array_merge( $icon_set, $icons );
			}
			if ( $font == "smt" ) {
				$set_name = 'Default Icons';
			} else {
				$set_name = ucfirst( $font );
			}
			if ( ! empty( $icon_set ) ) {
				$output .= '<p><strong>' . $set_name . '</strong></p>';
				$output .= '<li title="no-icon" data-icons="none" data-icons-tag="none,blank" style="cursor: pointer;" id="' . $id . '"></li>';
				foreach ( $icon_set as $icons ) {
					foreach ( $icons as $icon ) {
						$output .= '<li title="' . $icon['class'] . '" data-icons="' . $font . '-' . $icon['class'] . '" data-icons-tag="' . $icon['tags'] . '" id="' . $id . '">';
						$output .= '<i class="icon-manager-icon ' . $font . '-' . $icon['class'] . '"></i><label class="icon">' . $icon['class'] . '</label></li>';
					}
				}
			}
		}
		$output . '</ul>';
		$output .= '<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".icon-manager-search-icon").keyup(function(){
							// Retrieve the input field text and reset the count to zero
				var filter = jQuery(this).val(), count = 0;
							// Loop through the icon list
				jQuery(".icons-list li").each(function(){
								// If the list item does not contain the text phrase fade it out
					if (jQuery(this).attr("data-icons-tag").search(new RegExp(filter, "i")) < 0) {
						jQuery(this).fadeOut();
					} else {
						jQuery(this).show();
						count++;
					}
				});
			});
		});
	</script>';
	$output .= '</div>';

	return $output;
}

/*-----------------------------------------------------------------------------------*/
		/*  *.  Icon Manager Dashboard
		/*-----------------------------------------------------------------------------------*/

		function icon_manager_dashboard() {
			?>
			<div class="wrap">
				<h2>
					<?php esc_html_e( 'Icon Manager', 'vc_extend' ); ?>
					<a href="#vslmd_upload_icon" class="button button-primary vslmd_upload_icon" data-target="iconfont_upload"
					data-title="<?php echo esc_html__( "Upload/Select Fontello Font Zip", "vc_extend" ) ?>"
					data-type="application/octet-stream, application/zip"
					data-button="<?php echo esc_html__( "Insert Fonts Zip File", "vc_extend" ); ?>" data-trigger="vslmd_insert_zip"
					data-class="media-frame ">
					<?php esc_html_e( 'Upload New Icons', 'vc_extend' ); ?>
				</a> &nbsp;<span class="spinner"></span></h2>
				<div id="msg"></div>
				<?php
				$fonts = get_option( 've_icon_fonts' );
				if ( is_array( $fonts ) ) :
					?>
				<div class="metabox-holder meta-search">
					<div class="postbox ve-postbox-search">
						<h2 class="hndle ui-sortable-handle"><span>Search for Icons</h2>
						<div class="inside">
							<div class="search-area">
								<input class="search-icon" type="text" placeholder="<?php esc_attr_e( 'Start typing to search', 'vc_extend' ); ?>"/>
								<span class="search-count"></span>
							</div>
						</div>
					</div>
				</div>
				<?php self::get_font_set(); ?>
			</div>
		<?php else: ?>
			<div class="error">
				<p>
					<?php esc_html_e( 'No font icons uploaded. Upload some font icons to display here.', 'vc_extend' ); ?>
				</p>
			</div>
			<?php
			endif;
		}

		// Generate Icon Set Preview and settings page
		static function get_font_set() {
			$fonts = get_option( 've_icon_fonts' );
			$n     = count( $fonts );
			foreach ( $fonts as $font => $info ) {
				$icon_set   = array();
				$icons      = array();
				$upload_dir = wp_upload_dir();
				$path       = trailingslashit( $upload_dir['basedir'] );
				$file       = $path . $info['include'] . '/' . $info['config'];
				$output     = '<div class="icon_set-' . $font . ' metabox-holder">';
				$output .= '<div class="postbox ve-postbox-icon-manager">';
				include( $file );
				if ( ! empty( $icons ) ) {
					$icon_set = array_merge( $icon_set, $icons );
				}
				if ( ! empty( $icon_set ) ) {
					foreach ( $icon_set as $icons ) {
						$count = count( $icons );
					}
					if ( $font == 'vslmd' ) {
						$output .= '<h3 class="icon_font_name"><strong>' . esc_html__( 'Default Icons', 'vc_extend' ) . '</strong>';
					} else {
						$output .= '<h3 class="icon_font_name"><strong>' . esc_html( ucfirst( $font ) ) . '</strong>';
					}
					$output .= '<span class="fonts-count count-' . esc_attr( $font ) . '">' . esc_html( $count ) . '</span>';
					if ( $n != 1 ) {
						$output .= '<button class="button button-primary button-small vslmd_del_icon" data-delete=' . esc_attr( $font ) . ' data-title="' . esc_attr__( 'Delete Icon Set', 'vc_extend' ) . '">' . esc_html__( 'Delete Icon Set', 'vc_extend' ) . '</button>';
					}
					$output .= '</h3>';
					$output .= '<div class="inside"><div class="icon_actions">';
					$output .= '</div>';
					$output .= '<div class="icon_search"><ul class="icons-list ve_icon">';
					foreach ( $icon_set as $icons ) {
						foreach ( $icons as $icon ) {
							$output .= '<li " data-icons="' . esc_attr( $icon['class'] ) . '" data-icons-tag="' . esc_attr( $icon['tags'] ) . '">';
							$output .= '<i class="' . esc_attr( $font ) . '-' . esc_attr( $icon['class'] ) . '"></i><a class="tooltips" href="#"><span>' . esc_html( $icon['class'] ) . '</span></a></li>';
						}
					}
					$output . '</ul>';
					$output .= '</div><!-- .icon_search-->';
					$output .= '</div><!-- .inside-->';
					$output .= '</div><!-- .postbox-->';
					$output .= '</div><!-- .icon_set-' . esc_html( $font ) . ' -->';
					echo $output;
				}
			}
			$script = '<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".search-icon").keyup(function(){
					jQuery(".fonts-count").hide();
						// Retrieve the input field text and reset the count to zero
					var filter = jQuery(this).val(), count = 0;
						// Loop through the icon list
					jQuery(".icons-list li").each(function(){
							// If the list item does not contain the text phrase fade it out
						if (jQuery(this).attr("data-icons-tag").search(new RegExp(filter, "i")) < 0) {
							jQuery(this).fadeOut();
						} else {
							jQuery(this).show();
							count++;
						}
						if(count == 0)
							jQuery(".search-count").html(" ' . esc_js( __( 'Can\'t find the icon?', 'vc_extend' ) ) . ' <a href=\'#vslmd_upload_icon\' class=\'button button-primary vslmd_upload_icon\' data-target=\'iconfont_upload\' data-title=\' ' . esc_js( __( 'Upload/Select Fontello Font Zip', 'vc_extend' ) ) . ' \' data-type=\'application/octet-stream, application/zip\' data-button=\' ' . esc_js( __( 'Insert Fonts Zip File', 'vc_extend' ) ) . ' \' data-trigger=\'vslmd_insert_zip\' data-class=\'media-frame\'>' . esc_js( __( 'Upload New Font icon', 'vc_extend' ) ) . '</a>");
						else
							jQuery(".search-count").html(count+" ' . esc_js( __( 'Icons found.', 'vc_extend' ) ) . '");
						jQuery( ".search-count" ).addClass( "search-count-open" );
						if(filter == "")
							jQuery(".fonts-count").show();
					});
				});
			});
		</script>';
		echo $script;
	}

	function add_zipped_font() {
		$cap = apply_filters( 'avf_file_upload_capability', 'update_plugins' );
		if ( ! current_user_can( $cap ) ) {
			die( esc_html__( "Using this feature is reserved for Super Admins. You unfortunately don't have the necessary permissions.", "vc_extend" ) );
		}
			//get the file path of the zip file
		$attachment = $_POST['values'];
		$path       = realpath( get_attached_file( $attachment['id'] ) );
		$unzipped   = $this->zip_flatten( $path, array( '\.eot', '\.svg', '\.ttf', '\.woff', '\.json', '\.css' ) );
			// if we were able to unzip the file and save it to our temp folder extract the svg file
		if ( $unzipped ) {
			$this->create_config();
		}
			//if we got no name for the font dont add it and delete the temp folder
		if ( $this->font_name == 'unknown' ) {
			$this->delete_folder( $this->paths['tempdir'] );
			die( esc_html__( 'Was not able to retrieve the Font name from your Uploaded Folder', 'vc_extend' ) );
		}
		die( esc_html__( 'vslmd_font_added:', 'vc_extend' ) . $this->font_name );
	}

	function remove_zipped_font() {
			//get the file path of the zip file
		$font   = $_POST['del_font'];
		$list   = self::load_iconfont_list();
		$delete = isset( $list[ $font ] ) ? $list[ $font ] : false;
		if ( $delete ) {
			$this->delete_folder( $delete['include'] );
			$this->remove_font( $font );
			die( esc_html__( 'vslmd_font_removed', 'vc_extend' ) );
		}
		die( esc_html__( 'Was not able to remove Font', 'vc_extend' ) );
	}

		//extract the zip file to a flat folder and remove the files that are not needed
	function zip_flatten( $zipfile, $filter ) {
		if ( is_dir( $this->paths['tempdir'] ) ) {
			$this->delete_folder( $this->paths['tempdir'] );
			$tempdir = vslmd_backend_create_folder( $this->paths['tempdir'], false );
		} else {
			$tempdir = vslmd_backend_create_folder( $this->paths['tempdir'], false );
		}
			//$fontdir = vslmd_backend_create_folder($this->paths['fontdir'], false);
		if ( ! $tempdir ) {
			die( esc_html__( 'Wasn\'t able to create temp folder', 'vc_extend' ) );
		}
		$zip = new ZipArchive;
		if ( $zip->open( $zipfile ) ) {
			for ( $i = 0; $i < $zip->numFiles; $i ++ ) {
				$entry = $zip->getNameIndex( $i );
				if ( ! empty( $filter ) ) {
					$delete  = true;
					$matches = array();
					foreach ( $filter as $regex ) {
						preg_match( "!" . $regex . "!", $entry, $matches );
						if ( ! empty( $matches ) ) {
							$delete = false;
							break;
						}
					}
				}
				if ( substr( $entry, - 1 ) == '/' || ! empty( $delete ) ) {
					continue;
					} // skip directories and non matching files
					$fp  = $zip->getStream( $entry );
					$ofp = fopen( $this->paths['tempdir'] . '/' . basename( $entry ), 'w' );
					if ( ! $fp ) {
						die( esc_html__( 'Unable to extract the file.', 'vc_extend' ) );
					}
					while ( ! feof( $fp ) ) {
						fwrite( $ofp, fread( $fp, 8192 ) );
					}
					fclose( $fp );
					fclose( $ofp );
				}
				$zip->close();
			} else {
				die( esc_html__( "Wasn't able to work with Zip Archive", 'vc_extend' ) );
			}

			return true;
		}

		//iterate over xml file and extract the glyphs for the font
		function create_config() {
			$this->json_file = $this->find_json();
			$this->svg_file  = $this->find_svg();
			if ( empty( $this->json_file ) || empty( $this->svg_file ) ) {
				$this->delete_folder( $this->paths['tempdir'] );
				die( esc_html__( 'selection.json or SVG file not found. Was not able to create the necessary config files', 'vc_extend' ) );
			}
			//$response 	= wp_remote_get( $this->paths['tempurl'].$this->svg_file );
			$response = wp_remote_fopen( trailingslashit( $this->paths['tempurl'] ) . $this->svg_file );
			//if wordpress wasnt able to get the file which is unlikely try to fetch it old school
			$json = file_get_contents( trailingslashit( $this->paths['tempdir'] ) . $this->json_file );
			if ( empty( $response ) ) {
				$response = file_get_contents( trailingslashit( $this->paths['tempdir'] ) . $this->svg_file );
			}
			if ( ! is_wp_error( $json ) && ! empty( $json ) ) {
				$xml             = simplexml_load_string( $response );
				$font_attr       = $xml->defs->font->attributes();
				$glyphs          = $xml->defs->font->children();
				$this->font_name = (string) $font_attr['id'];
				$font_folder = trailingslashit( $this->paths['fontdir'] ) . $this->font_name;
				if ( is_dir( $font_folder ) ) {
					$this->delete_folder( $this->paths['tempdir'] );
					die( esc_html__( "It seems that the font with the same name is already exists! Please upload the font with different name.", "vc_extend" ) );
				}
				$file_contents = json_decode( $json );
				if ( ! isset( $file_contents->IcoMoonType ) ) {
					$this->delete_folder( $this->paths['tempdir'] );
					die( esc_html__( 'Uploaded font is not from IcoMoon. Please upload fonts created with the IcoMoon App Only.', 'vc_extend' ) );
				}
				$icons = $file_contents->icons;
				$n = 1;
				foreach ( $icons as $icon ) {
					$icon_name                                           = $icon->properties->name;
					$icon_class                                          = str_replace( ' ', '', $icon_name );
					$icon_class                                          = str_replace( ',', ' ', $icon_class );
					$tags                                                = implode( ",", $icon->icon->tags );
					$this->json_config[ $this->font_name ][ $icon_name ] = array(
						"class"   => $icon_class,
						"tags"    => $tags
						);
					$n ++;
				}
				if ( ! empty( $this->json_config ) && $this->font_name != 'unknown' ) {
					$this->write_config();
					$this->re_write_css();
					$this->rename_files();
					$this->rename_folder();
					$this->add_font();
				}
			}

			return false;
		}

		//writes the php config file for the font
		function write_config() {
			$charmap = $this->paths['tempdir'] . '/' . $this->paths['config'];
			$handle  = @fopen( $charmap, 'w' );
			if ( $handle ) {
				fwrite( $handle, '<?php $icons = array();' );
				foreach ( $this->json_config[ $this->font_name ] as $icon => $info ) {
					if ( ! empty( $info ) ) {
						$delimiter = "'";
						fwrite( $handle, "\r\n" . '$icons[\'' . $this->font_name . '\'][' . $delimiter . $icon . $delimiter . '] = array("class"=>' . $delimiter . $info["class"] . $delimiter . ',"tags"=>' . $delimiter . $info["tags"] . $delimiter . ');' );
					} else {
						$this->delete_folder( $this->paths['tempdir'] );
						die( esc_html__( 'Was not able to write a config file', 'vc_extend' ) );
					}
				}
				fclose( $handle );
			} else {
				$this->delete_folder( $this->paths['tempdir'] );
				die( esc_html__( 'Was not able to write a config file', 'vc_extend' ) );
			}
		}

		//re-writes the php config file for the font
		function re_write_css() {
			$style = $this->paths['tempdir'] . '/style.css';
			$file  = @file_get_contents( $style );
			if ( $file ) {
				$str = str_replace( 'fonts/', '', $file );
				$str = str_replace( 'icon-', $this->font_name . '-', $str );
				$str = str_replace( '.icon {', '[class^="' . $this->font_name . '-"], [class*=" ' . $this->font_name . '-"] {', $str );
				$str = str_replace( 'i {', '[class^="' . $this->font_name . '-"], [class*=" ' . $this->font_name . '-"] {', $str );

				/* remove comments */
				$str = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $str );

				/* remove tabs, spaces, newlines, etc. */
				$str = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $str );

				@file_put_contents( $style, $str );
			} else {
				die( esc_html__( 'Unable to write css. Upload icons downloaded only from icomoon', 'vc_extend' ) );
			}
		}

		function rename_files() {
			$extensions = array( 'eot', 'svg', 'ttf', 'woff', 'css' );
			$folder     = trailingslashit( $this->paths['tempdir'] );
			foreach ( glob( $folder . '*' ) as $file ) {
				$path_parts = pathinfo( $file );
				if ( strpos( $path_parts['filename'], '.dev' ) === false && in_array( $path_parts['extension'], $extensions ) ) {
					if ( $path_parts['filename'] !== $this->font_name ) {
						rename( $file, trailingslashit( $path_parts['dirname'] ) . $this->font_name . '.' . $path_parts['extension'] );
					}
				}
			}
		}

		//rename the temp folder and all its font files
		function rename_folder() {
			$new_name = trailingslashit( $this->paths['fontdir'] ) . $this->font_name;
			//delete folder and contents if they already exist
			$this->delete_folder( $new_name );
			if ( rename( $this->paths['tempdir'], $new_name ) ) {
				return true;
			} else {
				$this->delete_folder( $this->paths['tempdir'] );
				die( esc_html__( "Unable to add this font. Please try again.", "vc_extend" ) );
			}
		}

		//delete a folder
		function delete_folder( $new_name ) {
			//delete folder and contents if they already exist
			if ( is_dir( $new_name ) ) {
				$objects = scandir( $new_name );
				foreach ( $objects as $object ) {
					if ( $object != "." && $object != ".." ) {
						unlink( $new_name . "/" . $object );
					}
				}
				reset( $objects );
				rmdir( $new_name );
			} else {
				echo $new_name . ' no found<br/>';
			}
		}

		function add_font() {
			$fonts = get_option( 've_icon_fonts' );
			if ( empty( $fonts ) ) {
				$fonts = array();
			}
			$fonts[ $this->font_name ] = array(
				'include' => trailingslashit( $this->paths['fonts'] ) . $this->font_name,
				'folder'  => trailingslashit( $this->paths['fonts'] ) . $this->font_name,
				'style'   => $this->font_name . '/' . $this->font_name . '.css',
				'config'  => $this->paths['config']
				);
			update_option( 've_icon_fonts', $fonts );
		}

		function remove_font( $font ) {
			$fonts = get_option( 've_icon_fonts' );
			if ( isset( $fonts[ $font ] ) ) {
				unset( $fonts[ $font ] );
				update_option( 've_icon_fonts', $fonts );
			}
		}

		//finds the json file we need to create the config
		function find_json() {
			$files = scandir( $this->paths['tempdir'] );
			foreach ( $files as $file ) {
				if ( strpos( strtolower( $file ), '.json' ) !== false && $file[0] != '.' ) {
					return $file;
				}
			}
		}

		//finds the svg file we need to create the config
		function find_svg() {
			$files = scandir( $this->paths['tempdir'] );
			foreach ( $files as $file ) {
				if ( strpos( strtolower( $file ), '.svg' ) !== false && $file[0] != '.' ) {
					return $file;
				}
			}
		}

		static function load_iconfont_list() {
			if ( ! empty( self::$iconlist ) ) {
				return self::$iconlist;
			}
			$extra_fonts = get_option( 've_icon_fonts' );
			if ( empty( $extra_fonts ) ) {
				$extra_fonts = array();
			}
			$font_configs = $extra_fonts;//array_merge(vslmdBuilder::$default_iconfont, $extra_fonts);
			//if we got any include the charmaps and add the chars to an array
			$upload_dir = wp_upload_dir();
			$path       = trailingslashit( $upload_dir['basedir'] );
			$url        = trailingslashit( $upload_dir['baseurl'] );
			foreach ( $font_configs as $key => $config ) {
				if ( empty( $config['full_path'] ) ) {
					$font_configs[ $key ]['include'] = $path . $font_configs[ $key ]['include'];
					$font_configs[ $key ]['folder']  = $url . $font_configs[ $key ]['folder'];
				}
			}
			//cache the result
			self::$iconlist = $font_configs;

			return $font_configs;
		}

		function VSLMD_move_fonts() {
			// Make destination directory
			if ( ! is_dir( $this->vc_fonts ) ) {
				wp_mkdir_p( $this->vc_fonts );
			}
			@chmod( $this->vc_fonts, 0777 );
			foreach ( glob( $this->vc_fonts_dir . '*' ) as $file ) {
				$new_file = basename( $file );
				@copy( $file, $this->vc_fonts . '/' . $new_file );
			}
			$fonts['vslmd'] = array(
				'include' => trailingslashit( $this->paths['fonts'] ) . 'vslmd',
				'folder'  => trailingslashit( $this->paths['fonts'] ) . 'vslmd',
				'style'   => 'vslmd' . '/' . 'vslmd' . '.css',
				'config'  => $this->paths['config']
				);
			$defaults          = get_option( 've_icon_fonts' );
			if ( ! $defaults ) {
				update_option( 've_icon_fonts', $fonts );
			}
		}// end VSLMD_move_fonts
	}// End class
	/*
	* creates a folder for the theme framework
	*/
	if ( ! function_exists( 'vslmd_backend_create_folder' ) ) {
		function vslmd_backend_create_folder( &$folder, $addindex = true ) {
			if ( is_dir( $folder ) && $addindex == false ) {
				return true;
			}
			$created = wp_mkdir_p( trailingslashit( $folder ) );
			@chmod( $folder, 0777 );
			if ( $addindex == false ) {
				return $created;
			}
			$index_file = trailingslashit( $folder ) . 'index.php';
			if ( file_exists( $index_file ) ) {
				return $created;
			}
			$handle = @fopen( $index_file, 'w' );
			if ( $handle ) {
				fwrite( $handle, "<?php\r\necho 'Sorry, browsing the directory is not allowed!';\r\n?>
					" );
				fclose( $handle );
			}

			return $created;
		}
	}
	// Instantiate the Icon Manager
	new VE_Icon_Manager;
}

add_action( 'admin_menu', 'visual_elements_icon_manager_menu', 99 );

if ( ! function_exists( 'visual_elements_icon_manager_menu' ) ) {
	function visual_elements_icon_manager_menu() {
		$icon_manager_page = add_submenu_page(
			'visual-elements.php',
			esc_html__( "Icon Manager", "vc_extend" ),
			esc_html__( "Icon Manager", "vc_extend" ),
			"manage_options",
			"icon-manager",
			"vslmd_custom_icons_menu"
			);
		$VE_Icon_Manager  = new VE_Icon_Manager;
		add_action('admin_print_styles-' . $icon_manager_page, array( $VE_Icon_Manager, 'admin_scripts' ) );
	}
}

function vslmd_custom_icons_menu() {
	$VE_Icon_Manager = new VE_Icon_Manager;
	$VE_Icon_Manager->icon_manager_dashboard();
}

function vslmd_custom_icons() {
	$upload_paths = wp_upload_dir();
	$custom_fonts = get_option( 've_icon_fonts' );
	if ( is_array( $custom_fonts ) ) {
		foreach ( $custom_fonts as $font => $info ) {
			if ( strpos( $info['style'], 'http://' ) !== false ) {
				wp_enqueue_style( 'vslmd-' . $font, $info['style'], null, '1.0', 'all' );
			} else {
				wp_enqueue_style( 'vslmd-' . $font, trailingslashit( $upload_paths['baseurl'] . '/ve_icon_fonts/' ) . $info['style'], null, '1.0', 'all' );
			}
		}
	}
}

add_action( 'wp_enqueue_scripts', 'vslmd_custom_icons' );