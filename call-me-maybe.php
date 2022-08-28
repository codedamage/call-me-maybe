<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/codedamage
 * @since             1.0.0
 * @package           Call_Me_Maybe
 *
 * @wordpress-plugin
 * Plugin Name:       Call me maybe
 * Plugin URI:        https://github.com/codedamage
 * Description:       Simple but yet powerful callback enquirer plugin
 * Version:           1.0.0
 * Author:            Viktor
 * Author URI:        https://github.com/codedamage
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       call-me-maybe
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
define( 'CALL_ME_MAYBE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-call-me-maybe-activator.php
 */
function activate_call_me_maybe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-call-me-maybe-activator.php';
	Call_Me_Maybe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-call-me-maybe-deactivator.php
 */
function deactivate_call_me_maybe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-call-me-maybe-deactivator.php';
	Call_Me_Maybe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_call_me_maybe' );
register_deactivation_hook( __FILE__, 'deactivate_call_me_maybe' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-call-me-maybe.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_call_me_maybe() {

	$plugin = new Call_Me_Maybe();
	$plugin->run();

}
run_call_me_maybe();
