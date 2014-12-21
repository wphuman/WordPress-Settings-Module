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
 * The Settings definition of the plugin.
 *
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */

class Plugin_Name_Settings_Definition {

	public static $plugin_name = 'plugin-name';

	/**
	 * Sanitize plugin name.
	 *
	 * Lowercase alphanumeric characters and underscores are allowed.
	 * Uppercase characters will be converted to lowercase.
	 * Dashes characters will be converted to underscores.
	 *
	 * @access 	private
	 * @return 	string 	     	Sanitized snake cased plugin name
	 */
	private static function get_snake_cased_plugin_name() {

		return str_replace( '-', '_', sanitize_key( self::$plugin_name ) );

	}

	/**
	 * [apply_tab_slug_filters description]
	 * @param  array $default_settings [description]
	 * @return array                   [description]
	 */
	static private function apply_tab_slug_filters( $default_settings ) {

		$extended_settings[] = array();

		foreach ( $default_settings as $tab_slug => $options ) {

			$extended_settings[$tab_slug] = apply_filters( self::get_snake_cased_plugin_name() . '_settings_' . $tab_slug, $options );
		}

		return $extended_settings;
	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since 	1.0.0
	 * @return 	array 	$tabs 	Settings tabs
	 */

		static public function get_tabs() {

			$tabs 						= array();
			$tabs['default_tab']  		= __( 'Default Tab', self::$plugin_name );
			$tabs['second_tab']  		= __( 'Second Tab', self::$plugin_name );

			return apply_filters( self::get_snake_cased_plugin_name() . '_settings_tabs', $tabs );
		}

	/**
	 * 'Whitelisted' Plugin_Name settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 *
	 *
	 * @since 	1.0.0
	 * @return 	mixed 	$value 	Value saved / $default if key if not exist
	 */
	static public function get_settings() {

		$settings[] = array();

		$settings['default_tab']['default_tab_settings'] = array(
			'name' => '<strong>' . __( 'Header', self::$plugin_name ) . '</strong>',
			'type' => 'header'
			);
		$settings['default_tab']['missing_callback'] = array(
			'name' => '<strong>' . __( 'Missing Callback', self::$plugin_name ) . '</strong>',
			'type'    => 'non-exisit'
			);
		$settings['default_tab']['checkbox'] = array(
			'name' => __( 'Checkbox', self::$plugin_name ),
			'desc' => __( 'Checkbox', self::$plugin_name ),
			'type' => 'checkbox'
			);
		$settings['default_tab']['multicheck'] = array(
			'name' => __( 'Multicheck', self::$plugin_name ),
			'desc' => __( 'Multicheck with 3 options', self::$plugin_name ),
			'options' => array(
				'wp-human' => __( "I read the <a href='https://wphuman.com/blog/'>WP Human Blog</a>", self::$plugin_name  ),
				'tang-rufus'  => __( "<a href='http://tangrufus.com/'>Tang Rufus' Blog</a> looks great", self::$plugin_name  ),
				'Filter'  => __( 'You can apply filters on this option!', self::$plugin_name  )
				),
			'type' => 'multicheck'
			);
		$settings['default_tab']['multicheck_without_options'] = array(
			'name' => __( 'Multicheck', self::$plugin_name ),
			'desc' => __( 'Multicheck without options', self::$plugin_name ),
			'type' => 'multicheck'
			);
		$settings['default_tab']['radio'] = array(
			'name' => __( 'Radio', self::$plugin_name ),
			'desc' => __( 'Radio with 3 options', self::$plugin_name ),
			'options' => array(
				'wp-human' => __( "I read the <a href='https://wphuman.com/blog/'>WP Human Blog</a>", self::$plugin_name  ),
				'tang-rufus'  => __( "<a href='http://tangrufus.com/'>Tang Rufus' Blog</a> looks great", self::$plugin_name  ),
				'Filter'  => __( 'You can apply filters on this option!', self::$plugin_name  )
				),
			'type' => 'radio'
			);
		$settings['default_tab']['radio_without_options'] = array(
			'name' => __( 'Radio', self::$plugin_name ),
			'desc' => __( 'Radio without options', self::$plugin_name ),
			'type' => 'radio'
			);
		$settings['default_tab']['text'] = array(
			'name' => __( 'Text', self::$plugin_name ),
			'desc' => __( 'Text', self::$plugin_name ),
			'type' => 'text'
			);
		$settings['default_tab']['text_with_std'] = array(
			'name' => __( 'Text with std', self::$plugin_name ),
			'desc' => __( 'Text with std', self::$plugin_name ),
			'std' => __( 'std will be saved!', self::$plugin_name ),
			'type' => 'text'
			);
		$settings['default_tab']['email'] = array(
			'name' => __( 'Email', self::$plugin_name ),
			'desc' => __( 'Email', self::$plugin_name ),
			'type' => 'email'
			);
		$settings['default_tab']['url'] = array(
			'name' => __( 'URL', self::$plugin_name ),
			'desc' => __( 'By default, only http & https are allowed', self::$plugin_name ),
			'type' => 'url'
			);
		$settings['default_tab']['password'] = array(
			'name' => __( 'Password', self::$plugin_name ),
			'desc' => __( 'Password', self::$plugin_name ),
			'type' => 'password'
			);
		$settings['default_tab']['number'] = array(
			'name' => __( 'Number', self::$plugin_name ),
			'desc' => __( 'Number', self::$plugin_name ),
			'type' => 'number'
			);
		$settings['default_tab']['number_with_attributes'] = array(
			'name' => __( 'Number', self::$plugin_name ),
			'desc' => __( 'Max: 1000, Min: 20, Step: 30', self::$plugin_name ),
			'max'  => 1000,
			'min'  => 20,
			'step'  => 30,
			'type' => 'number'
			);
		$settings['default_tab']['textarea'] = array(
			'name' => __( 'Textarea', self::$plugin_name ),
			'desc' => __( 'Textarea', self::$plugin_name ),
			'type' => 'textarea'
			);
		$settings['default_tab']['textarea_with_std'] = array(
			'name' => __( 'Textarea with std', self::$plugin_name ),
			'desc' => __( 'Textarea with std', self::$plugin_name ),
			'std' => __( 'std will be saved!', self::$plugin_name ),
			'type' => 'textarea'
			);
		$settings['default_tab']['select'] = array(
			'name' => __( 'Select', self::$plugin_name ),
			'desc' => __( 'Select with 3 options', self::$plugin_name ),
			'options' => array(
				'wp-human' => __( "I read the <a href='https://wphuman.com/blog/'>WP Human Blog</a>", self::$plugin_name  ),
				'tang-rufus'  => __( "<a href='http://tangrufus.com/'>Tang Rufus' Blog</a> looks great", self::$plugin_name  ),
				'Filter'  => __( 'You can apply filters on this option!', self::$plugin_name  )
				),
			'type' => 'select'
			);
		$settings['default_tab']['rich_editor'] = array(
			'name' => __( 'Rich Editor', self::$plugin_name ),
			'desc' => __( 'Rich Editor save as HTML markups', self::$plugin_name ),
			'type' => 'rich_editor'
			);


		$settings['second_tab']['extend_me'] = array(
			'name' => 'Extend me',
			'desc' => __( 'You can extend me via hooks and filters.', self::$plugin_name ),
			'type' => 'text'
			);

		return self::apply_tab_slug_filters( $settings );
	}
}
