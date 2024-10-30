<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://casted.us
 * @since             1.0.0
 * @package           Casted
 *
 * @wordpress-plugin
 * Plugin Name:       Casted
 * Plugin URI:        https://help.casted.us/en/wordpress-integration
 * Description:       The Casted plugin adds Gutenberg blocks to allow easy content integration for your podcast content.
 * Version:           1.0.4
 * Author:            Casted
 * Author URI:        https://casted.us/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       casted
 * Domain Path:       /languages
 */

use Casted\Casted;
use Casted\Casted_Activator;
use Casted\Casted_Deactivator;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Autoload external dependencies
require_once(__DIR__ . '/vendor/autoload.php');

// Load in environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CASTED_VERSION', '1.0.5' );
define( 'CASTED_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'CASTED_APP_BASE_URL', isset($_ENV['APP_BASE_URL']) && is_string($_ENV['APP_BASE_URL']) ? sanitize_url($_ENV['APP_BASE_URL']) : '' );
define( 'CASTED_AUTH_BASE_URL', isset($_ENV['AUTH_BASE_URL']) && is_string($_ENV['AUTH_BASE_URL']) ? sanitize_url($_ENV['AUTH_BASE_URL']) : '' );
define( 'CASTED_API_BASE_URL', isset($_ENV['API_BASE_URL']) && is_string($_ENV['API_BASE_URL']) ? sanitize_url($_ENV['API_BASE_URL']) : '' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-casted-activator.php
 */
function activate_casted() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/src/class-casted-activator.php';
	Casted_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-casted-deactivator.php
 */
function deactivate_casted() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/src/class-casted-deactivator.php';
	Casted_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_casted' );
register_deactivation_hook( __FILE__, 'deactivate_casted' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/src/class-casted.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_casted() {

	$plugin = new Casted();
	$plugin->run();

}
run_casted();
