<?php

namespace Riyadh1734\ContactForm;
/**
 * Contact responsehandler class
 * 
 * @since 1.0
 */
class ContactResponse {

    /**
     * Contact response inserter function
     *
     * @since 1.0
     *
     * @param array $args
     *
     * @return int|WP_Error
     */
    function insert_response( $args = [] ) {
        global $wpdb;

        $defaults = [
            'first_name' => '',
            'last_name'  => '',
            'email'      => '',
            'message'    => '',
            'ip'         => ra_contactform_get_user_ip(),
            'created_at' => current_time( 'mysql' ),
        ];

        $data = wp_parse_args( $args, $defaults );

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'wedevs_contact_form_responses',
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );

        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'self' ) );
        }

        return $wpdb->insert_id;
    }
    /**
     * Contact responses fetcher function
     *
     * @since 1.0
     *
     * @param array $args
     *
     * @return array
     */
    function get_contact_responses( $args = [] ) {
        global $wpdb;

        $defaults = [
            'number'  => 20,
            'offset'  => 0,
            'orderby' => 'id',
            'order'   => 'DESC',
        ];

        $args = wp_parse_args( $args, $defaults );

        $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}wedevs_contact_form_responses
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
        );

        $items = $wpdb->get_results( $sql );

        return $items;
    }

    /**
     * Total contact response counter function
     *
     * @since 1.0.0
     *
     * @return int
     */
    function contact_response_count() {
        global $wpdb;

        return $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wedevs_contact_form_responses" );
    }
}
