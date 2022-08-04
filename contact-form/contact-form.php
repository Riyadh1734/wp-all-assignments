<?php
/**
 * Plugin Name: Contact Form
 * Description: You can submit your info via this form
 * Plugin URI: http://sajuahmed.epizy.com
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com
 * Version: 1.0
 * License: GPL2
 */

/*
    Copyright (C) 2022  Riyadh-Ahmed  riathislam44@gmail.com

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
 * Include the composer autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    wp_die( 'Composer auto-loader missing. Run "composer update" command.' );
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Ra_Contact_Form {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        include_once 'includes/functions.php';
        
        if ( is_admin() ) {
            new Riyadh1734\ContactForm\Admin\Menu();
        } else {
            new Riyadh1734\ContactForm\Shortcode();
        }

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Riyadh1734\ContactForm\Ajax();
        }

        new Riyadh1734\ContactForm\Assets();
    }
    /**
     * Initializes a singleton instance
     *
     * @return \Ra_Contact_Form
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'Ra_Contact_Form_VERSION', self::version );
        define( 'Ra_Contact_Form_FILE', __FILE__ );
        define( 'Ra_Contact_Form_PATH', __DIR__ );
        define( 'Ra_Contact_Form_URL', plugins_url( '', Ra_Contact_Form_FILE ) );
        define( 'Ra_Contact_Form_ASSETS', Ra_Contact_Form_URL . '/assets' );
    }

   /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new \Riyadh1734\ContactForm\Install\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Ra_Contact_Form
 */
function Ra_Contact_Form() {
    return Ra_Contact_Form::init();
}

// kick-off the plugin
Ra_Contact_Form();
