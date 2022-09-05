<?php
/**
 * Template: related posts widget output
 *
 * HT preview template for releted posts widget output
 *
 * @since 1.0.0
 * 
 * @by Riyadh
 */
?>
<div class="single-post">
    <h5><a href="<?php echo esc_url( the_permalink() ) ; ?>"><?php echo esc_html( the_title() ); ?></a></h5>
    <?php
    if ( ! empty( $thumbnail ) ) {
        echo wp_kses_post( the_post_thumbnail( [ 120, 120 ] ) );
    }

    if ( ! empty( $excerpt ) ) {
        echo esc_html( the_excerpt() );
    }
    ?>
</div>
<?php
