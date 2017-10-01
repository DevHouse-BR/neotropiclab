<?php

$options = get_option('vslmd_options');

/*-----------------------------------------------------------------------------------*/
/*	Register Dynamic Post Types
/*-----------------------------------------------------------------------------------*/  

if ( $options['extra-custom-post-types'] != '0' ) {
		
	$options = get_option('vslmd_options');

	if ( $options['extra-custom-post-types'] != '0' || $options['extra-custom-post-types'] != '' ) {
	
		$CPT = 0;
		while ($CPT < $options['extra-custom-post-types']) {
		
		$CPT++;	

			if ( $options['custom-post-type-singular-name-'.$CPT.''] != '' && $options['custom-post-type-plural-name-'.$CPT.''] != '' && $options['custom-post-type-slug-'.$CPT.''] != '') {
	
	
	//Convert Post Type Name to Lowercase
	$custom_post_type_slug_lowercase = strtolower ($options['custom-post-type-slug-'.$CPT .'']);
	
	
/*-----------------------------------------------------------------------------------*/
/*	CPT General
/*-----------------------------------------------------------------------------------*/  
	
	//General Label	
	$custom_labels = array(
	 	'name' => __( $options['custom-post-type-plural-name-'.$CPT .''], 'taxonomy general name', 'vslmd'),
		'singular_name' => __( $options['custom-post-type-singular-name-'.$CPT .''], 'vslmd'),
		'search_items' =>  __( 'Search' .' '. $options['custom-post-type-singular-name-'.$CPT .''] .' '. 'Item', 'vslmd'),
		'all_items' => __( 'All' .' '. $options['custom-post-type-plural-name-'.$CPT .''], 'vslmd'),
		'parent_item' => __( 'Parent' .' '. $options['custom-post-type-singular-name-'.$CPT .''] .' '. 'Item', 'vslmd'),
		'edit_item' => __( 'Edit' .' '. $options['custom-post-type-singular-name-'.$CPT .''] .' '. 'Item', 'vslmd'),
		'update_item' => __( 'Update' .' '. $options['custom-post-type-singular-name-'.$CPT .''] .' '. 'Item', 'vslmd'),
		'add_new_item' => __( 'Add New' .' '. $options['custom-post-type-singular-name-'.$CPT .''] .' '. 'Item', 'vslmd')
	 );
	
	//Build Custom Post Type
    $args = array(
      'public' => true,
	  'labels' => $custom_labels,
	  'menu_icon' => $options['custom-post-type-icon-'.$CPT .''],
	  'rewrite' => array('slug' => $custom_post_type_slug_lowercase,'with_front' => false),
      'singular_label' => __($options['custom-post-type-singular-name-'.$CPT .''], 'vslmd'),
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'hierarchical' => false,
      'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'comments' ), 
    );
    register_post_type( $custom_post_type_slug_lowercase, $args );
	
/*-----------------------------------------------------------------------------------*/
/*	CPT Category
/*-----------------------------------------------------------------------------------*/  
	
	//Build Custom Post Type Category
	register_taxonomy($custom_post_type_slug_lowercase.'-category', 
			array($custom_post_type_slug_lowercase), 
			array("hierarchical" => true, 
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => $custom_post_type_slug_lowercase.'-category' )
	));
	
/*-----------------------------------------------------------------------------------*/
/*	CPT Tag
/*-----------------------------------------------------------------------------------*/  
	
	//Custom Post Type Tag Label
	$custom_post_type_tag_labels = array(
		'name' => __( 'Tags', 'vslmd'),
		'singular_name' => __( 'Tag', 'vslmd'),
		'search_items' =>  __( 'Search Tags', 'vslmd'),
		'all_items' => __( 'All Tags', 'vslmd'),
		'parent_item' => __( 'Parent Tag', 'vslmd'),
		'edit_item' => __( 'Edit Tag', 'vslmd'),
		'update_item' => __( 'Update Tag', 'vslmd'),
		'add_new_item' => __( 'Add New Tag', 'vslmd'),
		'new_item_name' => __( 'New Tag', 'vslmd'),
		'menu_name' => __( 'Tags', 'vslmd')
	); 	
	
	//Build Custom Post Type Label
	register_taxonomy($custom_post_type_slug_lowercase.'-tag',
		array($custom_post_type_slug_lowercase),
		array('hierarchical' => true,
		'labels' => $custom_post_type_tag_labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => $custom_post_type_slug_lowercase.'-tag' )
	)); 
	
/*-----------------------------------------------------------------------------------*/ 

				}
			}
		}
	

/*-----------------------------------------------------------------------------------*/
/*	CPT Icon Category
/*-----------------------------------------------------------------------------------*/ 
	
		// Add term page
		function vslmd_taxonomy_add_new_meta_field() {
			// this will add the custom meta field to the add new term page
			?>
			<div class="form-field">
				<label for="term_meta[category_icon]"><?php _e( 'Icon', 'vslmd' ); ?></label>
				<input type="text" name="term_meta[category_icon]" id="term_meta[category_icon]" value="">
				<p class="description"><?php _e( 'Enter an icon for category. This icons are used for example in Post filter.','vslmd' ); ?></p>
			</div>
		<?php
		}	
		
		// Edit term page
		function vslmd_taxonomy_edit_meta_field($term) {
		 
			// put the term ID into a variable
			$t_id = $term->term_id;
		 
			// retrieve the existing value(s) for this meta field. This returns an array
			$term_meta = get_option( "taxonomy_$t_id" ); ?>
			<tr class="form-field">
			<th scope="row" valign="top"><label for="term_meta[category_icon]"><?php _e( 'Icon', 'vslmd' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[category_icon]" id="term_meta[category_icon]" value="<?php echo esc_attr( $term_meta['category_icon'] ) ? esc_attr( $term_meta['category_icon'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter an icon for category. This icons are used for example in Post filter.','vslmd' ); ?></p>
				</td>
			</tr>
		<?php
		}
		
		
		// Save extra taxonomy fields callback function.
		function save_taxonomy_custom_meta( $term_id ) {
			if ( isset( $_POST['term_meta'] ) ) {
				$t_id = $term_id;
				$term_meta = get_option( "taxonomy_$t_id" );
				$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['term_meta'][$key] ) ) {
						$term_meta[$key] = $_POST['term_meta'][$key];
					}
				}
				// Save the option array.
				update_option( "taxonomy_$t_id", $term_meta );
			}
		}  
		
		$options = get_option('vslmd_options');
		$CPT = 0;
		while ($CPT < $options['extra-custom-post-types']) {
			$CPT++;	
			//Convert Post Type Name to Lowercase
			$custom_post_type_slug_lowercase = strtolower ($options['custom-post-type-slug-'.$CPT .'']);  
			add_action( ''.$custom_post_type_slug_lowercase.'-category_add_form_fields', 'vslmd_taxonomy_add_new_meta_field', 10, 2 );
			add_action( ''.$custom_post_type_slug_lowercase.'-category_edit_form_fields', 'vslmd_taxonomy_edit_meta_field', 10, 2 );
			add_action( 'edited_'.$custom_post_type_slug_lowercase.'-category', 'save_taxonomy_custom_meta', 10, 2 );  
			add_action( 'create_'.$custom_post_type_slug_lowercase.'-category', 'save_taxonomy_custom_meta', 10, 2 );
			
		}


/*-----------------------------------------------------------------------------------*/
/*	Include Single CPT
/*-----------------------------------------------------------------------------------*/ 
	
	add_filter( 'template_include', 'include_template_CPT_function', 1 );
	
	function include_template_CPT_function( $template_path ) {
	$options = get_option('vslmd_options');

		if ( $options['extra-custom-post-types'] != '0' || $options['extra-custom-post-types'] != '' ) {

		$CPT = 0;
		while ($CPT < $options['extra-custom-post-types']) {

			$CPT++;	

			if ( $options['custom-post-type-singular-name-'.$CPT.''] != '' && $options['custom-post-type-plural-name-'.$CPT.''] != '' && $options['custom-post-type-slug-'.$CPT.''] != '') {

				//Convert Post Type Name to Lowercase
				$custom_post_type_slug_lowercase = strtolower ($options['custom-post-type-slug-'.$CPT .'']);	

				if ( get_post_type() == $custom_post_type_slug_lowercase ) {
					if ( is_single() ) {
						$template_path = get_template_directory() . '/vslmd/post-types/single-cpt.php';
					}
				}
			}
		}
		return $template_path;
		}
	}
}