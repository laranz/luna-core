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
use Luna\Api\Callbacks\ManagerCallbacks;
use Luna\Base\Base_Controller;

/**
 * A wrapper class for creating admin pages.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Admin extends Base_Controller {
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
	 * Storing the ManagerCallbacks class's instance.
	 *
	 * @var [class instance]
	 */
	public $manager_callbacks;


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

		$this->settings          = new SettingsApi();
		$this->callbacks         = new AdminCallbacks();
		$this->manager_callbacks = new ManagerCallbacks();

		$this->set_pages();
		$this->set_subpages();

		$this->set_settings();
		$this->set_sections();
		$this->set_fields();

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
				'menu_title'  => __( 'Widget Settings', 'luna-core' ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_settings_widgets',
				'callback'    => function() {
					echo '<h1>Widgets Settings</h1>'; },
				'position'    => 3,
			),
		);
	}

	/**
	 * Create a setting field in DB for Custom fields.
	 */
	public function set_settings() {

		$args = array(
			array(
				'option_group' => 'core_settings',
				'option_name'  => 'luna_settings',
				'callback'     => array( $this->manager_callbacks, 'luna_checkbox_sanitize' ),
			),
		);

		$this->settings->add_settings( $args );
	}

	/**
	 * Set sections for Custom fields.
	 */
	public function set_sections() {
		$args = array(
			array(
				'id'       => 'admin_index',
				'title'    => __( 'Settings Manager', 'luna-core' ),
				'callback' => array( $this->manager_callbacks, 'admin_section_manager' ),
				'page'     => 'luna_settings',
			),
		);

		$this->settings->add_sections( $args );
	}

	/**
	 * Set fields for Custom fields.
	 */
	public function set_fields() {

		$args = array();

		foreach ( $this->managers as $id => $title ) {
			$args[] = array(
				'id'       => $id,
				'title'    => $title,
				'callback' => array( $this->manager_callbacks, 'luna_checkbox' ),
				'page'     => 'luna_settings',
				'section'  => 'admin_index',
				'args'     => array(
					'option_name' => 'luna_settings',
					'label_for'   => $id,
					'class'       => 'ui-toggle',
				),
			);
		}

		$this->settings->add_fields( $args );
	}
}
