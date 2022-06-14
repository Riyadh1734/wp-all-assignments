<?php
namespace Riyadh1734\PostsViewPlus;
use WP_Query;

class Shortcode{

    /**
     * Initialize the class
     */
    public function __construct() {
        add_shortcode( 'ra_post_view_extend', [ $this, 'render_ct_post_list' ] );
    }

    /**
     * post list render function
     *
     * @param array $atts
     * @param string $content
     * @return void
     */
    public function render_ct_post_list( $atts ) {
        $atts = shortcode_atts( array(
            'limit'  => '10',
            'category' => '',
            'id'       => '',
            'order'    => 'ASC',
        ), $atts );
        
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $atts['limit'],
            'meta_key'       => 'post_view_count',
            'order'          => $atts['order']
        );

        if ( $atts['id'] ) {
            $ids = explode( ',', $atts['id'] );
            $args['post__in'] = $ids;
        }
        elseif ( $atts['category'] ) {
            $args['category_name'] = $atts['category'];

        }
        
        $the_query = new WP_Query( $args );        

        if ( $the_query->have_posts() ) {
            $posts = $the_query->posts;
            
            ob_start();
            ?>
            <ol>
                <?php

                foreach( $posts as $post) {
                    $post_views_count = get_post_meta( $post->ID, 'post_view_count', true );
                    $post_views_text  = sprintf( __( '%s : %d Views', 'text-domain' ), $post->post_title, $post_views_count );

                    ?>
                    <li><?php echo $post_views_text; ?></li>
                    <?php
                }
                ?>
            </ol>
            <?php
            echo ob_get_clean();
        }

    }
}