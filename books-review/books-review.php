<?php

/**
 * Plugin Name: Books Review
 * Description: Add metabox to get information about each books & display it 
 * Plugin URI: http://sajuahmed.epizy.com
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com
 * Version: 1.0
 * License: GPL2
 * Text Domain: Ra_Books_Review
 */

/*
    Copyright (C)2022  Riyadh Ahmed  riathislam44@gmail.com

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
/**
 * Include the autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    wp_die( 'Composer auto-loader missing. Run "composer update" command on this plugin.' );
}
require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 * 
 * @since  1.0
 */
final class Ra_Books_Review {

    /**
     * plugin version
     */
    const version = '1.0';

    /**
     * class constructor
     * 
     * @since  1.0
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate'] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize a singleton instance
     * 
     * @since  1.0
     * 
     * @return \Ra_Books_Review
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
     * 
     * @since  1.0
     */
    public function define_constants() {
        define( 'Ra_Books_Review_VERSION', self::version);
        define( 'Ra_Books_Review_FILE', __FILE__ );
        define( 'Ra_Books_Review_PATH', __DIR__ );
        define( 'Ra_Books_Review_URL', plugins_url( '', Ra_Books_Review_FILE ) );
        define( 'Ra_Books_Review_ASSETS', Ra_Books_Review_URL . '/assets');
    }

    /**
     * initialize plugin
     * 
     * @since  1.0
     */
    public function init_plugin() {
        include_once 'src/functions.php';
        
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new \Riyadh1734\BooksReview\Ajax();
        }

        if ( is_admin() ) {
           new Riyadh1734\BooksReview\Menu();
           
           new Riyadh1734\BooksReview\Metabox();
        }
        new Riyadh1734\BooksReview\Customptype();
        new Riyadh1734\BooksReview\Customtax();
        new \Riyadh1734\BooksReview\Shortcode();
        new \Riyadh1734\BooksReview\Assets();
    }

    /**
     * Do stuff plugin activation
     * 
     * @since  1.0
     * 
     * @return void
     */
    public function activate() {
        $installer = new Riyadh1734\BooksReview\install\Installer();
        $installer->run();
    }
}

/**
 * Initialize the main plugin
 * 
 * @since  1.0
 * 
 * @return \Ra_Books_Review
 */
function ra_books_review()
{
    return ra_books_review::init();
}
//kick-off the plugin @since  1.0
ra_books_review();