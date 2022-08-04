<?php

namespace Riyadh1734\ContactForm;

/**
 * Shortcode handler class
 */
class Shortcode{
    /**
     * Initialize the class
     *
     * @since  1.0
     */
    public function __construct() {
        add_shortcode('self_form', [ $this, 'ra_self_contact_form' ] );
    }
    /**
     * Function for shortcode renderer
     *@since 1.0
     * @param $atts
     * @return void
     */
    public function ra_self_contact_form( $atts ) {
        $atts = shortcode_atts( apply_filters( 'ra_contactform_contents', [
            'title'       => __( 'Contact Us', 'self' ),
            'description' => __( 'Feel free to contact us.', 'self' ),
        ] ), $atts );

        /**
         * Turn array keys into variables
         */
        extract( $atts );

        /**
         * Enqueue form script and style
         */
        wp_enqueue_script( 'ra-contact-form-script' );
        wp_enqueue_style( 'ra-contact-form-style' );

        /**
         * Include contact form template
         */
        ob_start();
        include_once Ra_Contact_Form_PATH . '/templates/shortcode_contact_form.php';
        return ob_get_clean();
    }
        
}