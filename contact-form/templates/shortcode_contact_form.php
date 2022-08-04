<?php
/**
 * Template: shortcode contact form
 *
 * HTML template for shortcode contact form
 *
 * @since 1.0
 */
?>
<div class="contact-form-wrapper">
    <h2 class="cf-title"><?php echo esc_html( $title ); ?></h2>
    <h4 class="cf-desc"><?php echo esc_html( $description ); ?></h4>
    <form id="self_contact" action="#" method="POST">

        <div class="input-field-single">
            <label for="fname"><?php esc_html_e( 'First Name', 'self' ); ?>* :</label>
            <input type="text" name="fname" id="cf-fname" placeholder="<?php esc_attr_e( 'Your First Name Here', 'self' ); ?>">
        </div>
        <div class="input-field-single">
            <label for="lname"><?php esc_html_e( 'Last Name', 'self' ); ?>* :</label>
            <input type="text" name="lname" id="cf-lname" placeholder="<?php esc_attr_e( 'Your Last Name Here', 'self' ); ?>">
        </div>
        <div class="input-field-single">
            <label for="email"><?php esc_html_e( 'Email', 'self' ); ?>* :</label>
            <input type="email" name="email" id="cf-email" placeholder="<?php esc_attr_e( 'Your Email Here', 'self' ); ?>">
        </div>
        <div class="input-field-single">
            <label for="message"><?php esc_html_e( 'Message', 'self' ); ?>:</label>
            <textarea name="message" id="cf-message" cols="30" rows="3" placeholder="<?php esc_attr_e( 'Your Message Here', 'self' ); ?>"></textarea>
        </div>
        <input type="hidden" name="action" value="self_contact_form">

        <?php wp_nonce_field( 'self_contact_form_action', '_contact_nonce' ); ?>

        <input type="submit" id="cf-submit" value="<?php apply_filters( 'ra_contactform_submit', esc_html_e( 'Send', 'self' ) ); ?>">

    </form>
</div>
<?php
