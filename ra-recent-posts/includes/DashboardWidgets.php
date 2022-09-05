<?php

namespace Riyadh1734\RaRecentPosts;

/**
 * The dashboard widgets
 * handler class
 */
class DashboardWidgets {

    /**
     * Initialize the class
     *
     * @since  1.0.0
     */
    public function __construct() {
        add_action( 'wp_dashboard_setup', [ $this, 'dashboard_widgets_handler' ] );
    }

    /**
     * Dashboard widgets handler function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function dashboard_widgets_handler() {
        wp_add_dashboard_widget(
            'recent_posts_db_widget',
            __( 'Recent Posts List', 'ra-recent-posts' ),
            [ $this, 'render_posts_list_cb' ],
            [ $this, 'configure_posts_list_cb' ]
        );
    }

    /**
     * Recent posts widget renderer function
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function render_posts_list_cb() {
        // Get recent post config from option table or assign default configs
        $rp_limit    = ! empty( get_option( 'recent_posts_limit' ) ) ? get_option( 'recent_posts_limit' ) : 7;
        $rp_order    = ! empty( get_option( 'recent_posts_order' ) ) ? get_option( 'recent_posts_order' ) : 'DESC';
        $rp_cats_arr = ! empty( get_option( 'recent_posts_cats' ) ) ? get_option( 'recent_posts_cats' ) : [];
        $rp_cats     = implode( ',', $rp_cats_arr );

        // Arguments for post fetching
        $rp_args = [
            'numberposts'   => (int) $rp_limit,
            'order'         => (string) $rp_order,
            'category_name' => (string) $rp_cats,
        ];

        // Add conditional arguments
        if ( 'rand' === $rp_order ) {
            $rp_args['orderby'] = 'rand';
        }

        // Get recent posts
        $recent_posts = wp_get_recent_posts( $rp_args );

        // Looping through each of the posts and show output
        foreach ( $recent_posts as $recent_post ) {
            // Include single post output template
            ob_start();
            include RA_RECENT_POSTS_PATH . '/templates/dbw_single_post_output.php';
            echo ob_get_clean();
        }
    }

    /**
     * Recent posts widget configure function
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function configure_posts_list_cb() {
        // Get recent post config from option table
        $current_limit    = ! empty( get_option( 'recent_posts_limit' ) ) ? get_option( 'recent_posts_limit' ) : '';
        $current_order    = ! empty( get_option( 'recent_posts_order' ) ) ? get_option( 'recent_posts_order' ) : '';
        $current_cats_arr = ! empty( get_option( 'recent_posts_cats' ) ) ? get_option( 'recent_posts_cats' ) : [];
        $all_cats_arr     = get_categories();

        // Include text input fields template file
        ob_start();
        include_once RA_RECENT_POSTS_PATH . '/templates/dbw_text_fields.php';
        echo ob_get_clean();

        // Looping through each categoires
        foreach ( $all_cats_arr as $cat ) {
            $cat_name    = isset( $cat->name ) ? sanitize_text_field( $cat->name ) : '';
            $cat_slug    = isset( $cat->slug ) ? sanitize_text_field( $cat->slug ) : '';
            $current_cat = isset( $current_cats_arr[$cat_slug] ) ? sanitize_text_field( $cat_name ) : '';

            // Include checkbox input fields template file
            ob_start();
            include RA_RECENT_POSTS_PATH . '/templates/dbw_checkbox_fields.php';
            echo ob_get_clean();
        }

        // Handler for saving user defined post configs to the option table
        $this->update_options_handler();
    }


    /**
     * Option field updater function
     *
     * @since  1.0.0
     *
     * @return void
     */
    public function update_options_handler() {
        // Get user input data from dashboard config fields
        $rp_limit = isset( $_POST['recent_posts_limit'] ) ? sanitize_text_field( $_POST['recent_posts_limit'] ) : '';
        $rp_order = isset( $_POST['recent_posts_order'] ) ? sanitize_text_field( $_POST['recent_posts_order'] ) : '';
        $rp_cats  = isset( $_POST['recent_posts_cats'] ) ? (array) $_POST['recent_posts_cats'] : '';

        if ( ! empty ( $rp_limit ) ) {
            update_option( 'recent_posts_limit', $rp_limit );
        }

        if ( ! empty ( $rp_limit ) ) {
            update_option( 'recent_posts_order', $rp_order );
        }

        if ( ! empty ( $rp_limit ) ) {
            update_option( 'recent_posts_cats', $rp_cats );
        }

        /**
         * Action hook for saving extra data added by extra config fields
         *
         * @since 1.0.0
         */
        do_action( 'dbw_recent_posts_update_extra_configs' );
    }
}
