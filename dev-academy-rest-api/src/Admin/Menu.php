<?php

namespace Riyadh1734\DevAcademy\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $addressbook;

    /**
     * Initialize the class
     */
    function __construct( $addressbook ) {
        $this->addressbook = $addressbook;

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'dev-academy';
        $capability = 'manage_options';

        add_menu_page( __( 'Dev Academy', 'dev-academy' ), __( 'Academy', 'dev-academy' ), $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ], 'dashicons-welcome-learn-more' );
        add_submenu_page( $parent_slug, __( 'Address Book', 'dev-academy' ), __( 'Address Book', 'dev-academy' ), $capability, $parent_slug, [ $this->addressbook, 'plugin_page' ] );
        add_submenu_page( $parent_slug, __( 'Settings', 'dev-academy' ), __( 'Settings', 'dev-academy' ), $capability, 'dev-academy-settings', [ $this, 'settings_page' ] );
    }

    /**
     * Handles the settings page
     *
     * @return void
     */
    public function settings_page() {
        echo 'Settings Page';
    }
}
