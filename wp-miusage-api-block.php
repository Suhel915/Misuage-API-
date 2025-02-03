<?php
/**
 * Plugin Name: WP MiUsage API Block
 * Description: A plugin to integrate with miusage.com API with a Gutenberg block.
 * Version: 1.0.1
 * Author: Suhel Shaikh
 * Text Domain: wp-miusage-api-block
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin directory
define( 'WP_MIUSAGE_API_BLOCK_DIR', plugin_dir_path( __FILE__ ) );

// Include necessary files
require_once WP_MIUSAGE_API_BLOCK_DIR . 'includes/class-api-handler.php';
require_once WP_MIUSAGE_API_BLOCK_DIR . 'includes/class-ajax-handler.php';
require_once WP_MIUSAGE_API_BLOCK_DIR . 'includes/class-block-renderer.php';

// Initialize classes
function wp_miusage_api_block_init() {
    new WP_Miusage_API_Handler();
    new WP_Miusage_AJAX_Handler();
    new WP_Miusage_Block_Renderer();
}
add_action( 'plugins_loaded', 'wp_miusage_api_block_init' );

// Enqueue Gutenberg block scripts and styles
function wp_miusage_enqueue_block_assets() {
    wp_enqueue_script(
        'wp-miusage-block',
        plugin_dir_url(__FILE__) . 'assets/block.js',
        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ], // Fixed dependencies
        filemtime(plugin_dir_path(__FILE__) . 'assets/block.js'),
        true
    );

    wp_enqueue_style(
        'wp-miusage-block-style',
        plugin_dir_url(__FILE__) . 'assets/block.css',
        [],
        filemtime(plugin_dir_path(__FILE__) . 'assets/block.css')
    );
}
add_action( 'enqueue_block_editor_assets', 'wp_miusage_enqueue_block_assets' );
