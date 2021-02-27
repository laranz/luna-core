<?php
/**
 * The plugin's bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.

 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 *
 * @wordpress-plugin
 * Plugin Name:       Luna Core
 * Plugin URI:        https://wptitans.com/
 * Description:       Handle the core functionality of Luna Framework.
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            laranz
 * Author URI:        https://laranz.in/
 * Text Domain:       luna-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'You shall not pass.' );
}

// Constant for plugin's version.
define( 'LUNA_CORE_VERSION', '0.1.0' );
// Constant for plugin's directory path & URL.
define( 'LUNA_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'LUNA_BASE_URL', plugin_dir_url( __FILE__ ) );
// Constant for plugin's basename.
define( 'LUNA_BASENAME', plugin_basename( __FILE__ ) );

// Loading the autoloader.
if ( file_exists( LUNA_BASE_PATH . '/vendor/autoload.php' ) ) {
	require_once LUNA_BASE_PATH . '/vendor/autoload.php';
}

use Luna\Inc\Base\Activator;
use Luna\Inc\Base\Deactivator;

/**
 * The code that runs during plugin activation.
 * This action is documented in inc/Activator.php
 */
function activate_luna_core() {
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in inc/Deactivator.php
 */
function deactivate_luna_core() {
	Deactivator::deactivate();
}

// activation.
register_activation_hook( __FILE__, 'activate_luna_core' );
// deactivation.
register_deactivation_hook( __FILE__, 'deactivate_luna_core' );

/**
 * Run, Forest, Run!
 *
 * Since everything within the plugin is registered via
 * register_services() function.
 *
 * @since    0.1.0
 */
if ( class_exists( 'Luna\\Inc\\Init' ) ) {
	Luna\Inc\Init::register_services();
}
