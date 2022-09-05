<?php
/**
 * Template: Recent posts checkbox fields template
 *
 * HMTL template for recent posts dashboard widget checkbox fields
 *
 * @since 1.0.0
 */
?>
<input type="checkbox" name="<?php echo esc_attr( 'recent_posts_cats[' . $cat_slug . ']' ); ?>" id="<?php echo esc_attr( 'recent_posts_cats[' . $cat_slug . ']' ); ?>" value="<?php echo esc_attr( $cat_name ); ?>" <?php checked( $cat_name, $current_cat ); ?>>
<label for="<?php echo esc_attr( 'recent_posts_cats[' . $cat_slug . ']' ); ?>"> <?php echo esc_html( $cat_name ); ?></label>
<?php
