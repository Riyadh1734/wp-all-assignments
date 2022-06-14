<?php
namespace Riyadh1734\PostsViewPlus;
class Settings{

    public function __construct() {
        add_filter( 'the_content', [ $this, 'count_set_post_view' ] );
        add_filter( 'the_content', [ $this, 'count_get_post_view' ] );
    }

    /**
     * Setting post content with views
     * @param string $content
     * @return $content
     */
    public function count_set_post_view( $content ) {
        global $post;

        if ( $post->post_type === 'post' && is_single() ) {
               
            $post_id   = $post->ID;
            $count_key = 'post_view_count';
            $count     = (int) get_post_meta( $post_id, $count_key, true );
            $count++;

            update_post_meta( $post_id, $count_key, $count);
        }
        return $content;
    }

   /**
    * Getting post content with views
    *
    * @param string $content
    * @return $content
    */
    public function count_get_post_view( $content ) {
        global $post;

        if ( $post->post_type === 'post' && is_single() ) {

            $post_id   = $post->ID;
            $count_key = 'post_view_count';
            $count     = get_post_meta( $post_id, $count_key, true);

            $cont = '';
            $cont .= '<h3>Post Views: ' . '<' . apply_filters( 'custom_html_tag', 'b');
            $cont .= '>' . $count .'</' . apply_filters( 'custom_html_tag', 'b') . '>' . '</h3>';

            echo $cont;
        }
        return $content;
    }

}