<?php
namespace Riyadh1734\BooksReview\Install;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'ra_books_review_installed' );

        if ( ! $installed ) {
            update_option( 'ra_books_review_installed', time() );
        }

        update_option( 'ra_books_review_version', Ra_Books_Review_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}wedevs_book_review_ratings` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `post_id` bigint(20) unsigned NOT NULL,
            `user_id` bigint(20) unsigned NOT NULL,
            `ip` varchar(30) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
            `rating` float unsigned NOT NULL DEFAULT '0',
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }
}