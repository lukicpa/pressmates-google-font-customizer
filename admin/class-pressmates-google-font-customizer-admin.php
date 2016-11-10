<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Pressmates_Google_Font_Customizer
 * @subpackage Pressmates_Google_Font_Customizer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pressmates_Google_Font_Customizer
 * @subpackage Pressmates_Google_Font_Customizer/admin
 * @author     Darko <lukic.pa@gmail.com>
 */
class Pressmates_Google_Font_Customizer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressmates_Google_Font_Customizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressmates_Google_Font_Customizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pressmates-google-font-customizer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pressmates_Google_Font_Customizer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pressmates_Google_Font_Customizer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pressmates-google-font-customizer-admin.js', array( 'jquery' ), $this->version, false );
        // JS variables
        $js_vars = array(
            'url'                    => get_template_directory_uri(),
            'admin_url'              => admin_url( 'admin-ajax.php' ),
            'nonce'                  => wp_create_nonce( 'ajax-nonce' ),
            'google_font_weight'  => get_theme_mod( 'google_font_weight', 'pressmates-google-font-customizer' ),
        );

        // Localize php variables
        wp_localize_script( $this->plugin_name, 'js_vars', $js_vars );

	}

	function pressmates_google_font_style() {
		//This is my API key, for testing purposes only!
		$api_key = 'AIzaSyA0X9ZdCaq4inxxI7zUIYJPWvaTTr73UGc';

		if ( false === get_transient( 'google_fonts_json' ) ) {
			$google_font_url  = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $api_key;
			$google_font_list = wp_remote_get( $google_font_url );
			$google_font_list = $google_font_list['body'];

			$expiration =  60 * 60 * 24 * 7; // 7 days

			set_transient( 'google_fonts_json', $google_font_list, $expiration );

			$webfonts_array = $google_font_list;
		} else {
			$webfonts_array = get_transient( 'google_fonts_json' );
		}

		$list_fonts            = array(); // 1
		$list_fonts_decoded    = json_decode( $webfonts_array, true );
		$list_fonts['default'] = esc_html__( 'Theme default', 'pressmates-google-font-customizer' );

		foreach ( $list_fonts_decoded['items'] as $key => $value ) {
			$item_family              = $list_fonts_decoded['items'][$key]['family'];
			$list_fonts[$item_family] = $item_family;
		}

		return $list_fonts;
	}

	/**
	 * Generate font weight for selected font familly
	 */
	function pressmates_google_font_weight() {
		$font_familly = $_POST['selected_font'];

		$list_font_weights = array(); // 2
		$webfonts          = get_transient( 'google_fonts_json' );
		$list_fonts_decode = json_decode( $webfonts, true );
		$list_font_weights['default'] = esc_html__( 'Theme default', 'pressmates-google-font-customizer' );

		foreach ( $list_fonts_decode['items'] as $key => $value ) {
			$item_family                     = $list_fonts_decode['items'][$key]['family'];
			$list_font_weights[$item_family] = $list_fonts_decode['items'][$key]['variants'];
		}

		if ( array_key_exists( $font_familly, $list_font_weights ) ) {
			echo json_encode( $list_font_weights[$font_familly] );
		}

		die();
	}

	function pressmates_customize_register( $wp_customize ) {
		$wp_customize->add_panel( 'google_font_settings_panel', array(
			'priority'       => 35,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => esc_html__( 'Font settings', 'pressmates-google-font-customizer' ),
			'description'    => esc_html__( 'Google font settings could be changed here.', 'pressmates-google-font-customizer'),
		) );
		// Creating section for sans font
		$wp_customize->add_section( 'pressmates_google_fonts_section', array(
			'title'       => esc_html__( 'Font Settings', 'pressmates-google-font-customizer' ),
			'description' => esc_html__( 'Choose font for your content', 'pressmates-google-font-customizer' ),
			'priority'    => 100,
			'panel'  => 'google_font_settings_panel'
		) );

		/* --- Settings --- */
		$wp_customize->add_setting( 'pressmates_google_font_family', array(
			'default'   => 'default'
		) );

		$wp_customize->add_control( 'pressmates_google_font_family', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Google Font Family', 'pressmates-google-font-customizer' ),
			'section'  => 'pressmates_google_fonts_section',
			'priority' => 0,
			'choices'  => $this->pressmates_google_font_style()
		) );

		/* font weight */

		$wp_customize->add_setting( 'pressmates_google_font_weight', array(
			'default'   => 'default'
		) );

		$wp_customize->add_control( 'pressmates_google_font_weight', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Google Font Weight', 'pressmates-google-font-customizer' ),
			'section'  => 'pressmates_google_fonts_section',
			'priority' => 1,
			'choices'  => array(
				'default' => 'Default'
			)
		) );
	}

}
