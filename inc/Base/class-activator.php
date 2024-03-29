<?php
/**
 * Fired during plugin activation.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Base;

/**
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Activator {
	/** A static function which runs after activation */
	public static function activate() {
		flush_rewrite_rules();

				$default = array();

		// Setting default value to our options group on activation.
		// Return if there is already some values present.
		if ( ! get_option( 'luna_settings' ) ) {
			update_option( 'luna_settings', $default );
		}

		if ( ! get_option( 'luna_settings_cpt' ) ) {
			update_option( 'luna_settings_cpt', $default );
		}

	}
}
