<?php
/**
 * Contains callback details.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Api\Callbacks;

/**
 * A wrapper class for Callbacks.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class AdminCallbacks {
	/** Callback for admin dashboard. */
	public function admin_dashboard() {
		return require_once LUNA_BASE_PATH . 'templates/admin-template.php';
	}
}
