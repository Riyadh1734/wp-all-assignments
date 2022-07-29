<?php
namespace Riyadh1734\BooksReview;

class Shortcode {

    /**
     * Initialize the class
     * 
     * @since 1.2
     */
    public function __construct() {
        add_shortcode( 'ra-book-review-search', [ $this, 'ra_render_shortcode_form' ] );
    }

    public function ra_render_shortcode_form() {
        
        ob_start();
        ?>
        <h3><?php esc_html_e( 'Search for Book Reviews', 'Ra_Books_Review' ); ?></h3>
        <form id="book-review-search-form" action="" method="GET">
            <div>
                <input name="keyword" type="text" id="keyword" <?php esc_attr_e( 'Input text here', 'Ra_Books_Review' ); ?>" required>
                <?php wp_nonce_field( 'book-review-search', '_wpnonce_ra_search' ); ?>
                <input name="ra-meta-search-submit" type="submit" value="<?php esc_attr_e( 'Search Book', 'Ra_Books_Review' ); ?>">
            </div>
        </form>
        <?php
        echo ob_get_clean();

        $search_keyword = isset( $_REQUEST['keyword'] ) ? sanitize_text_field( $_REQUEST['keyword'] ) : '';

        if ( ! isset( $_REQUEST['ra-meta-search-submit'] ) ) {
            return;
        }

        if ( ! isset( $_REQUEST['_wpnonce_ra_search'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_ra_search'], 'book-review-search') ) {
            wp_die('Notice: Nonce verify failed!');
        }

        if ( empty( $search_keyword ) ) {
            return;
        }

        $book_meta_args = array (
            'post_type'    => 'book',
            'post_status'  => 'publish',
            'meta_query'   => array(
                'relation' => 'OR',
                array(
                    'key'      => 'book_meta_key_writter',
                    'value'    => "$search_keyword",
                    'compare'  => 'LIKE',
                ),
                array(
                    'key'      => 'book_meta_key_isbn',
                    'value'    => "$search_keyword",
                    'compare'  => 'LIKE',
                ),
                array(
                    'key'      => 'book_meta_key_year',
                    'value'    => "$search_keyword",
                    'compare'  => 'LIKE',
                ),
                array(
                    'key'      => 'book_meta_key_price',
                    'value'    => "$search_keyword",
                    'compare'  => 'LIKE',
                ),
                array(
                    'key'      => 'book_meta_key_description',
                    'value'    => "$search_keyword",
                    'compare'  => 'LIKE',
                ),
            ),
        );
        $book_meta_query = new \WP_Query( $book_meta_args );

        if ( $book_meta_query->have_posts() ) {
            while ( $book_meta_query->have_posts() ) {
                $book_meta_query->the_post();
                ob_start();
                ?>
                <div id="search-results-wrapper" class="container wrapper default-max-width clearfix">
                <h2><a href="<?php esc_url( the_permalink() ); ?>"><?php esc_html( the_title() ); ?></a></h2>
                <a href="<?php esc_url( the_permalink() ); ?>"><?php esc_html( the_post_thumbnail( 'thumbnail' ) ); ?></a>
                <p><?php esc_html( the_excerpt() ); ?><a href="<?php esc_url( the_permalink() ); ?>">
                <?php esc_html_e( 'Read More', 'Ra-Books-Review' ); ?></a></p>
                </div>
                <?php                
                echo ob_get_clean();
            }
        }
        else {
            echo __('<span style="color: red; font-size: 18px;"> '."=> No book found for your search!".' </span>' , 'Ra_Books_Review' );
        }
        //Restore all original data
        wp_reset_postdata();
    }
}