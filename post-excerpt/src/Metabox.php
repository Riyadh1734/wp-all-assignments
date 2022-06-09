<?php

namespace Riyadh1734\PostExcerpt;

/**
 * metabox handler class
 * @version 1.0
 * 
 */
class Metabox {

    /**
     * initialize the class
     * 
     */
    public function __construct() {
        

        add_action('add_meta_boxes', [$this, 'ct_metabox_handler']);
        add_action('save_post',      [ $this, 'ct_metabox_save_postdata']);

    }

    /**
     * Add metabox with the title
     *
     * @return void
     */
    public function ct_metabox_handler() {

        add_meta_box(
            'ct-meta-box',
            __( 'Custom Excerpt' ),
            [ $this, 'render_ct_meta_box' ],
            'post'
        );

    }

    /**
     * Save metadata function
     *
     * @param [string] $post_id
     * @return void
     */
    public function ct_metabox_save_postdata( $post_id ) {

        // Check if our nonce is set.
        if ( ! isset( $_POST['ct_inner_custom_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['ct_inner_custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'ct_inner_custom_box' ) ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        // Sanitize the user input.
        $userdata = sanitize_text_field( $_POST['ct_excerpt_field'] );
 
        // Update the meta field.
        update_post_meta( $post_id, '_ct_meta_value_key', $userdata );

        
    }

    /**
     * Meta box area handler
     *
     * @return void
     */
    public function render_ct_meta_box( $post ) {

            // Add an nonce field so we can check for it later.
            wp_nonce_field( 'ct_inner_custom_box', 'ct_inner_custom_box_nonce' );

            // Use get_post_meta to retrieve an existing value from the database.
            $value = get_post_meta( $post->ID, '_ct_meta_value_key', true );

            // Display the form, using the current value.
            ob_start();
            ?>
             <textarea name="<?php echo esc_attr( 'ct_excerpt_field' ); ?>" class="<?php echo esc_attr( 'widefat' ); ?>"><?php esc_html_e( $value ); ?></textarea>
            <?php
            echo ob_get_clean();
    }

}