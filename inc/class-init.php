<?php
/**
 * The file that defines the core plugin class
 *
 * @package         Luna_Core
 * @author          laranz
 * @link            https://laranz.in
 * @since           0.1.0
 */

namespace Luna;

/**
 * The core plugin class.
 *
 * @package         Luna_Core
 * @author          laranz
 * @since           0.1.0
 */
final class Init {

	/**
	 * Store all the needed classes in an array
	 *
	 * @return array | full list of classes.
	 */
	public static function get_services() {
		$classlist = array(
			Pages\Admin::class,
			Base\Enqueue::class,
			Base\Settings_Link::class,
			Base\Custom_Post::class,
		);
		return $classlist;
	}

	/**
	 * Get class list, and initiate them if it has "register" function
	 */
	public static function register_services() {
		foreach ( self::get_services() as $class ) {
			$service = self::initiate_class( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * Initiate all the classes that passed in here.
	 *
	 * @param class $class | class from services array.
	 * @return class | new instance of the class.
	 */
	private static function initiate_class( $class ) {
		return new $class();
	}
}
