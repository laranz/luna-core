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
	/**
	 * Store field settings array.
	 *
	 * @var array
	 */
	public $settings = array();
	/**
	 * Store field section array.
	 *
	 * @var array
	 */
	public $sections = array();
	/**
	 * Store fields array.
	 *
	 * @var array
	 */
	public $fields = array();

	/** Register globally. */
	public function register() {
		if ( ! empty( $this->admin_pages ) || ! empty( $this->admin_subpages ) ) {
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		}
		if ( ! empty( $this->settings ) ) {
			add_action( 'admin_init', array( $this, 'register_custom_fields' ) );
		}
	}

	/**
	 * Function to add admin pages
	 *
	 * @param array $pages | Page list.
	 * @return SettingsApi object for chaining.
	 */
	public function add_pages( array $pages ) {
		$this->admin_pages = $pages;
		return $this;
	}

	/**
	 * Function to add admin sub-pages
	 *
	 * @param array $pages | Page list.
	 *
	 * @return SettingsApi object for chaining.
	 */
	public function add_subpages( array $pages ) {
		$this->admin_subpages = array_merge( $this->admin_subpages, $pages );
		return $this;
	}

	/**
	 * Function to register the admin sub-page.
	 *
	 * @param string $title | Title for the subpage.
	 *
	 * @return SettingsApi object for chaining.
	 */
	public function with_subpage( $title = '' ) {
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

	/**
	 * Function to add settings for Custom fields.
	 *
	 * @param array $settings
	 *
	 * @return SettingsApi object for chaining.
	 */
	public function add_settings( array $settings ) {
		$this->settings = $settings;
		return $this;
	}

	/**
	 * Function to add sections for Custom fields.
	 *
	 * @param array $sections
	 *
	 * @return SettingsApi object for chaining.
	 */
	public function add_sections( array $sections ) {
		$this->sections = $sections;
		return $this;
	}

	/**
	 * Function to add fields for Custom fields.
	 *
	 * @param array $fields
	 *
	 * @return SettingsApi object for chaining.
	 */
	public function add_fields( array $fields ) {
		$this->fields = $fields;
		return $this;
	}

	/**
	 * Register Custom fields.
	 */
	public function register_custom_fields() {

		// Register setting.
		foreach ( $this->settings as $setting ) {
			register_setting(
				$setting['option_group'],
				$setting['option_name'],
				( isset( $setting['callback'] ) ) ? $setting['callback'] : ''
			);
		}

		// Add settings section.
		foreach ( $this->sections as $section ) {
			add_settings_section(
				$section['id'],
				$section['title'],
				( isset( $section['callback'] ) ) ? $section['callback'] : '',
				$section['page']
			);
		}

		// Add settings field.
		foreach ( $this->fields as $field ) {
			add_settings_field(
				$field['id'],
				$field['title'],
				( isset( $field['callback'] ) ) ? $field['callback'] : '',
				$field['page'],
				$field['section'],
				( isset( $field['args'] ) ) ? $field['args'] : ''
			);
		}
	}
}
