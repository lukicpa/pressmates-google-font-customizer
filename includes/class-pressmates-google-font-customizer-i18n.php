<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Pressmates_Google_Font_Customizer
 * @subpackage Pressmates_Google_Font_Customizer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Pressmates_Google_Font_Customizer
 * @subpackage Pressmates_Google_Font_Customizer/includes
 * @author     Darko <lukic.pa@gmail.com>
 */
class Pressmates_Google_Font_Customizer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pressmates-google-font-customizer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
