<?php
/**
 * A wrapper class for enqueuing scripts and styles.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Inc\Base;

/**
 * A wrapper class for enqueuing scripts and styles.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Enqueue {
	/** Register function. */
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/** Function for enqueuing scripts. */
	public function enqueue() {
		wp_enqueue_style( 'luna-core-css', LUNA_BASE_URL . 'assets/style.css', array(), '0.0.1' );
		wp_enqueue_script( 'luna-core-js', LUNA_BASE_URL . 'assets/script.js', array( 'jquery' ), '0.0.1', false );
	}
}