<?php

namespace Riyadh1734\ContactForm\Admin;
/**
 * The menu handler class
 */
class Menu {
    /**
     * Initialize the class
     *
     * @since  1.0.
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu_handler' ] );
    }
    /**
     * Register admin menu
     *
     * @since  1.0
     *
     * @return void
     */
    public function admin_menu_handler() {
        add_menu_page( __( 'Contact Form', 'self' ),
            __( 'Contact Form', 'self' ), 
            'manage_options', 'contact-response',
            [ $this, 'plugin_page_handler' ], 'dashicons-buddicons-pm' );
    }

    /**
     * Render the plugin page
     *
     * @since  1.0
     *
     * @return void
     */
    public function plugin_page_handler() {
        /**
         * Include plugin page template
         */
        ob_start();
        include_once Ra_Contact_Form_PATH . "/templates/admin/plugin_page.php";
        echo ob_get_clean();
    }
}