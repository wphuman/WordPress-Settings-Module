<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/settings
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Settings {

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
	 * The snake cased version of plugin ID for making hook tags.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $snake_cased_plugin_name;

	/**
	 * The array of plugin settings.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array     $registered_settings    The array of plugin settings.
	 */
	private $registered_settings;

	/**
	 * The callback helper to render HTML elements for settings forms.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Callback_Helper    $callback    Render HTML elements.
	 */
	protected $callback;

	/**
	 * The sanitization helper to sanitize and validate settings.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Sanitization_Helper    $sanitization    Sanitize and validate settings.
	 */
	protected $sanitization;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 	1.0.0
	 * @param 	string    							$plugin_name 			The name of this plugin.
	 * @param 	Plugin_Name_Callback_Helper 		$settings_callback 		The callback helper for rendering HTML markups
	 * @param 	Plugin_Name_Sanitization_Helper 	$settings_sanitization 	The sanitization helper for sanitizing settings
	 */
	public function __construct( $plugin_name, $settings_callback, $settings_sanitization ) {

		$this->plugin_name = $plugin_name;
		$this->snake_cased_plugin_name = $this->sanitize_snake_cased( $plugin_name );

		$this->callback = $settings_callback;

		$this->registered_settings = $this->set_registered_settings();
		$this->sanitization = $settings_sanitization;
		$this->sanitization->set_registered_settings( $this->registered_settings );
	}

	/**
	 * Sanitize a string key.
	 *
	 * Lowercase alphanumeric characters and underscores are allowed.
	 * Uppercase characters will be converted to lowercase.
	 * Dashes characters will be converted to underscores.
	 *
	 * @access   private
	 * @param  string 	$key 	String key
	 * @return string 	     	Sanitized snake cased key
	 */
	private function sanitize_snake_cased( $key ) {

		return str_replace( '-', '_', sanitize_key( $key ) );

	}

	/**
	 * Register all settings sections and fields.
	 *
	 * @since 	1.0.0
	 * @return 	void
	*/
	public function register_settings() {

		if ( false == get_option( $this->snake_cased_plugin_name . '_settings' ) ) {
			add_option( $this->snake_cased_plugin_name . '_settings', array(), '', 'yes' );
		}

		foreach( $this->registered_settings as $tab => $settings ) {

			// add_settings_section( $id, $title, $callback, $page )
			add_settings_section(
				$this->snake_cased_plugin_name . '_settings_' . $tab,
				__return_null(),
				'__return_false',
				$this->snake_cased_plugin_name . '_settings_' . $tab
				);

			foreach ( $settings as $option ) {

				$_name = isset( $option['name'] ) ? $option['name'] : '';

				// add_settings_field( $id, $title, $callback, $page, $section, $args )
				add_settings_field(
					$this->snake_cased_plugin_name . '_settings[' . $option['id'] . ']',
					$_name,
					method_exists( $this->callback, $option['type'] . '_callback' ) ? array( $this->callback, $option['type'] . '_callback' ) : array( $this->callback, 'missing_callback' ),
					$this->snake_cased_plugin_name . '_settings_' . $tab,
					$this->snake_cased_plugin_name . '_settings_' . $tab,
					array(
						'id'      => isset( $option['id'] ) ? $option['id'] : null,
						'desc'    => !empty( $option['desc'] ) ? $option['desc'] : '',
						'name'    => isset( $option['name'] ) ? $option['name'] : null,
						'section' => $tab,
						'size'    => isset( $option['size'] ) ? $option['size'] : null,
						'options' => isset( $option['options'] ) ? $option['options'] : '',
						'std'     => isset( $option['std'] ) ? $option['std'] : '',
						'max'    => isset( $option['max'] ) ? $option['max'] : 999999,
						'min'    => isset( $option['min'] ) ? $option['min'] : 0,
						'step'   => isset( $option['step'] ) ? $option['step'] : 1,
						)
					);
			} // end foreach

		} // end foreach

		// Creates our settings in the options table
		register_setting( $this->snake_cased_plugin_name . '_settings', $this->snake_cased_plugin_name . '_settings', array( $this->sanitization, 'settings_sanitize' ) );

	}

	/**
	 * Set the array of plugin settings
	 *
	 * @since 	1.0.0
	 * @return 	array 	$settings
	*/
	private function set_registered_settings() {

	/**
	 * 'Whitelisted' Plugin_Name settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 */
	$settings = array(
		// General Settings
		'default_tab' => apply_filters( $this->snake_cased_plugin_name . '_settings_default_tab',
			array(
				'default_tab_settings' => array(
					'id' => 'default_tab_settings',
					'name' => '<strong>' . __( 'Header', $this->plugin_name ) . '</strong>',
					'type' => 'header'
					),
				'missing_callback' => array(
						'id'      => 'missing_callback_id',
						'name' => '<strong>' . __( 'Missing Callback', $this->plugin_name ) . '</strong>',
						'type'    => 'non-exisit'
					),
				'checkbox' => array(
					'id' => 'checkbox',
					'name' => __( 'Checkbox', $this->plugin_name ),
					'desc' => __( 'Checkbox', $this->plugin_name ),
					'type' => 'checkbox'
					),
				'multicheck' => array(
					'id' => 'multicheck',
					'name' => __( 'Multicheck', $this->plugin_name ),
					'desc' => __( 'Multicheck with 3 options', $this->plugin_name ),
					'options' => array(
						'WP-Human' => __( "I read the <a href='https://wphuman.com/blog/'>WP Human Blog</a>", $this->plugin_name  ),
						'Tang-Rufus'  => __( "<a href='http://tangrufus.com/'>Tang Rufus' Blog</a> looks great", $this->plugin_name  ),
						'Filter'  => __( 'You can apply filters on this option!', $this->plugin_name  )
						),
					'type' => 'multicheck'
					),
				'multicheck_without_options' => array(
					'id' => 'multicheck_without_options',
					'name' => __( 'Multicheck', $this->plugin_name ),
					'desc' => __( 'Multicheck without options', $this->plugin_name ),
					'type' => 'multicheck'
					),
				'radio' => array(
					'id' => 'radio',
					'name' => __( 'Radio', $this->plugin_name ),
					'desc' => __( 'Radio with 3 options', $this->plugin_name ),
					'options' => array(
						'WP-Human' => __( "I read the <a href='https://wphuman.com/blog/'>WP Human Blog</a>", $this->plugin_name  ),
						'Tang-Rufus'  => __( "<a href='http://tangrufus.com/'>Tang Rufus' Blog</a> looks great", $this->plugin_name  ),
						'Filter'  => __( 'You can apply filters on this option!', $this->plugin_name  )
						),
					'type' => 'radio'
					),
				'radio_without_options' => array(
					'id' => 'radio_without_options',
					'name' => __( 'Radio', $this->plugin_name ),
					'desc' => __( 'Radio without options', $this->plugin_name ),
					'type' => 'radio'
					),
			'text' => array(
				'id' => 'text',
				'name' => __( 'Text', $this->plugin_name ),
				'desc' => __( 'Text', $this->plugin_name ),
				'type' => 'text'
				),
			'text_with_std' => array(
				'id' => 'text_with_std',
				'name' => __( 'Text with std', $this->plugin_name ),
				'desc' => __( 'Text with std', $this->plugin_name ),
				'std' => __( 'std will be saved!', $this->plugin_name ),
				'type' => 'text'
				),
			'email' => array(
				'id' => 'email',
				'name' => __( 'Email', $this->plugin_name ),
				'desc' => __( 'Email', $this->plugin_name ),
				'type' => 'email'
				),
			'url' => array(
				'id' => 'url',
				'name' => __( 'URL', $this->plugin_name ),
				'desc' => __( 'By default, only http & https are allowed', $this->plugin_name ),
				'type' => 'url'
				),
			'password' => array(
				'id' => 'password',
				'name' => __( 'Password', $this->plugin_name ),
				'desc' => __( 'Password', $this->plugin_name ),
				'type' => 'password'
				),
			'number' => array(
				'id' => 'number',
				'name' => __( 'Number', $this->plugin_name ),
				'desc' => __( 'Number', $this->plugin_name ),
				'type' => 'number'
				),
			'number_with_attributes' => array(
				'id' => 'number_with_attributes',
				'name' => __( 'Number', $this->plugin_name ),
				'desc' => __( 'Max: 1000, Min: 20, Step: 30', $this->plugin_name ),
				'max'  => 1000,
				'min'  => 20,
				'step'  => 30,
				'type' => 'number'
				),
			'textarea' => array(
				'id' => 'textarea',
				'name' => __( 'Textarea', $this->plugin_name ),
				'desc' => __( 'Textarea', $this->plugin_name ),
				'type' => 'textarea'
				),
			'textarea_with_std' => array(
				'id' => 'textarea_with_std',
				'name' => __( 'Textarea with std', $this->plugin_name ),
				'desc' => __( 'Textarea with std', $this->plugin_name ),
				'std' => __( 'std will be saved!', $this->plugin_name ),
				'type' => 'textarea'
				),
			'select' => array(
				'id' => 'select',
				'name' => __( 'Select', $this->plugin_name ),
				'desc' => __( 'Select with 3 options', $this->plugin_name ),
				'options' => array(
					'WP-Human' => __( "I read the <a href='https://wphuman.com/blog/'>WP Human Blog</a>", $this->plugin_name  ),
					'Tang-Rufus'  => __( "<a href='http://tangrufus.com/'>Tang Rufus' Blog</a> looks great", $this->plugin_name  ),
					'Filter'  => __( 'You can apply filters on this option!', $this->plugin_name  )
					),
				'type' => 'select'
				),
			'rich_editor' => array(
				'id' => 'rich_editor',
				'name' => __( 'Rich Editor', $this->plugin_name ),
				'desc' => __( 'Rich Editor save as HTML markups', $this->plugin_name ),
				'type' => 'rich_editor'
				),
				) // end default_tab
			), // end apply_filters
			// second_tab
'second_tab' => apply_filters( $this->snake_cased_plugin_name . '_settings_second_tab',
	array(
		'extend_me' => array(
			'id' => 'extend_me',
			'name' => 'Extend me',
			'desc' => __( 'You can extend me via hooks and filters.', $this->plugin_name ),
			'type' => 'text'
			),
				) // end second_tab
			) // apply_filters
);

return $settings;

	} // end set_registered_settings

}
