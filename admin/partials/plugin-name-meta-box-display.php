<?php
/**
 * Provide a meta box view for the settings page
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */

/**
 * Meta Box
 *
 * Renders a single meta box.
 *
 * @since       1.0.0
*/
?>

<form action="options.php" method="POST">
	<?php settings_fields( $this->snake_cased_plugin_name . '_settings' ); ?>
	<?php do_settings_sections( $this->snake_cased_plugin_name . '_settings_' . $active_tab ); ?>
	<?php submit_button(); ?>
</form>
<br class="clear" />
