<?php
/** Admin editor panels for Tutorials and Workshops. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function learning_resources_enqueue_editor_panels() {
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, array( 'tutorial', 'workshop' ), true ) ) {
		return;
	}
	wp_enqueue_script(
		'learning-resources-editor-panels',
		plugins_url( 'assets/js/editor-panels.js', LEARNING_RESOURCES_FILE ),
		array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' ),
		LEARNING_RESOURCES_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'learning_resources_enqueue_editor_panels' );
