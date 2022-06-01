<?php
/**
 * Plugin Name: Vertical Button
 * Description: Show a coupon button show in the frontend
 * Plugin URI: http://sajuahmed.epizy.com
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com
 * Version: 1.0
 * License: GPL2
 */

/*
    Copyright (C) Year  Author  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Vertical_Button {

	const version = '1.0';

	
	private function __construct() {

	  $this-> define_constants();

	  register_activation_hook( __FILE__, [ $this , 'activate' ] );

	  add_filter( 'wp_footer', [ $this, 'add_button_fun' ]);
	}

	/**
     * Initialize singleton instance
     * 
     * @return \Vertical_button
     */
	public static function init() {

		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Define the main plugin constants
	 * 
	 * @return void
	 * 
	 */
	public function define_constants() {

		define('CURRENT_VERTICAL_BUTTON_VERSION', self::version ); 
		define('CURRENT_VERTICAL_BUTTON_FILE', __FILE__ );
		define('CURRENT_VERTICAL_BUTTON_PATH', __DIR__ );
		define('CURRENT_VERTICAL_BUTTON_URL', plugins_url( '', CURRENT_VERTICAL_BUTTON_FILE ) );
	}

	/**
	 * Initialize the plugin
	 * 
	 * @return void
	 */
     function add_button_fun() {

		 ob_start();

		 ?>
		    <a class="vertical-butt" href="http://sajuahmed.epizy.com/">
				<div class="img-size">
				<img src=" <?php echo plugins_url('src\image\side-ribbon-tag-img.svg', __FILE__) ?>" alt="Coupon" style="width:42px;height:42px;">	
				</div>
				<span class="coupon-text">COUPONS</span>
			</a>
		 
		<?php
		}


	/**
	 * Do staff plugin activation
	 * 
	 * @return void
	 * 
	 */
	public function activate() {

		$installed = get_option( 'current_vertical_button_installed');

		if ( ! $installed ) {
			
			update_option( 'current_vertical_button_installed', time() );
		}

		update_option( 'current_vertical_button_version', CURRENT_VERTICAL_BUTTON_VERSION );
	}
}

function vertical_button_scripts() {

	wp_enqueue_style( 'button-style', plugins_url('src\css\style.css', __FILE__) );
}
add_action( 'wp_enqueue_scripts', 'vertical_button_scripts' );


/**
 * Iniatialize the main plugin
 * 
 * @return \Vertical_button
 */
function vertical_button() {

	return vertical_button :: init();
}

//kick of the plugin
vertical_button();