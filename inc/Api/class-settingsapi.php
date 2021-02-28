<?php
/**
 * Contains Settings API related functions.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Api;

/**
 * A wrapper class for WordPress Settings API.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class SettingsApi {
	/**
	 * Store pages array list.
	 *
	 * @var array
	 */
	public $admin_pages = array();

	/** Register globally. */
	public function register() {
		if ( ! empty( $this->admin_pages ) ) {
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		}
	}

	/**
	 * Function to add admin pages
	 *
	 * @param array $pages | Page list.
	 * @return $pages
	 */
	public function add_pages( array $pages
	) {
		$this->admin_pages = $pages;
		return $this;
	}

	/**
	 * Finally create the menu page.
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		foreach ( $this->admin_pages as $page ) {
			add_menu_page(
				$page['page_title'],
				$page['menu_title'],
				$page['capability'],
				$page['menu_slug'],
				$page['callback'],
				$page['icon_url'],
				$page['position']
			);
		}
	}
}
