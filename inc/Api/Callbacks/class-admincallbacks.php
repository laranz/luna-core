<?php
/**
 * Contains callback details.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Api\Callbacks;

/**
 * A wrapper class for Callbacks.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class AdminCallbacks {
	/** Callback for admin dashboard. */
	public function admin_dashboard() {
		return require_once LUNA_BASE_PATH . 'templates/admin-template.php';
	}

	/**
	 * Callbacks for options group.
	 *
	 * @param $input | string
	 *
	 * @return mixed
	 */
	public function luna_options_group( $input ) {
		return $input;
	}

	/**
	 * Callbacks for options group.
	 *
	 * @return mixed
	 */
	public function luna_admin_section() {
		return _e( 'Luna Dashboard Settings section description.', 'luna-core' );
	}

	/**
	 * Callbacks for our text example field.
	 *
	 * @return mixed
	 */
	public function luna_first_name() {
		$value = esc_attr( get_option( 'first_name' ) );

		echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="Enter your first name.">';
	}
}
