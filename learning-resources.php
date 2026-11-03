<?php
/**
 * Plugin Name:       Learning Resources
 * Description:       Structured learning content for WordPress, including lessons, tutorials and workshops.
 * Version:           0.2.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Michael Bertram
 * Text Domain:       learning-resources
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'LEARNING_RESOURCES_VERSION', '0.2.0' );
define( 'LEARNING_RESOURCES_FILE', __FILE__ );
define( 'LEARNING_RESOURCES_DIR', plugin_dir_path( __FILE__ ) );

require_once LEARNING_RESOURCES_DIR . 'includes/post-types.php';
require_once LEARNING_RESOURCES_DIR . 'includes/taxonomies.php';
require_once LEARNING_RESOURCES_DIR . 'includes/meta.php';
require_once LEARNING_RESOURCES_DIR . 'includes/tutorials-workshops.php';

function learning_resources_activate() {
 learning_resources_register_taxonomy();
 learning_resources_register_post_type();
 learning_resources_register_tutorial_post_type();
 learning_resources_register_workshop_post_type();
 flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'learning_resources_activate' );
function learning_resources_deactivate() { flush_rewrite_rules(); }
register_deactivation_hook( __FILE__, 'learning_resources_deactivate' );
