<?php
/**
 * User IP getting function
 *
 * @since 1.0
 *
 * @return string
 */
function ra_get_the_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = 'UNKNOWN';
    }

    return $ip;
}
/**
 * Rating inserter function
 *
 * @since 1.0
 *
 * @param array $args
 *
 * @return int|WP_Error
 */
function ra_insert_rating( $args = [] ) {
    global $wpdb;

    if ( empty( $args['rating'] ) ) {
        return new \WP_Error( 'no-rating', __( 'You must provide a rating', 'Ra_Books_Review' ) );
    }

    $defaults = [
        'post_id'    => '',
        'user_id'    => get_current_user_id(),
        'ip'         => ra_get_the_user_ip(),
        'rating'     => 0.0,
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    $inserted = $wpdb->insert(
        $wpdb->prefix . 'wedevs_book_review_ratings',
        $data,
        [
            '%d',
            '%d',
            '%s',
            '%f',
            '%s',
        ]
    );

    if ( ! $inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'Ra_Books_Review' ) );
    }

    return $wpdb->insert_id;
}
/**
 * Rating updater function
 *
 * @since 1.0
 *
 * @param array $args
 *
 * @return int|WP_Error
 */
function ra_update_rating( $args = [] ) {
    global $wpdb;

    $id = (int) $args['id'];

    if ( empty( $id ) ) {
        return new \WP_Error( 'no-rating-id', __( 'Rating ID must not be empty', 'Ra_Books_Review' ) );
    }

    if ( empty( $args['rating'] ) ) {
        return new \WP_Error( 'no-rating', __( 'You must provide a rating', 'Ra_Books_Review' ) );
    }

    $defaults = [
        'ip'         => ra_get_the_user_ip(),
        'rating'     => 0.0,
        'updated_at' => current_time( 'mysql' ),
    ];

    unset( $args['id'] );
    unset( $args['post_id'] );

    $data = wp_parse_args( $args, $defaults );

    $updated = $wpdb->update(
        $wpdb->prefix . 'wedevs_book_review_ratings',
        $data,
        [ 'id' => $id ],
        [
            '%s',
            '%f',
            '%s',
        ],
        [ '%d' ]
    );

    if ( ! $updated ) {
        return new \WP_Error( 'failed-to-update', __( 'Failed to update data', 'Ra_Books_Review' ) );
    }

    return $updated;
}
/**
 * Rating getter function
 *
 * @since 1.0
 *
 * @param array $args
 *
 * @return object
 */
function ra_get_rating( $args = [] ) {
    global $wpdb;

    $defaults = [
        'post_id' => '',
        'user_id' => get_current_user_id(),
    ];

    $args = wp_parse_args( $args, $defaults );

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wedevs_book_review_ratings WHERE post_id = %d AND user_id = %d", $args['post_id'], $args['user_id'] )
    );
}