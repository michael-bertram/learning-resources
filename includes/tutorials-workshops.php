<?php
/** Tutorial and Workshop content types and REST metadata. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function learning_resources_register_tutorial_post_type() {
 $labels = array( 'name' => __( 'Tutorials', 'learning-resources' ), 'singular_name' => __( 'Tutorial', 'learning-resources' ), 'menu_name' => __( 'Tutorials', 'learning-resources' ), 'add_new_item' => __( 'Add New Tutorial', 'learning-resources' ), 'edit_item' => __( 'Edit Tutorial', 'learning-resources' ), 'view_item' => __( 'View Tutorial', 'learning-resources' ), 'all_items' => __( 'All Tutorials', 'learning-resources' ), 'search_items' => __( 'Search Tutorials', 'learning-resources' ), 'not_found' => __( 'No tutorials found.', 'learning-resources' ), 'not_found_in_trash' => __( 'No tutorials found in the bin.', 'learning-resources' ) );
 register_post_type( 'tutorial', array( 'labels' => $labels, 'description' => __( 'Step-by-step learning guides with structured instructions and code examples.', 'learning-resources' ), 'public' => true, 'publicly_queryable' => true, 'show_ui' => true, 'show_in_rest' => true, 'rest_base' => 'tutorials', 'has_archive' => true, 'rewrite' => array( 'slug' => 'tutorials', 'with_front' => false ), 'hierarchical' => false, 'menu_icon' => 'dashicons-welcome-learn-more', 'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ), 'taxonomies' => array( 'learning_module' ) ) );
}
add_action( 'init', 'learning_resources_register_tutorial_post_type' );

function learning_resources_register_workshop_post_type() {
 $labels = array( 'name' => __( 'Workshops', 'learning-resources' ), 'singular_name' => __( 'Workshop', 'learning-resources' ), 'menu_name' => __( 'Workshops', 'learning-resources' ), 'add_new_item' => __( 'Add New Workshop', 'learning-resources' ), 'edit_item' => __( 'Edit Workshop', 'learning-resources' ), 'view_item' => __( 'View Workshop', 'learning-resources' ), 'all_items' => __( 'All Workshops', 'learning-resources' ), 'search_items' => __( 'Search Workshops', 'learning-resources' ), 'not_found' => __( 'No workshops found.', 'learning-resources' ), 'not_found_in_trash' => __( 'No workshops found in the bin.', 'learning-resources' ) );
 register_post_type( 'workshop', array( 'labels' => $labels, 'description' => __( 'Facilitated learning experiences organised into sessions, with recordings and supporting materials.', 'learning-resources' ), 'public' => true, 'publicly_queryable' => true, 'show_ui' => true, 'show_in_rest' => true, 'rest_base' => 'workshops', 'has_archive' => true, 'rewrite' => array( 'slug' => 'workshops', 'with_front' => false ), 'hierarchical' => false, 'menu_icon' => 'dashicons-groups', 'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ), 'taxonomies' => array( 'learning_module' ) ) );
}
add_action( 'init', 'learning_resources_register_workshop_post_type' );

function learning_resources_register_tutorial_workshop_meta() {
 $auth = 'learning_resources_meta_auth';
 register_post_meta( 'tutorial', '_tutorial_intro', array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'sanitize_textarea_field', 'auth_callback' => $auth ) );
 register_post_meta( 'tutorial', '_tutorial_duration', array( 'type' => 'integer', 'single' => true, 'default' => 0, 'show_in_rest' => true, 'sanitize_callback' => 'absint', 'auth_callback' => $auth ) );
 foreach ( array( '_tutorial_prerequisites', '_tutorial_outcomes' ) as $key ) {
  register_post_meta( 'tutorial', $key, array( 'type' => 'array', 'single' => true, 'default' => array(), 'show_in_rest' => array( 'schema' => array( 'type' => 'array', 'items' => array( 'type' => 'string' ) ) ), 'sanitize_callback' => 'learning_resources_sanitize_string_list', 'auth_callback' => $auth ) );
 }
 register_post_meta( 'tutorial', '_tutorial_steps', array( 'type' => 'array', 'single' => true, 'default' => array(), 'show_in_rest' => array( 'schema' => array( 'type' => 'array', 'items' => array( 'type' => 'object', 'properties' => array( 'title' => array( 'type' => 'string' ), 'content' => array( 'type' => 'string' ), 'code' => array( 'type' => 'string' ), 'language' => array( 'type' => 'string' ) ), 'additionalProperties' => false ) ) ), 'sanitize_callback' => 'learning_resources_sanitize_tutorial_steps', 'auth_callback' => $auth ) );
 register_post_meta( 'workshop', '_workshop_facilitator_name', array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => $auth ) );
 register_post_meta( 'workshop', '_workshop_facilitator_bio', array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'sanitize_textarea_field', 'auth_callback' => $auth ) );
 register_post_meta( 'workshop', '_workshop_format', array( 'type' => 'string', 'single' => true, 'default' => 'online', 'show_in_rest' => true, 'sanitize_callback' => 'learning_resources_sanitize_workshop_format', 'auth_callback' => $auth ) );
 register_post_meta( 'workshop', '_workshop_venue', array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => $auth ) );
 register_post_meta( 'workshop', '_workshop_sessions', array( 'type' => 'array', 'single' => true, 'default' => array(), 'show_in_rest' => array( 'schema' => array( 'type' => 'array', 'items' => array( 'type' => 'object', 'properties' => array( 'title' => array( 'type' => 'string' ), 'description' => array( 'type' => 'string' ), 'video_url' => array( 'type' => 'string' ), 'duration_minutes' => array( 'type' => 'integer' ) ), 'additionalProperties' => false ) ) ), 'sanitize_callback' => 'learning_resources_sanitize_workshop_sessions', 'auth_callback' => $auth ) );
 register_post_meta( 'workshop', '_workshop_materials', array( 'type' => 'array', 'single' => true, 'default' => array(), 'show_in_rest' => array( 'schema' => array( 'type' => 'array', 'items' => array( 'type' => 'object', 'properties' => array( 'title' => array( 'type' => 'string' ), 'url' => array( 'type' => 'string' ) ), 'additionalProperties' => false ) ) ), 'sanitize_callback' => 'learning_resources_sanitize_workshop_materials', 'auth_callback' => $auth ) );
}
add_action( 'init', 'learning_resources_register_tutorial_workshop_meta' );

function learning_resources_sanitize_string_list( $value ) {
 if ( ! is_array( $value ) ) { return array(); }
 return array_values( array_filter( array_map( 'sanitize_text_field', $value ), 'strlen' ) );
}
function learning_resources_sanitize_tutorial_steps( $value ) {
 if ( ! is_array( $value ) ) { return array(); }
 $steps = array();
 foreach ( $value as $step ) { if ( is_array( $step ) ) { $steps[] = array( 'title' => isset( $step['title'] ) ? sanitize_text_field( $step['title'] ) : '', 'content' => isset( $step['content'] ) ? wp_kses_post( $step['content'] ) : '', 'code' => isset( $step['code'] ) ? sanitize_textarea_field( $step['code'] ) : '', 'language' => isset( $step['language'] ) ? sanitize_key( $step['language'] ) : '' ); } }
 return $steps;
}
function learning_resources_sanitize_workshop_format( $value ) { return in_array( $value, array( 'online', 'in_person', 'hybrid' ), true ) ? $value : 'online'; }
function learning_resources_sanitize_workshop_sessions( $value ) {
 if ( ! is_array( $value ) ) { return array(); }
 $items = array();
 foreach ( $value as $item ) { if ( is_array( $item ) ) { $items[] = array( 'title' => isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '', 'description' => isset( $item['description'] ) ? sanitize_textarea_field( $item['description'] ) : '', 'video_url' => isset( $item['video_url'] ) ? esc_url_raw( $item['video_url'] ) : '', 'duration_minutes' => isset( $item['duration_minutes'] ) ? absint( $item['duration_minutes'] ) : 0 ); } }
 return $items;
}
function learning_resources_sanitize_workshop_materials( $value ) {
 if ( ! is_array( $value ) ) { return array(); }
 $items = array();
 foreach ( $value as $item ) { if ( is_array( $item ) ) { $items[] = array( 'title' => isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '', 'url' => isset( $item['url'] ) ? esc_url_raw( $item['url'] ) : '' ); } }
 return $items;
}
