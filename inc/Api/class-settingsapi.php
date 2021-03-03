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

	/**
	 * Store subpage array.
	 *
	 * @var array
	 */
	public $admin_subpages = array();

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
	public function add_pages( array $pages ) {
		$this->admin_pages = $pages;
		return $this;
	}

	/**
	 * Function to add admin sub-pages
	 *
	 * @param array $pages | Page list.
	 * @return $pages
	 */
	public function add_subpages( array $pages ) {
		$this->admin_subpages = array_merge( $this->admin_subpages, $pages );
		return $this;
	}

	/**
	 * Function to register the admin sub-page.
	 *
	 * @param string $title | Title for the subpage.
	 * @return $pages
	 */
	public function with_subpage( string $title = '' ) {
		if ( empty( $this->admin_pages ) ) {
			return $this;
		}
		// Get the first element from the list of admin pages.
		$admin_page           = current( $this->admin_pages );
		$subpage              = array(
			array(
				'parent_slug' => $admin_page['menu_slug'],
				'page_title'  => $admin_page['page_title'],
				'menu_title'  => ( $title ) ? $title : $admin_page['menu_title'],
				'capability'  => $admin_page['capability'],
				'menu_slug'   => $admin_page['menu_slug'],
				'callback'    => $admin_page['callback'],
				'position'    => 1,
			),
		);
		$this->admin_subpages = $subpage;
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
		foreach ( $this->admin_subpages as $page ) {
			add_submenu_page(
				$page['parent_slug'],
				$page['page_title'],
				$page['menu_title'],
				$page['capability'],
				$page['menu_slug'],
				$page['callback'],
				$page['position']
			);
		}
	}
}
