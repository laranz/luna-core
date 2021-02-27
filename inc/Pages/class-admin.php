<?php
/**
 * A wrapper class for creating admin pages.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Inc\Pages;

/**
 * A wrapper class for creating admin pages.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Admin {
	/** Register function. */
	public function register() {
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
	}

	/** Adding admin pages. */
	public function add_admin_pages() {
		add_menu_page( 'Luna Settings', 'Luna Settings', 'manage_options', 'luna_settings', array( $this, 'admin_index' ), 'dashicons-store', 4 );
	}

	/** Admin index page. */
	public function admin_index() {
		require_once LUNA_BASE_PATH . '/templates/admin-template.php';
	}
}
