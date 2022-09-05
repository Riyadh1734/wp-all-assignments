<?php
/**
 * Template: Recent posts widget output template
 *
 * HMTL template for recent posts dashboard widget single post output
 *
 * @since 1.0.0
 */
?>
<div class="dbw-single-post">
    <?php
    /**
     * Action hook for adding contents
     * before single post title
     *
     * @since 1.0.0
     */
    do_action( 'dbw_recent_post_title_before' );

    /**
     * Single post title HTML markup
     */
    ?>
    <h3 class="dbw-single-post-title">
        <a href="<?php echo esc_url( $recent_post['guid'] ); ?>"><?php echo esc_html( $recent_post['post_title'] ); ?></a>
    </h3>
    <?php

    /**
     * Action hook for adding contents
     * after single post title
     *
     * @since 1.0.0
     */
    do_action( 'dbw_recent_post_title_after' );
    ?>
</div>
<?php
