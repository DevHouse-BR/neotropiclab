<?php

    // Load the embedded Redux Framework
    if ( file_exists( dirname( __FILE__ ).'/framework/framework.php' ) ) {
        require_once dirname(__FILE__).'/framework/framework.php';
    }

    // Load the theme/plugin options
    if ( file_exists( dirname( __FILE__ ) . '/options.php' ) ) {
        require_once dirname( __FILE__ ) . '/options.php';
    }

    // Load Redux extensions
		
	if ( file_exists( dirname( __FILE__ ) . '/extensions/extensions-init.php' ) ) {
		require_once dirname( __FILE__ ) . '/extensions/extensions-init.php';
	}
		
