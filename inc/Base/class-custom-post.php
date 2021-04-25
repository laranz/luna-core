<?php
/**
 * A wrapper class for Custom Post Type.
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna\Base;

use Luna\Api\SettingsApi;
use Luna\Api\Callbacks\CPTCallbacks;
use Luna\Api\Callbacks\AdminCallbacks;

/**
 * A wrapper class for Custom Post Type.
 *
 * @since           0.1.0
 * @package         Luna_Core
 * @author          laranz
 */
class Custom_Post extends Base_Controller {

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
	 * Storing the Admin Callbacks instance.
	 *
	 * @var [class instance]
	 */
	public $admin_callbacks;

	/**
	 * Storing the CPT Callback class's instance.
	 *
	 * @var [class instance]
	 */
	public $cpt_callbacks;

	/**
	 * Storing list of post types.
	 *
	 * @var array List of Post types.
	 */
	public $custom_post_types = array();

	/** Register function. */
	public function register() {

		// Check the section is enabled in Dashboard or not.
		if ( $this->deactivated( 'cpt_manager' ) ) {
			return;
		}

		$this->settings        = new SettingsApi();
		$this->admin_callbacks = new AdminCallbacks();
		$this->cpt_callbacks   = new CPTCallbacks();
		$this->set_subpages();

		$this->set_settings();
		$this->set_sections();
		$this->set_fields();

		$this->settings->add_subpages( $this->subpages )->register();
		$this->define_post_types();

		// Create post types if only present.
		if ( ! empty( $this->custom_post_types ) ) {
			add_action( 'init', array( $this, 'register_custom_post_types' ) );
		}
	}

	/** A custom function to create the custom post type. */
	public function register_custom_post_types() {

		foreach ( $this->custom_post_types as $post_type ) {
			$args = array(
				'labels'              => array(
					'name'                  => $post_type['name'],
					'singular_name'         => $post_type['singular_name'],
					'menu_name'             => $post_type['menu_name'],
					'name_admin_bar'        => $post_type['name_admin_bar'],
					'archives'              => $post_type['archives'],
					'attributes'            => $post_type['attributes'],
					'parent_item_colon'     => $post_type['parent_item_colon'],
					'all_items'             => $post_type['all_items'],
					'add_new_item'          => $post_type['add_new_item'],
					'add_new'               => $post_type['add_new'],
					'new_item'              => $post_type['new_item'],
					'edit_item'             => $post_type['edit_item'],
					'update_item'           => $post_type['update_item'],
					'view_item'             => $post_type['view_item'],
					'view_items'            => $post_type['view_items'],
					'search_items'          => $post_type['search_items'],
					'not_found'             => $post_type['not_found'],
					'not_found_in_trash'    => $post_type['not_found_in_trash'],
					'featured_image'        => $post_type['featured_image'],
					'set_featured_image'    => $post_type['set_featured_image'],
					'remove_featured_image' => $post_type['remove_featured_image'],
					'use_featured_image'    => $post_type['use_featured_image'],
					'insert_into_item'      => $post_type['insert_into_item'],
					'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
					'items_list'            => $post_type['items_list'],
					'items_list_navigation' => $post_type['items_list_navigation'],
					'filter_items_list'     => $post_type['filter_items_list'],
				),
				'label'               => $post_type['label'],
				'description'         => $post_type['description'],
				'supports'            => $post_type['supports'],
				'taxonomies'          => $post_type['taxonomies'],
				'hierarchical'        => $post_type['hierarchical'],
				'public'              => $post_type['public'],
				'show_ui'             => $post_type['show_ui'],
				'show_in_menu'        => $post_type['show_in_menu'],
				'menu_position'       => $post_type['menu_position'],
				'show_in_admin_bar'   => $post_type['show_in_admin_bar'],
				'show_in_nav_menus'   => $post_type['show_in_nav_menus'],
				'can_export'          => $post_type['can_export'],
				'has_archive'         => $post_type['has_archive'],
				'exclude_from_search' => $post_type['exclude_from_search'],
				'publicly_queryable'  => $post_type['publicly_queryable'],
				'capability_type'     => $post_type['capability_type'],
			);
			register_post_type( $post_type['post_type'], $args );
		}
		flush_rewrite_rules();
	}

	/**
	 * Define the post types we need.
	 */
	public function define_post_types() {

		$post_types = get_option( 'luna_settings_cpt', array() );

		// If there is no value, save the energy and return.
		if ( empty( $post_types ) ) {
			return;
		}

		foreach ( $post_types as $post_type ) {
			$this->custom_post_types[] = array(
				'post_type'             => $post_type['post_type'],
				'name'                  => $post_type['plural_name'],
				'singular_name'         => $post_type['singular_name'],
				'menu_name'             => $post_type['plural_name'],
				'name_admin_bar'        => $post_type['singular_name'],
				'archives'              => $post_type['singular_name'] . ' Archives',
				'attributes'            => $post_type['singular_name'] . ' Attributes',
				'parent_item_colon'     => 'Parent ' . $post_type['singular_name'],
				'all_items'             => 'All ' . $post_type['plural_name'],
				'add_new_item'          => 'Add New ' . $post_type['singular_name'],
				'add_new'               => 'Add New',
				'new_item'              => 'New ' . $post_type['singular_name'],
				'edit_item'             => 'Edit ' . $post_type['singular_name'],
				'update_item'           => 'Update ' . $post_type['singular_name'],
				'view_item'             => 'View ' . $post_type['singular_name'],
				'view_items'            => 'View ' . $post_type['plural_name'],
				'search_items'          => 'Search ' . $post_type['plural_name'],
				'not_found'             => 'No ' . $post_type['singular_name'] . ' Found',
				'not_found_in_trash'    => 'No ' . $post_type['singular_name'] . ' Found in Trash',
				'featured_image'        => __( 'Featured Images', 'luna-core' ),
				'set_featured_image'    => __( 'Set Featured Images', 'luna-core' ),
				'remove_featured_image' => __( 'Remove Featured Images', 'luna-core' ),
				'use_featured_image'    => __( 'Use Featured Images', 'luna-core' ),
				'insert_into_item'      => 'Insert into ' . $post_type['singular_name'],
				'uploaded_to_this_item' => 'Upload to this ' . $post_type['singular_name'],
				'items_list'            => $post_type['plural_name'] . ' List',
				'items_list_navigation' => $post_type['plural_name'] . ' List Navigation',
				'filter_items_list'     => 'Filter' . $post_type['plural_name'] . ' List',
				'label'                 => $post_type['singular_name'],
				'description'           => $post_type['plural_name'] . 'Custom Post Type',
				'supports'              => array( 'title', 'editor', 'thumbnail' ),
				'show_in_rest'          => true,
				'taxonomies'            => array( 'category', 'post_tag' ),
				'hierarchical'          => false,
				'public'                => isset( $post_type['public'] ),
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => isset( $post_type['has_archive'] ),
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post',
			);
		}

	}

	/**
	 * Settings sub pages.
	 *
	 * @return void
	 */
	public function set_subpages() {
		$this->subpages = array(
			'CPT Settings' => array(
				'parent_slug' => 'luna_settings',
				'page_title'  => __( 'CPT Settings', 'luna-core' ),
				'menu_title'  => __( 'CPT Settings', 'luna-core' ),
				'capability'  => 'manage_options',
				'menu_slug'   => 'luna_cpt',
				'callback'    => array( $this->admin_callbacks, 'add_cpt_cb' ),
				'position'    => 1,
			),
		);
	}

	/**
	 * Create a setting field in DB for Custom fields.
	 */
	public function set_settings() {

		$args = array(
			array(
				'option_group' => 'core_settings_cpt',
				'option_name'  => 'luna_settings_cpt',
				'callback'     => array( $this->cpt_callbacks, 'cpt_sanitize' ),
			),
		);

		$this->settings->add_settings( $args );
	}


	/**
	 * Set sections for Custom fields.
	 */
	public function set_sections() {
		$args = array(
			array(
				'id'       => 'admin_cpt_index',
				'title'    => __( 'CPT Manager', 'luna-core' ),
				'callback' => array( $this->cpt_callbacks, 'cpt_section' ),
				'page'     => 'luna_cpt',
			),
		);

		$this->settings->add_sections( $args );
	}

	/**
	 * Set fields for Custom fields.
	 */
	public function set_fields() {

		$args = array(
			array(
				'id'       => 'post_type',
				'title'    => __( 'Custom Post Type:', 'luna-core' ),
				'callback' => array( $this->cpt_callbacks, 'luna_text_field' ),
				'page'     => 'luna_cpt',
				'section'  => 'admin_cpt_index',
				'args'     => array(
					'option_name' => 'luna_settings_cpt',
					'label_for'   => 'post_type',
					'placeholder' => 'eg. book',
				),
			),
			array(
				'id'       => 'singular_name',
				'title'    => __( 'Singular Name:', 'luna-core' ),
				'callback' => array( $this->cpt_callbacks, 'luna_text_field' ),
				'page'     => 'luna_cpt',
				'section'  => 'admin_cpt_index',
				'args'     => array(
					'option_name' => 'luna_settings_cpt',
					'label_for'   => 'singular_name',
					'placeholder' => 'eg. Book',
				),
			),
			array(
				'id'       => 'plural_name',
				'title'    => __( 'Plural Name:', 'luna-core' ),
				'callback' => array( $this->cpt_callbacks, 'luna_text_field' ),
				'page'     => 'luna_cpt',
				'section'  => 'admin_cpt_index',
				'args'     => array(
					'option_name' => 'luna_settings_cpt',
					'label_for'   => 'plural_name',
					'placeholder' => 'eg. Books',
				),
			),
			array(
				'id'       => 'public',
				'title'    => __( 'Is Public?', 'luna-core' ),
				'callback' => array( $this->cpt_callbacks, 'luna_checkbox' ),
				'page'     => 'luna_cpt',
				'section'  => 'admin_cpt_index',
				'args'     => array(
					'option_name' => 'luna_settings_cpt',
					'label_for'   => 'public',
					'class'       => 'ui-toggle',
				),
			),
			array(
				'id'       => 'has_archive',
				'title'    => __( 'Has archive?', 'luna-core' ),
				'callback' => array( $this->cpt_callbacks, 'luna_checkbox' ),
				'page'     => 'luna_cpt',
				'section'  => 'admin_cpt_index',
				'args'     => array(
					'option_name' => 'luna_settings_cpt',
					'label_for'   => 'has_archive',
					'class'       => 'ui-toggle',
				),
			),
		);

		$this->settings->add_fields( $args );
	}
}
