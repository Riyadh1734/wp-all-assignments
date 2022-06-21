<?php
/**
 * Plugin Name: Posts Email Notification Plus
 * Description: When a post is published multiple user can get an email notification
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

/**
 * Include the autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    wp_die( 'Composer auto-loader missing. Run "composer update" command on this plugin.' );
}
require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class posts_email_notifi_plus {

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
        add_action( 'transition_post_status', [ $this, 'get_admin_publish_notice'], 10, 3 );
		add_filter( 'add_mu_notifi_send', [ $this,'add_mu_notifi_text' ], 10, 1 );
		
		
	}

	/**
	 * Post publish notify send to multiple users
	 *
	 * @return void
	 */
	public function add_mu_notifi_text( $email ) {

		$to = array(
			'asadbhai@gmail.com',
			'nadimbhai@gmail.com',
			'aunshonbhai@gmail.com'
		);
        array_push( $to, $email);
		return $to;
	}

    public function get_admin_publish_notice( $new_status, $old_status, $post) {

        if( 'publish' === $new_status && 'publish' !== $old_status) {

            $post_title = $post-> post_title;
            $to         = get_option( 'admin_email' );
            $subject    = 'A new post is published';
            $message    = $post_title;

			$mu_email = apply_filters( 'add_mu_notifi_send', $to);
			
            wp_mail( $mu_email, $subject, $message );
        }
    }
	
    /**
     * Initialize singleton instance
     * 
     * @return \posts_email_notifi_plus
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

		define('CURRENT_POSTS_EMAIL_NOTIFI_PLUS_VERSION', self::version ); 
		define('CURRENT_POSTS_EMAIL_NOTIFI_PLUS_FILE', __FILE__ );
		define('CURRENT_POSTS_EMAIL_NOTIFI_PLUS_PATH', __DIR__ );
		define('CURRENT_POSTS_EMAIL_NOTIFI_PLUS_URL', plugins_url( '', CURRENT_POSTS_EMAIL_NOTIFI_PLUS_FILE ) );
	}

	/**
	 * Initialize the plugin
	 * 
	 * @return void
	 */
	public function init_plugin() {

	}

	/**
	 * Do staff plugin activation
	 * 
	 * @return void
	 * 
	 */
	public function activate() {

		$installed = get_option( 'current_posts_email_notifi_plus_installed');

		if ( ! $installed ) {
			
			update_option( 'current_posts_email_notifi_plus_installed', time() );
		}

		update_option( 'current_posts_email_notifi_plus_version', CURRENT_POSTS_EMAIL_NOTIFI_PLUS_VERSION );
	}
}

/**
 * Iniatialize the main plugin
 * 
 * @return \posts_email_notifi_plus
 */
function posts_email_notifi_plus() {

	return posts_email_notifi_plus :: init();
}

//kick of the plugin
posts_email_notifi_plus();