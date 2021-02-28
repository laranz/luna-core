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
	 * Constructor.
	 */
	public function __construct() {
		$this->settings = new SettingsApi();

		$this->pages = array(
			'Settings Page'   => array(
				'page_title' => 'Luna Settings',
				'menu_title' => 'Luna Settings',
				'capability' => 'manage_options',
				'menu_slug'  => 'luna_settings',
				'callback'   => function() {
					echo '<h1>Luna Settings</h1>'; },
				'icon_url'   => 'dashicons-store',
				'position'   => 4,
			),
			'Addons Settings' => array(
				'page_title' => 'Addons Settings',
				'menu_title' => 'Addons Settings',
				'capability' => 'manage_options',
				'menu_slug'  => 'addons_settings',
				'callback'   => function() {
					echo '<h1>Add-ons Settings</h1>'; },
				'icon_url'   => 'dashicons-external',
				'position'   => 4,
			),

		);

	}

	/** Register function. */
	public function register() {

		$this->settings->add_pages( $this->pages )->register();
	}
}
