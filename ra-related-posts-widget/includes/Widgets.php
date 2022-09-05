<?php

namespace Riyadh1734\RelatedPostsWidget;

/**
 * Related posts theme widget
 * handler class
 */
class Widgets extends \WP_Widget {

    /**
     * Passing widget frontend markup using arguments array
     *
     * @since 1.0.0
     *
     * @var array
     */
    public $args = [
        'before_title'  => '<h4 class="widget-title>',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div>'
    ];

    /**
     * Initialize the widget class
     *
     * @since 1.0.0
     */
    public function __construct() {
        parent::__construct(
            'ra-related-posts-widget',
            __( 'Related Posts', 'ra-related-posts-widget' )
        );

        add_action( 'widgets_init', [ $this, 'register_custom_widget' ] );
    }

    /**
     * Widget register function
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_custom_widget() {
        register_widget( 'Riyadh1734\RelatedPostsWidget\Widgets' );
    }

    /**
     * Widget frontend output handler function
     *
     * @since 1.0.0
     *
     * @param array $args
     * @param array $instance
     *
     * @return void
     */
    public function widget( $args, $instance ) {
        $title     = ! empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
        $limit     = ! empty( $instance['limit'] ) ? sanitize_text_field( $instance['limit'] ) : 5;
        $thumbnail = isset( $instance['thumbnail'] ) ? sanitize_text_field( $instance['thumbnail'] ) : '';
        $excerpt   = isset( $instance['excerpt'] ) ? sanitize_text_field( $instance['excerpt'] ) : '';

        // Get posts from related posts fetcher function
        $related_posts = $this->get_related_posts( $limit );

        if ( ! is_single() ) {
            return;
        }

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . apply_filters( 'resent_post_widget_title', $title ) . $args['after_title'];
        }

        while ( $related_posts->have_posts() ) {
            $related_posts->the_post();

            // Include related posts output template
            ob_start();
            include RA_RELATED_POSTS_WIDGET_PATH . '/templates/related_posts_widget_output.php';
            echo ob_get_clean();
        }

        // Restore original Post Data
        wp_reset_postdata();

        echo $args['after_widget'];
    }

    /**
     * Widget dashboard options form handler function
     *
     * @since 1.0.0
     *
     * @param array $instance
     *
     * @return void
     */
    public function form( $instance ) {
        $title     = ! empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
        $limit     = ! empty( $instance['limit'] ) ? sanitize_text_field( $instance['limit'] ) : '';
        $thumbnail = isset( $instance['thumbnail'] ) ? sanitize_text_field( $instance['thumbnail'] ) : false;
        $excerpt   = isset( $instance['excerpt'] ) ? sanitize_text_field( $instance['excerpt'] ) : false;

        // Include widget dashboard input form template
        ob_start();
        include RA_RELATED_POSTS_WIDGET_PATH . "/templates/related_posts_widget_form.php";
        echo ob_get_clean();
    }

    /**
     * Widget options data save handler function
     *
     * @since 1.0.0
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = [];

        $instance['title']     = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['limit']     = ( ! empty( $new_instance['limit'] ) ) ? sanitize_text_field( $new_instance['limit'] ) : '';
        $instance['thumbnail'] = isset( $new_instance['thumbnail'] ) ? sanitize_text_field( $new_instance['thumbnail'] ) : '';
        $instance['excerpt']   = isset( $new_instance['excerpt'] ) ? sanitize_text_field( $new_instance['excerpt'] ) : '';

        return $instance;
    }

    /**
     * Related posts fetcher function
     *
     * @since 1.0.0
     *
     * @param int   $limit The number of posts
     * @param array $args  The post query arguments
     *
     * @return object|void
     */
    public function get_related_posts( $limit = 5, $args = [] ) {
        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'post__not_in'   => [ get_the_ID() ],
            'category__in'   => wp_get_post_categories( get_the_ID() ),
            'posts_per_page' => (int) $limit,
        ];

        $the_query = new \WP_Query( $args );

        if ( $the_query->have_posts() ) {
            return $the_query;
        } else {
            echo __( 'No related posts found!', 'ra-related-posts-widget' );
        }
    }
}
