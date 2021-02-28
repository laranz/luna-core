<?php
/**
 * A wrapper class for Settings Link in Plugin page.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Base;

/**
 * A wrapper class for Settings Link in Plugin page.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Settings_Link {
	/** Register function. */
	public function register() {
		add_filter( 'plugin_action_links_' . LUNA_BASENAME, array( $this, 'custom_settings_link' ) );
	}

	/**
	 * Adding custom links for our plugin in the Plugins list table
	 *
	 * @param string[] $links | An array of plugin action links.
	 */
	public function custom_settings_link( $links ) {

		$settings_link = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=luna_settings' ) . '" aria-label="' . esc_attr__( 'View Luna Settings', 'luna-core' ) . '">' . esc_html__( 'Settings', 'luna-core' ) . '</a>',
			'addons'   => '<a href="' . admin_url( 'admin.php?page=luna_settings' ) . '" aria-label="' . esc_attr__( 'View Add-ons', 'luna-core' ) . '">' . esc_html__( 'Add-ons', 'luna-core' ) . '</a>',
		);

		return array_merge( $links, $settings_link );

	}
}
