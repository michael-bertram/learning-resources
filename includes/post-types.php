<?php
/** Learning Resource custom post type. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function learning_resources_register_post_type() {
	$labels = array(
		'name' => __( 'Learning Resources', 'learning-resources' ),
		'singular_name' => __( 'Learning Resource', 'learning-resources' ),
		'menu_name' => __( 'Learning Resources', 'learning-resources' ),
		'name_admin_bar' => __( 'Learning Resource', 'learning-resources' ),
		'add_new' => __( 'Add New', 'learning-resources' ),
		'add_new_item' => __( 'Add New Learning Resource', 'learning-resources' ),
		'edit_item' => __( 'Edit Learning Resource', 'learning-resources' ),
		'new_item' => __( 'New Learning Resource', 'learning-resources' ),
		'view_item' => __( 'View Learning Resource', 'learning-resources' ),
		'view_items' => __( 'View Learning Resources', 'learning-resources' ),
		'search_items' => __( 'Search Learning Resources', 'learning-resources' ),
		'not_found' => __( 'No learning resources found.', 'learning-resources' ),
		'not_found_in_trash' => __( 'No learning resources found in the bin.', 'learning-resources' ),
		'all_items' => __( 'All Learning Resources', 'learning-resources' ),
		'archives' => __( 'Learning Resource Archives', 'learning-resources' ),
		'attributes' => __( 'Learning Resource Attributes', 'learning-resources' ),
		'parent_item_colon' => __( 'Parent Learning Resource:', 'learning-resources' ),
		'item_published' => __( 'Learning resource published.', 'learning-resources' ),
		'item_updated' => __( 'Learning resource updated.', 'learning-resources' ),
	);

	register_post_type( 'learning_resource', array(
		'labels' => $labels,
		'description' => __( 'Hierarchical learning content such as lessons, sub-lessons, topics, exercises and assessments.', 'learning-resources' ),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => true,
		'rest_base' => 'learning-resources',
		'query_var' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'learning', 'with_front' => false ),
		'hierarchical' => true,
		'menu_icon' => 'dashicons-welcome-learn-more',
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		'taxonomies' => array( 'learning_module' ),
	) );
}
add_action( 'init', 'learning_resources_register_post_type' );
