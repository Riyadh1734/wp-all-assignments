<?php
/**
 * Plugin Name: Post Excerpt
 * Description: Add a post excerpt box under the post to input your metadata
 * Plugin URI: http://sajuahmed.epizy.com
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com
 * Version: 1.0
 * License: GPL2
 * Text Domain: text-domain
 * Domain Path: domain/path
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

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class ra_post_excerpt {

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
	 * @return \RA_POST_EXCERPT
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

		define( 'RA_POST_EXCERPT_VERSION', self::version);
		define( 'RA_POST_EXCERPT_FILE', __FILE__ );
		define( 'RA_POST_EXCERPT_PATH', __DIR__ );
		define('RA_POST_EXCERPT_URL', plugins_url( '', RA_POST_EXCERPT_FILE ) );
	}

	/**
	 * initialize plugin
	 */
	public function init_plugin() {

		if (is_admin() ) {
			new Riyadh1734\PostExcerpt\Metabox();
		} else {
			new Riyadh1734\PostExcerpt\Shortcode();
		}

	 }

	/**
	 * Do stuff plugin activation
	 * 
	 * @return void
	 */
	public function activate() {
	  $installed = get_option( 'ra_post_excerpt_installed' );

	  if (! $installed ) {
	  	update_option( 'ra_post_excerpt_installed', time() );
	  }
	  
	  update_option( 'ra_post_excerpt_version', RA_POST_EXCERPT_VERSION );
	}

}

/**
 * Initialize the main plugin
 * 
 * @return \RA_POST_EXCERPT
 */
function ra_post_excerpt()
{
	return ra_post_excerpt::init();
}
//kick-off the plugin
ra_post_excerpt();