<?php
/**
 * A wrapper class for Custom Templates.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Base;

use Luna\Api\SettingsApi;
use Luna\Api\Callbacks\AdminCallbacks;

/**
 * A wrapper class for Custom Templates.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Custom_Templates extends Base_Controller {

	/**
	 * Storing the SettingsApi instance.
	 *
	 * @var [class instance]
	 */
	public $settings;

	/**
	 * Storing the admin sub-menu page list.
	 *
	 * @var array
	 */
	public $subpages = array();

	/**
	 * Storing the Callbacks instance.
	 *
	 * @var [class instance]
	 */
	public $callbacks;

	/** Register function. */
	public function register() {

		// Check the section is enabled in Dashboard or not.
		if ( $this->deactivated( 'templates_manager' ) ) {
			return;
		}

		$this->settings  = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->set_subpages();
		$this->settings->add_subpages( $this->subpages )->register();
		add_action( 'init', array( $this, 'activate' ) );
	}

	/** A custom function to create the custom templates. */
	public function activate() {

	}

	/**
	 * Settings sub pages.
	 *
	 * @return void
	 */
	public function set_subpages() {
		$this->subpages = array(
			array(
				'parent_slug' => 'luna_settings',
				'page_title'  => __( 'Templates Settings', 'luna-core' ),
				'menu_title'  => __( 'Templates Settings', 'luna-core' ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_templates',
				'callback'    => array( $this->callbacks, 'add_templates_cb' ),
				'position'    => 5,
			),
		);
	}
}
