<?php
/**
 * A wrapper class for Custom Post Type.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Inc\Base;

/**
 * A wrapper class for Custom Post Type.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Custom_Post {
	/** Register function. */
	public function register() {
		add_action( 'init', array( $this, 'custom_post_type' ) );
	}

	/** A custom function to create the custom post type. */
	public function custom_post_type() {
		$args = array(
			'public'    => true,
			'label'     => __( 'Books', 'luna-core' ),
			'menu_icon' => 'dashicons-book',
		);
		register_post_type( 'book', $args );
		flush_rewrite_rules();
	}
}
