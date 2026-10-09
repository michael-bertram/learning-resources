<?php
/**
 * Plugin Name:       Learning Resources
 * Description:       Structured learning resources for WordPress, with modules and hierarchical lessons.
 * Version:           0.1.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Michael Bertram
 * Text Domain:       learning-resources
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LEARNING_RESOURCES_VERSION', '0.1.0' );
define( 'LEARNING_RESOURCES_FILE', __FILE__ );
define( 'LEARNING_RESOURCES_DIR', plugin_dir_path( __FILE__ ) );

require_once LEARNING_RESOURCES_DIR . 'includes/post-types.php';
require_once LEARNING_RESOURCES_DIR . 'includes/taxonomies.php';
require_once LEARNING_RESOURCES_DIR . 'includes/meta.php';


/**
 * Load the Learning Resource editor sidebar.
 */
function learning_resources_enqueue_editor_assets() {
    $screen = get_current_screen();

    if ( ! $screen || 'learning_resource' !== $screen->post_type ) {
        return;
    }

    
$asset_file = LEARNING_RESOURCES_DIR . 'build/index.asset.php';

if ( ! file_exists( $asset_file ) ) {
    return;
}

$asset = require $asset_file;

wp_enqueue_script(
    'learning-resources-editor-sidebar',
    plugins_url( 'build/index.js', __FILE__ ),
    $asset['dependencies'],
    $asset['version'],
    array( 'in_footer' => true )
);
}
add_action(
    'enqueue_block_editor_assets',
    'learning_resources_enqueue_editor_assets'
);

function learning_resources_activate() {
	learning_resources_register_taxonomy();
	learning_resources_register_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'learning_resources_activate' );

function learning_resources_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'learning_resources_deactivate' );
