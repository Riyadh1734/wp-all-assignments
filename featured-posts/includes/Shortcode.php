<?php

namespace Riyadh1734\FeaturedPosts;

class Shortcode {

    /**
     * Initialize the class
     *
     * @since  1.0
     */
    public function __construct() {
        add_shortcode( 'ra-featured-posts', [ $this, 'render_featured_posts' ] );
    }

    /**
     * Featured posts
     * renderer function
     *
     * @since  1.0
     *
     * @param array $atts
     *
     * @return void
     */
    public function render_featured_posts( $atts ) {
        // Get featured posts settings from database
        $fp_limit = ( ! empty( get_option( 'featured_posts_limit' ) ) ) ? get_option( 'featured_posts_limit' ) : 5;
        $fp_order = ( ! empty( get_option( 'featured_posts_order' ) ) ) ? get_option( 'featured_posts_order' ) : 'DESC';
        $fp_cats  = ( ! empty( get_option( 'featured_posts_categories' ) ) ) ? implode( ',', get_option( 'featured_posts_categories' ) ) : '';

        // Shortcode attributes array
        $atts = shortcode_atts( apply_filters( 'ra_fp_sc_atts', [
            'limit'      => $fp_limit,
            'order'      => $fp_order,
            'categories' => $fp_cats,
        ] ), $atts );

        // Arguments array for posts query
        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => (int) $atts['limit'],
            'order'          => (string) $atts['order'],
            'category_name'  => (string) $atts['categories'],
        ];

        // Set conditional arguments
        if ( 'rand' === $atts['order'] ) {
            $args['orderby'] = 'rand';

            // Removes cache in case of random posts selected
            ra_delete_transient_fp();
        }

        // Get posts from the cache/query
        $featured_posts = $this->get_featured_posts( $args );

        // Output the query results
        if ( $featured_posts->have_posts() ) {
            while ( $featured_posts->have_posts() ) {
                $featured_posts->the_post();

                // Includes single post viewer template
                ob_start();
                include RA_FEATURED_POSTS_PATH . "/templates/one_featured_post_viewer.php";
                echo ob_get_clean();
            }
        } else {
            echo __( 'No featured posts to show', 'ra-post-pro' );
        }

        // Restore original Post Data
        wp_reset_postdata();
    }

    /**
     * Featured posts getter query/cache function
     *
     * @since 1.0
     *
     * @param array $args
     *
     * @return object|boolean
     */
    function get_featured_posts( $args = [] ) {
        $featured_posts_query = get_transient( 'featured_posts_query' );

        if ( empty( $featured_posts_query ) ) {
            $featured_posts_query = new \WP_Query( $args );
            set_transient( 'featured_posts_query', $featured_posts_query );
        }

        return $featured_posts_query;
    }
}
