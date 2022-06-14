<?php
/**
 * Plugin Name: Posts View Count Plus
 * Description: Using a shortcode which will display 10 latest post title with view counts
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
final class Posts_View_Plus {

	/**
	 * Plugin version
	 * 
	 * @var string
	 */
	const version = '1.0';

	/**
	 * Class contruct
	 */	
	private function __construct() {

		$this-> define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		$this->init_plugin();
		
	}
	

    /**
     * Initialize singleton instance
     * 
     * @return \Posts_view_plus
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

		define('CURRENT_POSTS_VIEW_PLUS_VERSION', self::version ); 
		define('CURRENT_POSTS_VIEW_PLUS_FILE', __FILE__ );
		define('CURRENT_POSTS_VIEW_PLUS_PATH', __DIR__ );
		define('CURRENT_POSTS_VIEW_PLUS_URL', plugins_url( '', CURRENT_POSTS_VIEW_PLUS_FILE ) );
	}

	/**
	 * Initialize the plugin
	 * 
	 * @return void
	 */
	public function init_plugin() {
		
		new Riyadh1734\PostsViewPlus\Shortcode();
		new Riyadh1734\PostsViewPlus\Settings();
		require_once( CURRENT_POSTS_VIEW_PLUS_PATH . '/src/Settings.php' );
        require_once( CURRENT_POSTS_VIEW_PLUS_PATH . '/src/Shortcode.php' );
	}

	/**
	 * Do staff plugin activation
	 * 
	 * @return void
	 * 
	 */
	public function activate() {

		$installed = get_option( 'current_posts_view_plus_installed');

		if ( ! $installed ) {
			
			update_option( 'current_posts_view_plus_installed', time() );
		}

		update_option( 'current_posts_view_plus_version', CURRENT_POSTS_VIEW_PLUS_VERSION );
	}
}

/**
 * Iniatialize the main plugin
 * 
 * @return \Posts_view_plus
 */
function posts_view_plus() {

	return posts_view_plus::init();
}

//kick of the plugin
posts_view_plus();