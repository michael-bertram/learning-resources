<?php
/** Learning Module taxonomy. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function learning_resources_register_taxonomy() {
	$labels = array(
		'name' => __( 'Modules', 'learning-resources' ),
		'singular_name' => __( 'Module', 'learning-resources' ),
		'search_items' => __( 'Search Modules', 'learning-resources' ),
		'all_items' => __( 'All Modules', 'learning-resources' ),
		'parent_item' => __( 'Parent Module', 'learning-resources' ),
		'parent_item_colon' => __( 'Parent Module:', 'learning-resources' ),
		'edit_item' => __( 'Edit Module', 'learning-resources' ),
		'view_item' => __( 'View Module', 'learning-resources' ),
		'update_item' => __( 'Update Module', 'learning-resources' ),
		'add_new_item' => __( 'Add New Module', 'learning-resources' ),
		'new_item_name' => __( 'New Module Name', 'learning-resources' ),
		'menu_name' => __( 'Modules', 'learning-resources' ),
	);

	register_taxonomy( 'learning_module', array( 'learning_resource' ), array(
		'labels' => $labels,
		'public' => true,
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'rest_base' => 'learning-modules',
		'rewrite' => array( 'slug' => 'learning-module', 'with_front' => false ),
	) );
}
add_action( 'init', 'learning_resources_register_taxonomy', 5 );
