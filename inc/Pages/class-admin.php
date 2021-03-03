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

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->settings = new SettingsApi();

		$this->pages = array(
			'Settings Page' => array(
				'page_title' => 'Luna Settings',
				'menu_title' => 'Luna Settings',
				'capability' => 'manage_options',
				'menu_slug'  => 'luna_settings',
				'callback'   => function() {
					echo '<h1>Luna Settings</h1>'; },
				'icon_url'   => 'dashicons-store',
				'position'   => 4,
			),
		);

		$this->subpages = array(
			'CPT Settings'      => array(
				'parent_slug' => 'luna_settings',
				'page_title'  => 'CPT Settings',
				'menu_title'  => 'CPT Settings',
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_settings_cpt',
				'callback'    => function() {
					echo '<h1>CPT Settings</h1>'; },
				'position'    => 1,
			),
			'Taxonomy Settings' => array(
				'parent_slug' => 'luna_settings',
				'page_title'  => 'Taxonomy Settings',
				'menu_title'  => 'Taxonomy Settings',
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_settings_taxonomy',
				'callback'    => function() {
					echo '<h1>Taxonomy Settings</h1>'; },
				'position'    => 2,
			),
			'Widgets Settings'  => array(
				'parent_slug' => 'luna_settings',
				'page_title'  => 'Widgets Settings',
				'menu_title'  => 'Widgets Settings',
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_settings_widgets',
				'callback'    => function() {
					echo '<h1>Widgets Settings</h1>'; },
				'position'    => 3,
			),
		);
	}

	/** Register function. */
	public function register() {
		$this->settings->add_pages( $this->pages )->with_subpage( 'Dashboard' )->add_subpages( $this->subpages )->register();
	}
}
