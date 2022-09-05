<?php
/**
 * Template: related posts widget input form
 *
 * HMTL form template for releted post dashboard input
 *
 * @since 1.0.0
 * 
 * by Riyadh Ahmed
 */
?>
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'ra-related-posts-widget' ); ?></label>
    <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Posts per page', 'ra-related-posts-widget' ); ?></label>
    <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" value="<?php echo esc_attr( $limit ); ?>">
</p>
<p>
    <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumbnail' ) ); ?>" value="1" <?php checked( $thumbnail, 1 ); ?>>
    <label for="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>"> <?php echo esc_attr( 'Post thumbnail' ); ?></label>
</p>
<p>
    <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>" value="1" <?php checked( $excerpt, 1 ); ?>>
    <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"> <?php esc_html_e( 'Post excerpt', 'ra-related-posts-widget' ); ?></label>
</p>
<?php
