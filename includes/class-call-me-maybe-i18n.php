<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/codedamage
 * @since      1.0.0
 *
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/includes
 * @author     Viktor <oleksuh@gmail.com>
 */
class Call_Me_Maybe_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'call-me-maybe',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
