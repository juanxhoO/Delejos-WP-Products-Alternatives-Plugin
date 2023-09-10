<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://dssd
 * @since      1.0.0
 *
 * @package    Product_Alternatives
 * @subpackage Product_Alternatives/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Product_Alternatives
 * @subpackage Product_Alternatives/includes
 * @author     Juan GRanja <ggjuanb@hotmail.com>
 */
class Product_Alternatives_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'product-alternatives',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
