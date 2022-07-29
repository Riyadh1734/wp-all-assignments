<?php
namespace Riyadh1734\BooksReview;
/**
 * Ajax handler class
 * 
 * @since 1.0
 */
class Ajax{
    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_ajax_book_review_rating', [ $this, 'book_rating_request_handler'] );
        add_action( 'wp_ajax_nopriv_book_review_rating', [ $this, 'book_rating_request_handler'] );
    }
    /**
     * Book rating Ajax hanler function for user
     *
     * @since 1.0
     *
     * @return void
     */
    public function book_rating_request_handler() {
        if ( ! is_user_logged_in() ) {
            wp_send_json_error( [
                'message' => __( 'Please login first to give rating!', 'Ra_Books_Review' ),
            ] );
        }

        if ( ! isset( $_REQUEST['_ajax_nonce'] ) || ! wp_verify_nonce( $_REQUEST['_ajax_nonce'], 'book-review-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'Ra_Books_Review' ),
            ] );
        }

        if ( ! isset( $_REQUEST['rating'] ) ) {
            wp_send_json_error( [
                'message' => __( 'Rating can\'t be empty!', 'Ra_Books_Review' ),
            ] );
        }

        if ( ! isset( $_REQUEST['post_id'] ) ) {
            wp_send_json_error( [
                'message' => __( 'Post ID can\'t be empty!', 'Ra_Books_Review' ),
            ] );
        }

        $args = [
            'post_id' => (int) $_REQUEST['post_id'],
            'rating'  => (float) $_REQUEST['rating'],
        ];

        if ( ! empty( $_REQUEST['rating_id'] ) ) {
            $args['id'] = (int) $_REQUEST['rating_id'];

            $rating_updated = ra_update_rating( $args );

            if ( is_wp_error( $rating_updated ) ) {
                wp_send_json_error( [
                    'message' => $rating_updated->get_error_message(),
                ] );
            }

            wp_send_json_success( [
                'message' => __( 'Rating updated successfully!', 'Ra_Books_Review' ),
            ] );
        } else {
            $insert_id = ra_insert_rating( $args );

            if ( is_wp_error( $insert_id ) ) {
                wp_send_json_error( [
                    'message' => $insert_id->get_error_message(),
                ] );
            }

            wp_send_json_success( [
                'message' => __( 'Rating added successfully!', 'Ra_Books_Review' ),
                'rating_id' => (int) $insert_id,
            ] );
        }
    }
}