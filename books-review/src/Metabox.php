<?php
namespace Riyadh1734\BooksReview;

class Metabox {

    /**
     * Initialize the class
     *
     * @since 1.0
     */
    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'register_ra_books_meta' ] );
        add_action( 'save_post', [ $this, 'ra_books_meta_update_data' ] );
    }

    public function register_ra_books_meta() {
        add_meta_box(
            'books_ct_meta_box',
            __( 'Book Details', 'ra-book-review' ),
            [ $this, 'ra_books_meta_handler' ],
            'book',
        );
    }

    public function ra_books_meta_handler( $post ) {
        /**
         * Fetched post meta
         */
        $book_meta_value_writter = get_post_meta( $post->ID, 'book_meta_key_writter', true );
        $book_meta_value_isbn    = get_post_meta( $post->ID, 'book_meta_key_isbn', true );
        $book_meta_value_year    = get_post_meta( $post->ID, 'book_meta_key_year', true );
        $book_meta_value_price   = get_post_meta( $post->ID, 'book_meta_key_price', true );
        $book_meta_value_desc    = get_post_meta( $post->ID, 'book_meta_key_description', true );
    
        /**
         * Include book metabox form template
         */
        ob_start();
        require_once Ra_Books_Review_PATH . "/templates/book_meta_form.php";
        echo ob_get_clean();
    }

    public function ra_books_meta_update_data( $post_id ) {
        $book_meta_fields = [
            'writter'     => '',
            'isbn'        => '',
            'year'        => '',
            'price'       => '',
            'description' => '',
        ];

        /**
         * Assign input values to the meta input array
         */
        if ( isset( $_POST['writter'] ) ) {
            $book_meta_fields['writter'] = sanitize_text_field( $_POST['writter'] );
        }
        if ( isset( $_POST['isbn'] ) ) {
            $book_meta_fields['isbn'] = sanitize_text_field( $_POST['isbn'] );
        }
        if ( isset( $_POST['year'] ) ) {
            $book_meta_fields['year'] = sanitize_text_field( $_POST['year'] );
        }
        if ( isset( $_POST['price'] ) ) {
            $book_meta_fields['price'] = sanitize_text_field( $_POST['price'] );
        }
        if ( isset( $_POST['description'] ) ) {
            $book_meta_fields['description'] = sanitize_textarea_field( $_POST['description'] );
        }

        /**
         * Update post meta values
         */
        update_post_meta( $post_id, 'book_meta_key_writter', $book_meta_fields['writter'] );
        update_post_meta( $post_id, 'book_meta_key_isbn', $book_meta_fields['isbn'] );
        update_post_meta( $post_id, 'book_meta_key_year', $book_meta_fields['year'] );
        update_post_meta( $post_id, 'book_meta_key_price', $book_meta_fields['price'] );
        update_post_meta( $post_id, 'book_meta_key_description', $book_meta_fields['description'] );
    }
}