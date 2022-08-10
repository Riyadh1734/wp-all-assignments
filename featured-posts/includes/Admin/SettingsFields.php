<?php

namespace Riyadh1734\FeaturedPosts\Admin;

class SettingsFields {

    public function limit_field_fp() {
        $current_limit = get_option( 'featured_posts_limit' );
        ?>
        <input id="featured_posts_limit" type="text" name="featured_posts_limit" class="regular-text" 
        placeholder="<?php esc_attr_e( 'Number of Posts', 'ra-featured-posts' ); ?>" value="<?php echo esc_attr( $current_limit ); ?>" >
        <?php
    }

    public function order_field_fp() {
        $current_order = get_option( 'featured_posts_order' );
        ?>
        <select id="featured_posts_order" name="featured_posts_order">
            <option value="<?php echo esc_attr( 'rand' ); ?>" <?php selected( $current_order, 'rand' ); ?>><?php esc_html_e( 'Random', 'ra-featured-posts' ); ?></option>
            <option value="<?php echo esc_attr( 'ASC' ); ?>" <?php selected( $current_order, 'ASC' ); ?>><?php esc_html_e( 'ASC', 'ra-featured-posts' ); ?></option>
            <option value="<?php echo esc_attr( 'DESC' ); ?>" <?php selected( $current_order, 'DESC' ); ?>><?php esc_html_e( 'DESC', 'ra-featured-posts' ); ?></option>
        </select>
        <?php
    }

    public function categories_fields_fp() {

        $current_cats = get_option( 'featured_posts_categories', [] );

        $args = apply_filters( 'categories_args_fp', [
            'orderby' => 'name',
            'order'   => 'ASC',
        ] );

        $categories = get_categories( $args );
        
        foreach ( $categories as $category ) {
            $cat_name = (string) $category->name;
            $cat_slug = (string) $category->slug;

            $current_checked = in_array( $cat_slug, $current_cats ) ? 'checked' : '';

            ?>
            <input type="checkbox" id="<?php echo esc_attr( 'post_cat_' . $cat_slug ); ?>" name="<?php echo esc_attr( 'featured_posts_categories[' . $cat_slug . ']' ); ?>"
             value="<?php echo esc_attr( $cat_slug ); ?>" <?php echo esc_html( $current_checked ); ?>>
            <label for="<?php echo esc_attr( 'post_cat_' . $cat_slug ); ?>"> <?php echo esc_html( $cat_name ); ?></label><br>
            <?php
        }
        
    }

}