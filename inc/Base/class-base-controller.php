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
	 * Store all the managers like CPT, Taxonomy, etc.,
	 *
	 * @var string
	 */
	public $managers;

	/** Constructor to store all the global variables. */
	public function __construct() {

		$this->managers = array(
			'cpt_manager'          => __( 'Activate CPT Manager', 'luna_core' ),
			'taxonomy_manager'     => __( 'Activate Taxonomy Manager', 'luna_core' ),
			'media_widget_manager' => __( 'Activate Media Widget Manager', 'luna_core' ),
			'gallery_manager'      => __( 'Activate Gallery Manager', 'luna_core' ),
			'testimonial_manager'  => __( 'Activate Testimonials Manager', 'luna_core' ),
			'templates_manager'    => __( 'Activate Templates Manager', 'luna_core' ),
			'login_manager'        => __( 'Activate Login Manager', 'luna_core' ),
			'membership_manager'   => __( 'Activate Membership Manager', 'luna_core' ),
			'chat_manager'         => __( 'Activate Chat Manager', 'luna_core' ),
		);
	}
}
