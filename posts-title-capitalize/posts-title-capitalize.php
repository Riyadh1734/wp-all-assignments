<?php
/**
 * Plugin Name: Posts Title Capitalize
 * Description: When a post is published this post title first character will be capitalize
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

//Don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	 exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class posts_title_capitalize {

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

		add_action( 'plugins_loaded', [ $this, 'init_plugin'] );
		
		
	}
	
    /**
     * Initialize singleton instance
     * 
     * @return \
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

		define('CURRENT_POSTS_TITLE_CAPITALIZE_VERSION', self::version ); 
		define('CURRENT_POSTS_TITLE_CAPITALIZE_FILE', __FILE__ );
		define('CURRENT_POSTS_TITLE_CAPITALIZE_PATH', __DIR__ );
		define('CURRENT_POSTS_TITLE_CAPITALIZE_URL', plugins_url( '', CURRENT_POSTS_TITLE_CAPITALIZE_FILE ) );
	}

	/**
	 * Initialize the plugin
	 * 
	 * @return void
	 */
	public function init_plugin() {

		add_filter( 'wp_insert_post_data', [ $this, 'add_cfc_post'] );
		
	}

		/**
	 * Capitalize first character of the post title
	 *
	 * @return void
	 */
	public function add_cfc_post( $data ) {
 
		$cfc_post = ucwords($data ['post_title']);
		$data ['post_title']= $cfc_post;

		return $data;
	}


	/**
	 * Do staff plugin activation
	 * 
	 * @return void
	 * 
	 */
	public function activate() {

		$installed = get_option( 'current_posts_title_installed');

		if ( ! $installed ) {
			
			update_option( 'current_posts_title_installed', time() );
		}

		update_option( 'current_posts_title_version', CURRENT_POSTS_TITLE_CAPITALIZE_VERSION );
	}
}

/**
 * Iniatialize the main plugin
 * 
 * @return \posts_title_capitalize
 */
function posts_title_capitalize() {

	return posts_title_capitalize :: init();
}

//kick of the plugin
posts_title_capitalize();