<?php
/**
 * Template: featured posts dashboard settings page
 *
 * HTML template for featured posts admin settings page
 *
 * @since 1.0
 */
?>
<div class="featured-posts-admin-wrapper">
    <form action="options.php" method="post">
    <?php
    settings_fields( 'featured-posts' );
    do_settings_sections( 'featured-posts' );
    submit_button( __( 'Save Changes', 'ra-featured-posts' ), 'primary', 'fp-settings-submit' );
    ?>
    </form>
</div>
<?php
