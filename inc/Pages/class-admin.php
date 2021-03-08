<?php
/**
 * A wrapper class for creating admin pages.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Pages;

use Luna\Api\SettingsApi;
use Luna\Api\Callbacks\AdminCallbacks;

/**
 * A wrapper class for creating admin pages.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Admin {
	/**
	 * Storing the SettingsApi instance.
	 *
	 * @var [class instance]
	 */
	public $settings;

	/**
	 * Storing the Callbacks instance.
	 *
	 * @var [class instance]
	 */
	public $callbacks;


	/**
	 * Storing the admin menu page list.
	 *
	 * @var array
	 */
	public $pages = array();

	/**
	 * Storing the admin sub-menu page list.
	 *
	 * @var array
	 */
	public $subpages = array();

	/** Register function. */
	public function register() {

		$this->settings  = new SettingsApi();
		$this->callbacks = new AdminCallbacks();

		$this->set_pages();
		$this->set_subpages();

		$this->settings->add_pages( $this->pages )->with_subpage( __( 'Dashboard', 'luna-core' ) )->add_subpages( $this->subpages )->register();
	}
	/**
	 * Settings pages.
	 *
	 * @return void
	 */
	public function set_pages() {
		$this->pages = array(
			'Settings Page' => array(
				'page_title' => __( 'Luna Settings', 'luna-core' ),
				'menu_title' => __( 'Luna Settings', 'luna-core' ),
				'capability' => 'manage_options',
				'menu_slug'  => 'luna_settings',
				'callback'   => array( $this->callbacks, 'admin_dashboard' ),
				'icon_url'   => 'dashicons-store',
				'position'   => 4,
			),
		);
	}

	/**
	 * Settings sub pages.
	 *
	 * @return void
	 */
	public function set_subpages() {
		$this->subpages = array(
			'CPT Settings'      => array(
				'parent_slug' => 'luna_settings',
				'page_title'  => __( 'CPT Settings', 'luna-core' ),
				'menu_title'  => __( 'CPT Settings', 'luna-core' ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_settings_cpt',
				'callback'    => function() {
					echo '<h1>CPT Settings</h1>'; },
				'position'    => 1,
			),
			'Taxonomy Settings' => array(
				'parent_slug' => 'luna_settings',
				'page_title'  => __( 'Taxonomy Settings', 'luna-core' ),
				'menu_title'  => __( 'Taxonomy Settings', 'luna-core' ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_settings_taxonomy',
				'callback'    => function() {
					echo '<h1>Taxonomy Settings</h1>'; },
				'position'    => 2,
			),
			'Widgets Settings'  => array(
				'parent_slug' => 'luna_settings',
				'page_title'  => __( 'Widget Settings', 'luna-core' ),
				'menu_title'  => __( 'WIdget Settings', 'luna-core' ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_settings_widgets',
				'callback'    => function() {
					echo '<h1>Widgets Settings</h1>'; },
				'position'    => 3,
			),
		);
	}
}
