<?php 

/*-----------------------------------------------------------------------------------*/
/*	One Click Demo Import
/*-----------------------------------------------------------------------------------*/

//Change the location, title and other parameters of the plugin page
function ocdi_plugin_page_setup( $default_settings ) {
    $default_settings['parent_slug'] = 'themes.php';
    $default_settings['menu_title']  = esc_html__( 'Visualmodo Demo' , 'vslmd' );
    $default_settings['menu_slug']   = 'visualmodo-demo-import';

    return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );

//Disable the ProteusThemes branding notice with a WP filter
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

$product = wp_get_theme()->get( 'Name' );

if( $product == 'Edge' ) {

function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Edge Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/edge/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/edge/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/edge/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/edge/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                /*array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/edge/visual-elements.json',
                    'option_name' => 've_options',
                ),*/
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/edge/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Fitness' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Fitness Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/fitness/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/fitness/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/fitness/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/fitness/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                /*array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/fitness/visual-elements.json',
                    'option_name' => 've_options',
                ),*/
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/fitness/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Gym' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Gym Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/gym/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/gym/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/gym/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/gym/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/gym/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/gym/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Zenith' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Zenith Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/zenith/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/zenith/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/zenith/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/zenith/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/zenith/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/zenith/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'footer' => $footer_menu->term_id 
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Sport' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Sport Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/sport/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/sport/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/sport/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/sport/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/sport/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/sport/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $one_page = get_term_by( 'name', 'One Page', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'one_page' => $one_page->term_id 
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Food' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Food Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/food/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/food/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/food/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/food/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/food/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/food/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'top_menu' => $top_menu->term_id 
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Peak' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Peak Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/peak/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/peak/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/peak/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/peak/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/peak/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/peak/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $side_menu = get_term_by( 'name', 'Side', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'side_menu' => $side_menu->term_id 
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Spark' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Spark Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/spark/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/spark/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/spark/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/spark/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/spark/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/spark/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $side_menu = get_term_by( 'name', 'Side', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'side_menu' => $side_menu->term_id 
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Stream' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Stream Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/stream/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/stream/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/stream/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/stream/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/stream/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/stream/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $side_menu = get_term_by( 'name', 'Side', 'nav_menu' );
    $one_page = get_term_by( 'name', 'One Page', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'side_menu' => $side_menu->term_id,
            'one_page' => $one_page->term_id 
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Ink' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Ink Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/ink/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/ink/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/ink/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/ink/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/ink/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/ink/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $side_menu = get_term_by( 'name', 'Side Menu', 'nav_menu' );
    $categories = get_term_by( 'name', 'Categories', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'side_menu' => $side_menu->term_id,
            'categories' => $categories->term_id 
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Beyond' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Beyond Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/beyond/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/beyond/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/beyond/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/beyond/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/beyond/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/beyond/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Rare' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Rare Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/rare/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/rare/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/rare/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/rare/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/rare/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/rare/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $footer = get_term_by( 'name', 'Footer', 'nav_menu' );
    $side_navigation = get_term_by( 'Side Navigation', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'footer' => $footer->term_id,
            'side_navigation' => $side_navigation->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Wedding' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Wedding Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/wedding/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/wedding/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/wedding/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/wedding/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                /*array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/wedding/visual-elements.json',
                    'option_name' => 've_options',
                ),*/
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/wedding/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Architect' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Architect Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/architect/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/architect/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/architect/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/architect/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/architect/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/architect/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Medical' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Medical Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/medical/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/medical/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/medical/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/medical/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/medical/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/medical/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $footer = get_term_by( 'name', 'Footer', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'footer' => $footer->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Marvel' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Marvel Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/marvel/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/marvel/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/marvel/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/marvel/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/marvel/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/marvel/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
    $copyright_menu = get_term_by( 'name', 'Copyright Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
            'copyright_menu' => $copyright_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    //$blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    //update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

} elseif( $product == 'Seller' ) {

	function vslmd_import_files() {
    return array(
        array(
            'import_file_name'           => 'Seller Demo',
            //'categories'                 => array( 'Business', 'portfolio' ),
            'import_file_url'            => 'http://download.visualmodo.com/archive/demo-import/seller/demo-content.xml',
            'import_widget_file_url'     => 'http://download.visualmodo.com/archive/demo-import/seller/widgets.wie',
            'import_customizer_file_url' => 'http://download.visualmodo.com/archive/demo-import/seller/customizer.dat',
            'import_redux'               => array(
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/seller/theme-options.json',
                    'option_name' => 'vslmd_options',
                ),
                array(
                    'file_url'    => 'http://download.visualmodo.com/archive/demo-import/seller/visual-elements.json',
                    'option_name' => 've_options',
                ),
            ),
            'import_preview_image_url'   => 'http://download.visualmodo.com/archive/demo-import/import-demo-cover.png',
            'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'vslmd' ),
            'preview_url'                => 'http://theme.visualmodo.com/seller/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'vslmd_import_files' );


// Assign Front page, Posts page and menu locations after the importer

function vslmd_after_import_setup() {

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'vslmd_after_import_setup' );

}

