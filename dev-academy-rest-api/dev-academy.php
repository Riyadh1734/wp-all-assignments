<?php
/**
 * Plugin Name: Dev Academy
 * Description: A tutorial for Dev Academy
 * Plugin URI: http://www.sajuahmed.epizy.com
 * Author: Riyadh Ahmed
 * Author URI: http://www.sajuahmed.epizy.com
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: text-domain
 * Domain Path: domain/path
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Include the composer autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    wp_die( 'Composer auto-loader missing. Run "composer update" command.' );
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Dev_Academy {

	/**
	 * plugin version
	 */
	const version = '1.0';
	/**
	 * class constructor
	 */

	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate'] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Initialize a singleton instance
	 * 
	 * @return \Dev_Academy
	 */

	public static function init() {
		static $instance = false;

		if (! $instance ) {
		  $instance = new self();
		}

		return $instance;
	}

    /**
     * Define the required plugin constants
     */
	public function define_constants() {
		define( 'DV_ACADEMY_VERSION', self::version);
		define( 'DV_ACADEMY_FILE', __FILE__ );
		define( 'DV_ACADEMY_PATH', __DIR__ );
		define('DV_ACADEMY_URL', plugins_url( '', DV_ACADEMY_FILE ) );
		define( 'DV_ACADEMY_ASSETS', DV_ACADEMY_URL . '/assets' );
	}

	/**
	 * initialize plugin
	 */
	public function init_plugin() {
		if (is_admin() ) {
			new Riyadh1734\DevAcademy\Admin();
		} else {
			new Riyadh1734\DevAcademy\Frontend();
		}

		new \Riyadh1734\DevAcademy\API();
	}

	/**
	 * Do stuff plugin activation
	 * 
	 * @return void
	 */
	public function activate() {
	  $installer = new \Riyadh1734\DevAcademy\Installer();
	  $installer-> run();
	}

}

/**
 * Initialize the main plugin
 * 
 * @return \Dev_Academy
 */
function dev_academy() {
	return dev_academy::init();
}
//kick-off the plugin
dev_academy();
