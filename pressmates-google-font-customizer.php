<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.pressmates.net
 * @since             1.0.0
 * @package           Pressmates_Google_Font_Customizer
 *
 * @wordpress-plugin
 * Plugin Name:       PressMates Google font customizer
 * Plugin URI:        http://www.pressmates.net
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Darko
 * Author URI:        http://www.pressmates.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pressmates-google-font-customizer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pressmates-google-font-customizer-activator.php
 */
function activate_pressmates_google_font_customizer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressmates-google-font-customizer-activator.php';
	Pressmates_Google_Font_Customizer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pressmates-google-font-customizer-deactivator.php
 */
function deactivate_pressmates_google_font_customizer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pressmates-google-font-customizer-deactivator.php';
	Pressmates_Google_Font_Customizer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pressmates_google_font_customizer' );
register_deactivation_hook( __FILE__, 'deactivate_pressmates_google_font_customizer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pressmates-google-font-customizer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pressmates_google_font_customizer() {

	$plugin = new Pressmates_Google_Font_Customizer();
	$plugin->run();

}
run_pressmates_google_font_customizer();
