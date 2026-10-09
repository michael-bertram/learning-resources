<?php
/** Learning Resource metadata. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function learning_resources_register_meta() {
	register_post_meta( 'learning_resource', '_learning_resource_type', array(
		'type' => 'string', 'single' => true, 'default' => 'lesson',
		'sanitize_callback' => 'sanitize_key', 'show_in_rest' => true,
		'auth_callback' => 'learning_resources_meta_auth',
	) );
	register_post_meta( 'learning_resource', '_learning_resource_duration', array(
		'type' => 'integer', 'single' => true, 'default' => 0,
		'sanitize_callback' => 'absint', 'show_in_rest' => true,
		'auth_callback' => 'learning_resources_meta_auth',
	) );
	register_post_meta( 'learning_resource', '_learning_resource_difficulty', array(
		'type' => 'string', 'single' => true, 'default' => 'beginner',
		'sanitize_callback' => 'sanitize_key', 'show_in_rest' => true,
		'auth_callback' => 'learning_resources_meta_auth',
	) );
	register_post_meta( 'learning_resource', '_learning_resource_objectives', array(
		'type' => 'array', 'single' => true, 'default' => array(),
		'sanitize_callback' => 'learning_resources_sanitize_objectives',
		'show_in_rest' => array( 'schema' => array( 'type' => 'array', 'items' => array( 'type' => 'string' ) ) ),
		'auth_callback' => 'learning_resources_meta_auth',
	) );
}
add_action( 'init', 'learning_resources_register_meta' );

function learning_resources_meta_auth( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
	return user_can( $user_id, 'edit_post', $post_id );
}

function learning_resources_sanitize_objectives( $value ) {
	if ( ! is_array( $value ) ) { return array(); }
	$objectives = array_map( 'sanitize_text_field', $value );
	$objectives = array_filter( $objectives, 'strlen' );
	return array_values( $objectives );
}
