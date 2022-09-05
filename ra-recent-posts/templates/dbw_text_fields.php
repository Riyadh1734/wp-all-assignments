<?php
/**
 * Action hook for adding contents
 * before config fields
 *
 * @since 1.0.0
 */
do_action( 'dbw_recent_posts_config_fields_before' );

/**
 * Template: Recent posts config fields template
 *
 * HMTL template for recent posts dashboard widget config fields
 *
 * @since 1.0.0
 */
?>
<div class="input-text-wrap">
    <input type="text" name="recent_posts_limit" id="recent_posts_limit" placeholder="<?php esc_html_e( 'Number of Posts', 'ra-recent-posts' ); ?>" value="<?php echo esc_attr( $current_limit ); ?>"><br><br>
</div>
<div class="input-text-wrap">
    <select name="recent_posts_order" id="recent_posts_order" class="widefat">
        <option value="<?php echo esc_attr( 'rand' ); ?>" <?php selected( $current_order, 'rand' ); ?>>
            <?php esc_html_e( 'Random', 'ra-recent-posts' ); ?>
        </option>
        <option value="<?php echo esc_attr( 'ASC' ); ?>" <?php selected( $current_order, 'ASC' ); ?>>
            <?php esc_html_e( 'ASC', 'ra-recent-posts' ); ?>
        </option>
        <option value="<?php echo esc_attr( 'DESC' ); ?>" <?php selected( $current_order, 'DESC' ); ?>>
            <?php esc_html_e( 'DESC', 'ra-recent-posts' ); ?>
        </option>
    </select><br><br>
</div>
<?php

/**
 * Action hook for adding contents
 * after config fields
 *
 * @since 1.0.0
 */
do_action( 'dbw_recent_posts_config_fields_before' );
