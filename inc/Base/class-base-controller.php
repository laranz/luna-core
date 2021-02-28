<?php
/**
 * Contains all the plugin's constants.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Base;

/**
 * A wrapper class for constants.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Base_Controller {
	/**
	 * Plugin Path variable
	 *
	 * @var string
	 */
	public $plugin_path;

	/** Constructor to store all the global variables. */
	public function __construct() {
		$this->plugin_path = plugin_dir_path(
			dirname( __FILE__, 2 )
		);
	}
}
