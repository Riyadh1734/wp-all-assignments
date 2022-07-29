<?php

namespace Riyadh1734\BooksReview;

/**
 * Assets handlers class
 * 
 * @since 1.0
 */
class Assets {
    /**
     * Class constructor
     */
    public function __construct() {

        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_assets']);
    }
    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        
        return [
            'ra-ratyli-js' => [
                'src'     => Ra_Books_Review_ASSETS . '/js/jquery.ratyli.min.js',
                'version' => filemtime( Ra_Books_Review_PATH . '/assets/js/jquery.ratyli.min.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'ra-ratyli-rating-js' => [
                'src'     => Ra_Books_Review_ASSETS . '/js/rating.js',
                'version' => filemtime( Ra_Books_Review_PATH . '/assets/js/rating.js' ),
                'deps'    => [ 'jquery' ]
            ]
        ];
    }
    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        
        return [
            'ra-ratyli-css' => [
                'src'     => Ra_Books_Review_ASSETS . '/css/book-rating-style.css',
                'version' => filemtime( Ra_Books_Review_PATH . '/assets/css/book-rating-style.css' )
            ]
        ];
    }
    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {

        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }
        /**
         * Book rating localized script
         */
        wp_localize_script( 'ra-ratyli-rating-js', 'BookRatings', [
            'ajaxurl'      => admin_url( 'admin-ajax.php' ),
            'rating_nonce' => wp_create_nonce( 'book-review-nonce' ),
            'error'        => __( 'Something went wrong!', 'Ra_Books_Review' ),
        ] );
    }
}
