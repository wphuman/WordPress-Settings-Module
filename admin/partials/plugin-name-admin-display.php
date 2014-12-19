<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the plugin settings page.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */

/**
 * Options Page
 *
 * Renders the settings page contents.
 *
 * @since       1.0.0
*/

$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $this->get_options_tabs() ) ? $_GET[ 'tab' ] : 'default_tab';

ob_start();
?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?> </h2>

	<?php settings_errors( $this->plugin_name . '-notices' ); ?>

	<h2 class="nav-tab-wrapper">
		<?php
		foreach( $this->get_options_tabs() as $tab_id => $tab_name ) {

			$tab_url = add_query_arg( array(
				'settings-updated' => false,
				'tab' => $tab_id
				) );

			$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

			echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
			echo esc_html( $tab_name );
			echo '</a>';
		}
		?>
	</h2>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder">

				<div id="postbox-container" class="postbox-container">

					<?php do_meta_boxes( $this->snake_cased_plugin_name . '_settings_' . $active_tab, 'normal', $active_tab ); ?>

				</div><!-- #postbox-container-->

		</div><!-- #post-body-->

	</div><!-- #poststuff-->
</div><!-- .wrap -->

<?php
echo ob_get_clean();
