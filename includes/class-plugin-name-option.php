<?php
/**
 *
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */
/**
 * The get_option functionality of the plugin.
 *
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */


class Plugin_Name_Option {

	/**
	 * Get an option
	 *
	 * Looks to see if the specified setting exists, returns default if not.
	 *
	 * @since 	1.0.0
	 * @return 	mixed 	$value 	Value saved / $default if key if not exist
	 */
	static public function get_option( $key, $default = false ) {

		if ( empty( $key ) ) {
			return $default;
		}

		// @TODO: change plugin_name_settings
		$plugin_options = get_option( 'plugin_name_settings', array() );

		$value = isset( $plugin_options[ $key ] ) ? $plugin_options[ $key ] : $default;

		return $value;
	}
}
