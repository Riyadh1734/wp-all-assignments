<?php
/**
 * Plugin Name: Contact Form
 * Description: You can submit your info via this form
 * Plugin URI: http://sajuahmed.epizy.com
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com
 * Version: 1.0
 * License: GPL2
 */

/*
    Copyright (C) Year  Author  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Include the autoloader
 */
if ( ! file_exists( __DIR__ . "/vendor/autoload.php" ) ) {
    wp_die( 'Composer auto-loader missing. Run "composer update" command on this plugin.' );
}
require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class SCF_Shortcode {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class construcotr
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        add_shortcode('self_form', [ $this, 'self_contact_form' ] );
    }

    function self_contact_form( $atts ) {
        //var_dump($_POST);
        
        $atts = shortcode_atts( [
            'email'  => get_option( 'admin_email' ),
            'submit' => __( 'Send', 'self' )
        ], $atts );

        $email_sent = $this->email_handler( $_POST );

        ob_start();
        
        ?>

        <form action="" id="self_contact" method="post">
            <p>
                <label for="fname">First Name</label>
                <input id="fname" type="text" name="self_fname" value="">
                <label for="lname">Last Name</label>
                <input id="lname" type="text" name="self_lname" value="">
            </p>

            <p>
                <label for="email">Email</label>
                <input id="email" type="email" name="self_email" value="">
            </p>

            <p>
                <label for="subject">Subject</label>
                <input id="subject" type="text" name="self_subject" value="">
            </p>

            <p>
                <label for="message">Message</label>
                <textarea name="self_message" id="message" rows= "4" cols="50"></textarea>
            </p>

            <p>
                <?php wp_nonce_field( 'self_contact_form_action', 'self_contact_form_nonce' ); ?>
                <input type="submit" name="self_submit" value="<?php echo esc_attr( $atts['submit'])?>">
            </p>
        </form>

        <?php if ( $email_sent ) : ?>
            <h1><?php _e( 'Email sent succesfully', 'self') ?></h1>
        <?php endif; ?>

        <?php
        return ob_get_clean();
    }

    public function email_handler( $post ) {

        $first_name      = ! empty( $_POST['self_fname'] ) ? sanitize_text_field( wp_unslash( $_POST['self_fname'] ) ) : '';
        $last_name       = ! empty( $_POST['self_lname'] ) ? sanitize_text_field( wp_unslash( $_POST['self_lname'] ) ) : '';
        $email_id        = ! empty( $_POST['self_email'] ) ? sanitize_email( wp_unslash( $_POST['self_email'] ) ) : '';
        $subject_content = ! empty( $_POST['self_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['self_subject'] ) ) : '';
        $message_content = ! empty( $_POST['self_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['self_message'] ) ) : '';

        if ( ! isset( $post['self_submit']) ) {
            return;
        }

        if ( ! isset( $post['self_contact_form_nonce']) || ! wp_verify_nonce( $post['self_contact_form_nonce'], 'self_contact_form_action' ) ) {
            esc_html_e( 'Nonce verification failed!', 'self' );
            return;
        }

        if ( empty( $first_name ) ) {
            esc_html_e( 'First name can not be empty!', 'self' );
            return;
        }

        if ( empty( $last_name) ) {
            esc_html_e( 'Last name can not be empty!', 'self' );
            return;
        }

        if ( empty( $email_id ) ) {
            esc_html_e( 'Email id can not be empty!', 'self' );
            return;
        }

        if ( empty( $subject_content ) ) {
            esc_html_e( 'Subject can not be empty!', 'self' );
            return;
        }

        if ( empty( $message_content ) ) {
            esc_html_e( ' Message field can not be empty!', 'self' );
            return;
        }


        $subject = "Contact message from {$_POST['self_fname']} {$_POST['self_lname']}";
        $email   = $_POST['self_email'];
        $message = $_POST['self_message'];

        $submit = wp_mail( $email, $subject, $message );

        return $submit;
    }
  
    /**
     * Initializes a singleton instance
     *
     * @return \SCF_Shortcode
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'SCF_SHORTCODE_VERSION', self::version );
        define( 'SCF_SHORTCODE_FILE', __FILE__ );
        define( 'SCF_SHORTCODE_PATH', __DIR__ );
        define( 'SCF_SHORTCODE_URL', plugins_url( '', SCF_SHORTCODE_FILE ) );
    }

   /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'scf_shortcode_installed' );

        if ( ! $installed ) {
            update_option( 'scf_shortcode_installed', time() );
        }
        update_option( 'scf_shortcode_version', SCF_SHORTCODE_VERSION );
    }
}

/**
 * Initializes the main plugin
 *
 * @return \SCF_Shortcode
 */
function scf_shortcode() {
    return SCF_Shortcode::init();
}

// kick-off the plugin
scf_shortcode();
