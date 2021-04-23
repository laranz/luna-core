<?php
/**
 * Contains callback details for Manager.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Api\Callbacks;

/**
 * A wrapper class for Callbacks Manager.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class ManagerCallbacks {

	/**
	 * Callback for checkbox.
	 *
	 * @param $input Inputs
	 *
	 * @return bool
	 */
	public function luna_checkbox_sanitize( $input ) {
		return isset( $input );
	}

	/**
	 * Callbacks for options group.
	 *
	 * @return String
	 */
	public function admin_section_manager() {
		return esc_html_e( 'Manage the sections and Features of this plugin by activating the checkboxes from the following list.', 'luna-core' );
	}

	/**
	 * Callbacks for our text example field.
	 *
	 * @return void
	 */
	public function luna_checkbox( $args ) {

		$name     = $args['label_for'];
		$classes  = $args['class'];
		$checkbox = esc_attr( get_option( $name ) );

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $name . '" value="1" class=" ' . $classes . ' " ' . ( $checkbox ? 'checked' : '' ) . '><label for="' . $name . '"><div></div></label></div>';
	}
}
