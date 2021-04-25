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
		return require_once LUNA_BASE_PATH . 'templates/dashboard-template.php';
	}

	/** Callback for CPT dashboard. */
	public function add_cpt_cb() {
		return require_once LUNA_BASE_PATH . 'templates/cpt-template.php';
	}

	/** Callback for Taxonomy dashboard. */
	public function add_taxonomy_cb() {
		return require_once LUNA_BASE_PATH . 'templates/taxonomy-template.php';
	}

	/** Callback for Taxonomy dashboard. */
	public function add_media_widget_cb() {
		return require_once LUNA_BASE_PATH . 'templates/widget-template.php';
	}

	/** Callback for Taxonomy dashboard. */
	public function add_testimonials_cb() {
		echo '<h1>Testimonial Manager</h1>';
	}

	/** Callback for Taxonomy dashboard. */
	public function add_templates_cb() {
		echo '<h1>Templates Manager</h1>';
	}

	/** Callback for Taxonomy dashboard. */
	public function add_login_cb() {
		echo '<h1>Login Manager</h1>';
	}
}
