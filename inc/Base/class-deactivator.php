<?php
/**
 * Fired during plugin deactivation
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Base;

/**
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Deactivator {
	/** A static function which runs after deactivation */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}
