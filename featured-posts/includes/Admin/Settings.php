<?php

namespace Riyadh1734\FeaturedPosts\Admin;

class Settings {
    /**
     * Class constructor
     * 
     * @since 1.0
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'custom_settings_handler']);
    }
    public function get_registers() {
        $registers = apply_filters( 'ra_settings_registers_fp', [
            [
                'option_group' => 'featured-posts',
                'option_name'  => 'featured_posts_limit',
            ],
            [
                'option_group' => 'featured-posts',
                'option_name'  => 'featured_posts_order',
            ],
            [
                'option_group' => 'featured-posts',
                'option_name'  => 'featured_posts_categories',
            ],
        ] );
        return $registers;
    }

    public function get_sections() {
        $sections = apply_filters( 'ra_settings_sections_fp', [
            'featured_posts_section' => [
                'title'    => __('Featured Posts Selector', 'ra-featured-posts'),
                'callback' => [ $this, 'ra_settings_sections'],
                'page'     => 'featured-posts',
            ],
        ]);
        return $sections;
    }

    public function get_fields() {

        $object_settings_fields = new SettingsFields();

        $fields = apply_filters( 'ra_settings_fields_fp', [
            'featured_posts_field_limit'    => [
                'title'    => __( 'Number of Posts', 'ra-featured-posts' ),
                'callback' => [ $object_settings_fields, 'limit_field_fp' ],
                'page'     => 'featured-posts',
                'section'  => 'featured_posts_section',
            ],
            'featured_posts_field_order'     => [
                'title'    => __( 'Post Order', 'ra-featured-posts' ),
                'callback' => [ $object_settings_fields, 'order_field_fp' ],
                'page'     => 'featured-posts',
                'section'  => 'featured_posts_section',
            ],
            'featured_posts_field_categories' => [
                'title'    => __( 'Post Categories', 'ra-featured-posts' ),
                'callback' => [ $object_settings_fields, 'categories_fields_fp' ],
                'page'     => 'featured-posts',
                'section'  => 'featured_posts_section',
            ],
        ] );

        return $fields;
    }

    /**
     * Custom settings handler function
     *
     * @since  1.0
     *
     * @return void
     */
    public function custom_settings_handler() {
        $registers = $this->get_registers();
        $sections  = $this->get_sections();
        $fields    = $this->get_fields();

        // Looping through settings registers
        foreach ( $registers as $register ) {
            $args = isset( $register['args'] ) ? $register['args'] : '';

            // Register each custom settings
            register_setting( $register['option_group'], $register['option_name'], $args );
        }

        // Looping through settings sections
        foreach ( $sections as $id => $section ) {
            // Adds each settings section
            add_settings_section( $id, $section['title'], $section['callback'], $section['page'] );
        }

        // Looping through settings fields
        foreach ( $fields as $id => $field ) {
            $section = isset( $field['section'] ) ? $field['section'] : '';
            $args    = isset( $field['args'] ) ? $field['args'] : '';

            // Adds each settings field
            add_settings_field( $id, $field['title'], $field['callback'], $field['page'], $section, $args );
        }
    }

    /**
     * Featured posts settings section callback function
     *
     * @since 1.0
     *
     * @return void
     */
    public function ra_settings_sections() {
        ?>
        <p><?php apply_filters( 'ra_settings_section_title_fp', esc_html_e( 'Choose featured posts to show', 'ra-featured-posts' ) ); ?></p>
        <?php
    }
}