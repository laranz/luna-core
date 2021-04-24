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

use Luna\Base\Base_Controller;

/**
 * A wrapper class for Callbacks Manager.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class ManagerCallbacks extends Base_Controller {

	/**
	 * Sanitization callback for checkbox.
	 *
	 * @param string $input | Getting the value for Sanitize.
	 *
	 * @return array
	 */
	public function luna_checkbox_sanitize( $input ) {
		$output = array();
		foreach ( $this->managers as $id => $title ) {
			$output[ $id ] = isset( $input[ $id ] );
		}
		return $output;
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
	 * Displaying our Checkbox here.
	 *
	 * @param array $args | array of options for checkbox.
	 */
	public function luna_checkbox( $args ) {

		$field       = $args['label_for'];
		$classes     = $args['class'];
		$option_name = $args['option_name'];

		$checkbox = get_option( $option_name );
		$name     = $option_name . '[' . $field . ']';
		$checked  = ( $checkbox[ $field ] ? 'checked' : '' );

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $field . '" name="' . $name . '" value="1" class=" ' . $classes . ' " ' . $checked . '><label for="' . $field . '"><div></div></label></div>';
	}
}
