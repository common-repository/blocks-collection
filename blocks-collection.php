<?php
/**
 * Plugin Name: Blocks Collection
 * Plugin URI: https://wordpress.org/plugins/blocks-collection
 * Description: This plugin includes Pricing Block for WordPress block editor.
 * Version: 1.0.1
 * Requires at least: 6.1
 * Requires PHP: 7.0
 *
 * Author: Weblineindia
 * Author URI: http://www.weblineindia.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wligblocks
 * Domain Path: /languages
 *
 * @package wligblocks
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants
 */
define ( 'GBC_VERSION', '1.0.1' );
define ( 'GBC_PLUGIN_FILE', basename ( __FILE__ ) );
define ( 'GBC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define ( 'GBC_PLUGIN_URL', plugins_url( '', __FILE__ ) );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gutenberg-blocks-collection.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gutenberg_blocks_collection() {

    $plugin = new Gutenberg_Blocks_Collection();
    $plugin->run();

}
run_gutenberg_blocks_collection();