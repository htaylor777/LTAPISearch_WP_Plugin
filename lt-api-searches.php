<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           lt-api-searches 
 *
 * @wordpress-plugin
 * Plugin Name:       LT API Searches
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       API Search for Recipes - more to come
 * Version:           1.0.0
 * Author:            Larry Taylor
 * Author URI:        https://ltwebdev.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lt-api-searches
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LT_API_SEARCHES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_lt_api_searches() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lt-api-searches-activator.php';
	lt_api_searches_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_lt_api_searches() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lt-api-searches-deactivator.php';
	lt_api_searches_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lt_api_searches' );
register_deactivation_hook( __FILE__, 'deactivate_lt_api_searches' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lt-api-searches.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
require plugin_dir_path(__FILE__).'includes/spoonacular-api.php';

function run_lt_api_searches() {

	$plugin = new lt_api_searches();
	$plugin->run();

}
run_lt_api_searches();
