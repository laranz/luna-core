<?php
/**
 * Contains callback details for Custom Post Type APIs.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Api\Callbacks;

/**
 * A wrapper class for Callbacks for our CPT.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class CPTCallbacks {

	/**
	 * Just a section message for CPT.
	 */
	public function cpt_section() {
		echo 'Create some Custom Post Types here.';
	}

	/**
	 * Sanitization callback for CPT Section.
	 *
	 * @param string $input | Getting the value for Sanitize.
	 *
	 * @return array
	 */
	public function cpt_sanitize( $entered_value ) {

		// Get the value already stored on DB.
		$current_data = get_option( 'luna_settings_cpt', array() );

		if ( empty( $current_data ) ) {
			$current_data[ $entered_value['post_type'] ] = $entered_value;
			return $current_data;
		}

		foreach ( $current_data as $key => $value ) {
			// If the Entered value is already in the Database update it.
			if ( $key === $entered_value['post_type'] ) {
				$current_data[ $key ] = $entered_value;
			} else {
				// If this a new value, create a new array and store.
				$current_data[ $entered_value['post_type'] ] = $entered_value;
			}
		}

		return $current_data;
	}

	/**
	 * Displaying our Text Field.
	 *
	 * @param array $args | array of options for Textbox.
	 */
	public function luna_text_field( $args ) {

		$field       = $args['label_for'];
		$option_name = $args['option_name'];
		$placeholder = $args['placeholder'];
		$name        = $option_name . '[' . $field . ']';

		$input = get_option( $option_name );
		// Make the Checkbox check, if the value in DB is true.
		$value = '';
		if ( isset( $input[ $field ] ) ) {
			$value = $input[ $field ];
		}

		echo '<input type="text" class="regular-text" id="' . $field . '" name="' . $name . '" value="' . $value . '" placeholder="' . $placeholder . '" required>';
	}

	/**
	 * Displaying our Text Field.
	 *
	 * @param array $args | array of options for Textbox.
	 */
	public function luna_checkbox( $args ) {

		$field       = $args['label_for'];
		$classes     = $args['class'];
		$option_name = $args['option_name'];

		$checkbox = get_option( $option_name );
		$name     = $option_name . '[' . $field . ']';

		// Make the Checkbox check, if the value in DB is true.
		$checked = '';
		if ( isset( $checkbox[ $field ] ) ) {
			if ( $checkbox[ $field ] ) {
				$checked = 'checked';
			}
		}

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $field . '" name="' . $name . '" value="1" class=" ' . $classes . ' " ' . $checked . '><label for="' . $field . '"><div></div></label></div>';
	}
}
