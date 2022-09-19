<?php 
/**
 * Plugin Name: Author Bio Box
 * Description: A plugin that shows the author bio every under the post 
 * Plugin URI: http://sajuahmed.epizy.com/
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com/
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: solids
 * Domain Path: /languages
 */

//don't call the file directly
if (!defined('ABSPATH')) exit;

if ( is_admin() ){

    require_once __DIR__ . '/profile.php';
}

function solids_author_bio($content) {
    global $post;

    $author = get_user_by('id', $post->post_author);

    

    $bio      = get_user_meta( $author->ID, 'description', true );
    $twitter  = get_user_meta( $author->ID, 'twitter', true );
    $facebook = get_user_meta( $author->ID, 'facebook', true );
    $github   = get_user_meta( $author->ID, 'github', true );

    ob_start();
    ?>
    <div class="solids-bio-wrap">

        <div class="avatar-image">
            <?php echo get_avatar( $author->ID, 64 ); ?>
        </div>

        <div class="solids-bio-content">
            <div class="author-name"><?php echo $author->display_name; ?></div>

            <div class="solids-author-bio">
                <?php echo wpautop( wp_kses_post( $bio ) ); ?>
            </div>

            <ul class="solids-socials">
                <?php if ( $twitter ) { ?>
                    <li><a href="<?php echo esc_url( $twitter ); ?>"><?php _e( 'Twitter', 'solids' ); ?></a></li>
                <?php } ?>

                <?php if ( $facebook ) { ?>
                    <li><a href="<?php echo esc_url( $facebook ); ?>"><?php _e( 'Facebook', 'solids' ); ?></a></li>
                <?php } ?>

                <?php if ( $github ) { ?>
                    <li><a href="<?php echo esc_url( $github ); ?>"><?php _e( 'Github', 'solids' ); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php
    $bio_content = ob_get_clean();

    return $content . $bio_content;
}
add_filter('the_content', 'solids_author_bio');

function solids_enqueue_scripts() {

wp_enqueue_style ('solids-style', plugins_url('/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'solids_enqueue_scripts');
