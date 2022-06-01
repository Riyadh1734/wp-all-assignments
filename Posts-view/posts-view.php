<?php
/**
 * Plugin Name: Posts View Count
 * Description: After every post content show its view count
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
final class Posts_View {

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
		add_filter( 'add_em_text_view', [ $this,'adds_em_text' ] );
		
	}

	/**
	 * Get post content with views
	 * 
	 * @return string
	 */
	public function count_post_view( $post ) {

		if ( is_singular( 'post' ) ) {
               
            $post_id = get_the_ID();

            $count_key = 'post_view_count';
            $count = get_post_meta( $post_id, $count_key, true );


            /**
             * check condition if count 0 or not
             * 
             * @return string
             */
            if ( empty( $count ) ) {
			
                
                $count = 1;
                update_post_meta( $post_id, $count_key, $count );

            } else {
            	$count++;
            	update_post_meta( $post_id, $count_key, $count);

            }

		}

		/**
		 * Get the post view count
		 * 
		 * @return string
		 */
		$content = $this-> get_post_view();
		return $post . $content;		

	}

	/**
	 * Show post views after the content
	 *
	 * @return void
	 */
	public function get_post_view()
	{
		
		$get_count_post_view   = get_post_meta( get_the_ID(), 'post_view_count', true );
		$em_text = apply_filters( 'add_em_text_view', $get_count_post_view );
		//$content = 'Post views :' . $count; 
		//error_log( $em_text);
		//var_dump($em_text);

		return $em_text;

	}

	public function adds_em_text( $count ) {

		$em_text_content = '<em style="color:green; font-size:20px;">'. 'Post Views: ' . esc_html( $count ) . '</em>';
		//$em_text_content = 'Post Views: ' . $count;
		
		return $em_text_content;
	}
	

    /**
     * Initialize singleton instance
     * 
     * @return \Posts_view
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

		define('CURRENT_POSTS_VIEW_VERSION', self::version ); 
		define('CURRENT_POSTS_VIEW_FILE', __FILE__ );
		define('CURRENT_POSTS_VIEW_PATH', __DIR__ );
		define('CURRENT_POSTS_VIEW_URL', plugins_url( '', CURRENT_POSTS_VIEW_FILE ) );
	}

	/**
	 * Initialize the plugin
	 * 
	 * @return void
	 */
	public function init_plugin() {

		add_filter( 'the_content', [ $this, 'count_post_view' ] );
		
	}

	/**
	 * Do staff plugin activation
	 * 
	 * @return void
	 * 
	 */
	public function activate() {

		$installed = get_option( 'current_posts_view_installed');

		if ( ! $installed ) {
			
			update_option( 'current_posts_view_installed', time() );
		}

		update_option( 'current_posts_view_version', CURRENT_POSTS_VIEW_VERSION );
	}
}

/**
 * Iniatialize the main plugin
 * 
 * @return \Posts_view
 */
function posts_view() {

	return posts_view :: init();
}

//kick of the plugin
posts_view();