<?php
/**
 * Plugin Name:           Related Posts Widget Plugin
 * Plugin URI:            https://sajuahmed.epizy.com/
 * Description:           Display 5 related posts in the single post page sidebar
 * Version:               1.0
 * Author:                Riyadh Ahmed
 * Author URI:            https://sajuahmed.epizy.com/
 * Text Domain:           ra-related-posts-widget
 * Requires WP at least:  5.2
 * Requires PHP at least: 7.2
 * Domain Path:           /languages/
 * License:               GPL2
 */

/**
 * Copyright (c) 2022 (email: riathislam44@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
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
 * Include the autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    wp_die( 'Composer auto-loader missing. Run "composer update" command on this plugin.' );
}
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main plugin class
 *
 * @class RaRelatedPostsWidget
 *
 */
final class RaRelatedPostsWidget {

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

        $this->init_plugin();
    }

    /**
     * Initialize a singleton instance
     *
     * @since  1.0
     *
     * @return\RaRelatedPostsWidget
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
        define( 'RA_RELATED_POSTS_WIDGET_VERSION', self::VERSION );
        define( 'RA_RELATED_POSTS_WIDGET_FILE', __FILE__ );
        define( 'RA_RELATED_POSTS_WIDGET_PATH', __DIR__ );
        define( 'RA_RELATED_POSTS_WIDGET_URL', plugins_url( '', RA_RELATED_POSTS_WIDGET_FILE ) );
        define( 'RA_RELATED_POSTS_WIDGET_ASSETS', RA_RELATED_POSTS_WIDGET_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @since  1.0
     *
     * @return void
     */
    public function init_plugin() {
        require_once( RA_RELATED_POSTS_WIDGET_PATH . '/includes/Widgets.php' );
        new Riyadh1734\RelatedPostsWidget\Widgets();
    }

    /**
     * Do staff upon plugin activation
     *
     * @since  1.0
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'ra_related_posts_widget_installed' );

        if ( ! $installed ) {
            update_option( 'ra_related_posts_widget_installed', time() );
        }

        update_option( 'ra_related_posts_widget_version', RA_RELATED_POSTS_WIDGET_VERSION );
    }
}

/**
 * Initialize the main plugin.
 *
 * @retuRa\RaRelatedPostsWidget
 */
function ra_related_posts_widget() {
   return RaRelatedPostsWidget::init();
}

/**
 * Kick-off the plugin
 */
ra_related_posts_widget();
