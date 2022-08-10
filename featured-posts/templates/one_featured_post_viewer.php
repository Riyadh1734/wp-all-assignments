<?php
/**
 * Template: shortcode featured post viewer
 *
 * HTML template for preview featured post
 *
 * @since 1.0
 */
?>
<div class="single-post">
    <div class="container wrapper single-post-wrapper default-max-width clearfix"">
        <h2>
            <a href="<?php esc_url( the_permalink() ); ?>">
                <?php esc_html( the_title() ); ?>
            </a>
        </h2>
        <a href="<?php esc_url( the_permalink() ); ?>">
            <?php esc_html( the_post_thumbnail( 'thumbnail' ) ); ?>
        </a>
        <p>
            <?php esc_html( the_excerpt() ); ?>
            <a href="<?php esc_url( the_permalink() ); ?>">
                <?php esc_html_e( 'Read More', 'ra_post_pro' ); ?>
            </a>
        </p>
    </div>
</div>
<?php
