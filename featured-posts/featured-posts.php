<?php
/**
 * Plugin Name:           Featured Posts
 * Plugin URI:            https://sajuahmed.epizy.com
 * Description:           Display featured posts using settings fields
 * Version:               1.0
 * Author:                Riyadh Ahmed
 * Author URI:            https://sajuahmed.epizy.com
 * Text Domain:           ra-featured-posts
 * License:               GPL2
 */

/**
 * Copyright (c) 2021 Riyadh (email: riathislam44@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

/**
 * Don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Include the composer autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    wp_die( 'Composer auto-loader missing. Run "composer update" command.' );
}
require_once __DIR__ . "/vendor/autoload.php";

/**
 * Main plugin class
 *
 * @class Featured_Posts
 *
 * The class that holds
 * the entire plugin
 */
final class Featured_Posts {

    /**
     * Plugin version
     *
     * @var string
     */
    const VERSION = '1.0';

    /**
     * Class constructor
     *
     * @since  1.0
     */
    public function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

        $this->init_plugin();
    }

    /**
     * Initialize a singleton instance
     *
     * @since  1.0
     *
     * @return \Featured_Posts
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the plugin constants
     *
     * @since  1.0
     *
     * @return void
     */
    public function define_constants() {
        define( 'RA_FEATURED_POSTS_VERSION', self::VERSION );
        define( 'RA_FEATURED_POSTS_FILE', __FILE__ );
        define( 'RA_FEATURED_POSTS_PATH', __DIR__ );
        define( 'RA_FEATURED_POSTS_URL', plugins_url( '', RA_FEATURED_POSTS_FILE ) );
        define( 'RA_FEATURED_POSTS_ASSETS', RA_FEATURED_POSTS_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @since  1.0
     *
     * @return void
     */
    public function init_plugin() {
        if ( is_admin() ) {
            new Riyadh1734\FeaturedPosts\Admin\Menu();
            new Riyadh1734\FeaturedPosts\Admin\Settings();
        } else {
            new Riyadh1734\FeaturedPosts\Shortcode();
        }

        // Removes transient in case of post add/update
        add_action( 'save_post', 'ra_delete_transient_fp' );
    }

    /**
     * Do staff upon plugin activation
     *
     * @since  1.0
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'ra_featured_posts_installed' );

        if ( ! $installed ) {
            update_option( 'ra_featured_posts_installed', time() );
        }

        update_option( 'ra_featured_posts_version', RA_FEATURED_POSTS_VERSION );
    }

    /**
     * Do staff upon plugin deactivation
     *
     * @since  1.0
     *
     * @return void
     */
    public function deactivate() {
        // Removes featured posts cache
        ra_delete_transient_fp();
    }
}

/**
 * Initialize the main plugin
 *
 * @return \Featured_Posts
 */
function ra_featured_posts() {
    return Featured_Posts::init();
}

/**
 * Kick-off the plugin
 */
ra_featured_posts();
