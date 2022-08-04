<?php
/**
 * Template: plugin page
 *
 * HTML template for dashboard menu plugin page
 *
 * @since 1.0
 */
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php apply_filters( 'ra_contactform_plugin_page_title', esc_html_e( 'Contact Form Responses', 'self' ) ); ?></h1>
    <form action = "" method = "post">
        <?php
        $table = new Riyadh1734\ContactForm\ContactList();
        $table->prepare_items();
        $table->display();
        ?>
    </form>
</div>
<?php
