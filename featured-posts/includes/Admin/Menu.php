<?php

namespace Riyadh1734\FeaturedPosts\Admin;

class Menu {

    /**
     * Initialize the class
     *
     * @since  1.0
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
        add_options_page( __( 'Set Featured Posts', 'ra-featured-posts' ), __( 'Featured Posts', 'ra-featured-posts' ),
         'manage_options', 'featured-posts', [ $this, 'featured_posts_admin_page_handler' ] );
    }

    /**
     * Render the plugin page
     *
     * @since  1.0
     *
     * @return void
     */
    public function featured_posts_admin_page_handler() {
        $settings_page    = isset( $_REQUEST['page'] ) ? sanitize_key( $_REQUEST['page'] ): '';
        $settings_updated = isset( $_REQUEST['settings-updated'] ) ? rest_sanitize_boolean( $_REQUEST['settings-updated'] ) : false;

        // Removes transient on featured posts settings update
        if ( ( 'featured-posts' === $settings_page ) && $settings_updated ) {
            ra_delete_transient_fp();
        }

        // Includes admin page template
        ob_start();
        require_once RA_FEATURED_POSTS_PATH . "/templates/admin/featured_posts_settings_page.php";
        echo ob_get_clean();
    }
}
