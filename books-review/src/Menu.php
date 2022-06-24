<?php
namespace Riyadh1734\BooksReview;

class Menu {

    /**
     * Initialize the class
     * 
     * @since 1.0
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'ra_admin_menu' ] );
    }
    
    /**
     * Menu handler for book review
     * 
     * @since 1.0
     *
     * @return void
     */
    public function ra_admin_menu() {
        add_menu_page(
            __( 'Book Review', 'ra-book-review' ),
            __( 'Book Review', 'ra-book-review' ),
            'manage_options',
            'book-review',
            [ $this, 'ra_plugin_page' ],
            'dashicons-book-alt'
        );
    }

    /**
     * Path define for template
     * 
     * @since 1.0
     *
     * @return void
     */
    public function ra_plugin_page() {
        /**
         * Include menu page template
         */
        ob_start();
        require_once Ra_Books_Review_PATH . "/templates/menu_page.php";
        echo ob_get_clean();
    }

}