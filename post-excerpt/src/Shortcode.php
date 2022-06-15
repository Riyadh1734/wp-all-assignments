<?php
namespace Riyadh1734\PostExcerpt;
use WP_Query;
class Shortcode {

    /**
     * Initialize the class
     */
    public function __construct() {
        add_shortcode('ct_post_excerpt', [ $this, 'render_ct_post_excerpt'] );
    }

    /**
     * Fill in the defaults if user not given
     *
     * @param [array] $atts
     * 
     * @return void
     */
    public function render_ct_post_excerpt( $atts ) {
        $atts = shortcode_atts(
            array(
                'id'       => '',
                'display'  => '10',
                'category' => '',
            ),
            $atts
        );
            
            $args = array(
                'meta_key'       => '_ct_meta_value_key',
                'post_type'      => 'post',
                'posts_per_page' => $atts['display'],
            );

            if ( $atts['id'] ) {
                $ids              = explode( ',', $atts['id'] );
                $args['post__in'] = $ids;
            } elseif ( $atts['category'] ) {
                $args['category_name'] = $atts['category'];
            }

            $the_query = new WP_Query( $args);

            if ( $the_query->have_posts() ) {
                $posts = $the_query->posts;

                ob_start();
                ?>
                <ol>
                    <?php foreach( $posts as $post ) : ?>
                        <?php $post_meta_excerpt = get_post_meta( $post->ID, '_ct_meta_value_key' ); ?>
                        <li><?php esc_html_e( $post_meta_excerpt[0], 'post-excerpt' ); ?></li>
                    <?php endforeach; ?>
                </ol>
                <?php
                echo ob_get_clean();
            }


    }

}