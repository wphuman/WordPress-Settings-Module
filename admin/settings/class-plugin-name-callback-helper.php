<?php

/**
 * Plugin_Name Callback Helper Class
 *
 * The callback functions of the settings page
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/settings
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Callback_Helper {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	}

	private function get_id_attribute( $id ) {
		return ' id="plugin_name_settings[' . $id . ']" ';
	}

	private function get_name_attribute( $name ) {
		return ' name="plugin_name_settings[' . $name . ']" ';
	}

	private function get_id_and_name_attrubutes( $field_key ) {
		return  $this->get_id_attribute( $field_key ) . $this->get_name_attribute( $field_key );
	}

	private function get_label_for( $id, $desc ) {
		return '<label for="plugin_name_settings[' . $id . ']"> '  . $desc . '</label>';
	}

	/**
	 * Missing Callback
	 *
	 * If a function is missing for settings callbacks alert the user.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function missing_callback( $args ) {
		printf( __( 'The callback function used for <strong>%s</strong> setting is missing.', $this->plugin_name ), $args['id'] );
	}

	/**
	 * Header Callback
	 *
	 * Renders the header.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function header_callback( $args ) {
		echo '<hr/>';
	}

	/**
	 * Checkbox Callback
	 *
	 * Renders checkboxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function checkbox_callback( $args ) {

		$value = Plugin_Name_Option::get_option( $args['id'] );
		$checked = isset( $value ) ? checked( 1, $value, false ) : '';

		$html = '<input type="checkbox" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'value="1" ' . $checked . '/>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Multicheck Callback
	 *
	 * Renders multiple checkboxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function multicheck_callback( $args ) {

		if ( empty( $args['options'] ) ) {
			printf( __( 'Options for <strong>%s</strong> multicheck is missing.', $this->plugin_name ), $args['id'] );
			return;
		}

		$old_values = Plugin_Name_Option::get_option( $args['id'], array() );

		$html ='';

		foreach( $args['options'] as $field_key => $option ) {

			if( isset( $old_values[$field_key] ) ) {
				$enabled = $option;
			} else {
				$enabled = NULL;
			}

			$checked = checked( $option, $enabled, false );

			$html .= '<input type="checkbox" ';
			$html .= $this->get_id_and_name_attrubutes( $args['id'] . '][' . $field_key );
			$html .= ' value="' . $option . '" ' . $checked . '/> ';

			$html .= $this->get_label_for( $args['id'] . '][' . $field_key, $option );
			$html .= '<br/>';
		}

		$html .= '<p class="description">' . $args['desc'] . '</p>';

		echo $html;
	}

	/**
	 * Radio Callback
	 *
	 * Renders radio boxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function radio_callback( $args ) {

		if ( empty( $args['options'] ) ) {
			printf( __( 'Options for <strong>%s</strong> radio is missing.', $this->plugin_name ), $args['id'] );
			return;
		}

		$old_value = Plugin_Name_Option::get_option( $args['id'] );

		$html = '';

		foreach ( $args['options'] as $field_key => $option ) {

			if ( !empty( $old_value ) ) {
				$checked = checked( $field_key, $old_value,false );
			} else {
				$checked = checked( $args['std'], $field_key, false );
			}

			$html .= '<input type="radio"';
			$html .= $this->get_name_attribute( $args['id'] );
			$html .= $this->get_id_attribute( $args['id'] . '][' . $field_key );
			$html .= ' value="' . $field_key . '" ' . $checked . '/> ';

			$html .= $this->get_label_for( $args['id'] . '][' . $field_key, $option );
			$html .= '<br/>';

		}

		$html .= '<p class="description">' . $args['desc'] . '</p>';
		echo $html;
	}

	/**
	 * Text Callback
	 *
	 * Renders text fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function text_callback( $args ) {

		$this->input_type_callback( 'text', $args );

	}

	/**
	 * Email Callback
	 *
	 * Renders email fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function email_callback( $args ) {

		$this->input_type_callback( 'email', $args );

	}

	/**
	 * Url Callback
	 *
	 * Renders url fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function url_callback( $args ) {

		$this->input_type_callback( 'url', $args );

	}

	/**
	 * Password Callback
	 *
	 * Renders password fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function password_callback( $args ) {

		$this->input_type_callback( 'password', $args );

	}

	/**
	 * Input Type Callback
	 *
	 * Renders input type fields.
	 *
	 * @since 	1.0.0
	 * @param 	string $type Input Type
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	private function input_type_callback( $type, $args ) {

		$value = Plugin_Name_Option::get_option( $args['id'], $args['std']  );

		$html = '<input type="' . $type . '" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'class="' . $args['size'] . '-text" ';
		$html .= 'value="' . esc_attr( stripslashes( $value ) ) . '"/>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Number Callback
	 *
	 * Renders number fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function number_callback( $args ) {

		$value = Plugin_Name_Option::get_option( $args['id'] );


		$html = '<input type="number" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'class="' . $args['size'] . '-text" ';
		$html .= 'step="' . $args['step'] . '" ';
		$html .= 'max="' . $args['max'] . '" ';
		$html .= 'min="' . $args['min'] . '" ';
		$html .= 'value="' . $value . '"/>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Textarea Callback
	 *
	 * Renders textarea fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function textarea_callback( $args ) {

		$value = Plugin_Name_Option::get_option( $args['id'], $args['std']  );


		$html = '<textarea ';
		$html .= 'class="' . $args['size'] . '-text" ';
		$html .= 'cols="50" rows="5" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] ) . '>';
		$html .= esc_textarea( stripslashes( $value ) );
		$html .= '</textarea>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Select Callback
	 *
	 * Renders select fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function select_callback( $args ) {

		$value = Plugin_Name_Option::get_option( $args['id'] );

		$html = '<select ' . $this->get_id_and_name_attrubutes( $args['id'] ) . '/>';

			foreach ( $args['options'] as $option => $option_name ) {
				$selected = selected( $option, $value, false );
				$html .= '<option value="' . $option . '" ' . $selected . '>' . $option_name . '</option>';
			}

		$html .= '</select>';
		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Rich Editor Callback
	 *
	 * Renders rich editor fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$wp_version WordPress Version
	 */
	public function rich_editor_callback( $args ) {
		global $wp_version;

		$value = Plugin_Name_Option::get_option( $args['id'] );

		if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
			ob_start();
			wp_editor( stripslashes( $value ), 'plugin_name_settings_' . $args['id'], array( 'textarea_name' => 'plugin_name_settings[' . $args['id'] . ']' ) );
			$html = ob_get_clean();
		} else {
			$html = '<textarea' . $this->get_id_and_name_attrubutes( $args['id'] ) . 'class="' . $args['size'] . '-text" rows="10" >' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		}

		$html .= '<br/>';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );
		$html .= '<br/>';

		echo $html;
	}

	/**
	 * Upload Callback
	 *
	 * Renders upload fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function upload_callback( $args ) {


		$html = '<input type="text" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'class="' . $args['size'] . '-text ' . 'plugin_name_upload_field" ';
		$html .= ' value="' . esc_attr( stripslashes( $value ) ) . '"/>';

		$html .= '<span>&nbsp;<input type="button" class="' .  'plugin_name_settings_upload_button button-secondary" value="' . __( 'Upload File', $this->plugin_name ) . '"/></span>';

		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}
}
