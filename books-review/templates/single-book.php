<?php
/**
 * templates for all single posts
 */
get_header();
   /**
    * Enqueue styles and scripts
    */
   wp_enqueue_script('ra-ratyli-js');
   wp_enqueue_script('ra-ratyli-rating-js');
   wp_enqueue_style('ra-ratyli-css');

   global $post;
   $post_id = isset( $post-> ID )? (int) $post->ID : 0;

    $single_post_writter = get_post_meta( $post->ID, 'book_meta_key_writter', true );
    $single_post_isbn    = get_post_meta( $post->ID, 'book_meta_key_isbn', true );
    $single_post_year    = get_post_meta( $post->ID, 'book_meta_key_year', true );
    $single_post_price   = get_post_meta( $post->ID, 'book_meta_key_price', true );
    $single_post_desc    = get_post_meta( $post->ID, 'book_meta_key_description', true );

      $args = [
         'post_id' => $post_id,
      ];
      // Fetching single rating data of current post
      $book_rating_result = ra_get_rating( $args );
      $book_rating        = isset( $book_rating_result->rating ) ? (float) $book_rating_result->rating : 0;
      $book_rating_id     = isset( $book_rating_result->id ) ? (int) $book_rating_result->id: '';
      
    ?>
      <div id    = "book-review" class = "container">
      <h2  class = "book-title"><?php esc_html_e( $post-> post_title ); ?></h2>
      <div class = "book-review-content clearfix">
      <div class = "book-review-thumb float-left">
      <ul  class = "book-review-details-list">
         <li>
         <span><?php esc_html_e( 'Writter :', 'Ra_Books_Review' ); ?></span>
         <?php echo esc_html( $single_post_writter ); ?>
         </li>
         <li>
         <span><?php esc_html_e( 'Isbn :', 'Ra_Books_Review' ); ?></span>
         <?php echo esc_html( $single_post_isbn ); ?>
         </li>
         <li>
         <span><?php esc_html_e( 'Year :', 'Ra_Books_Review' ); ?></span>
         <?php echo esc_html( $single_post_year ); ?>
         </li>
         <li>
         <span><?php esc_html_e( 'Price :', 'Ra_Books_Review' ); ?></span>
         <?php echo esc_html( $single_post_price ); ?>
         </li>
         <li>
         <span><?php esc_html_e( 'Description :','Ra_Books_Review' ); ?></span>
         <?php echo esc_textarea( $single_post_desc ); ?>
         </li>
         <li>
         <span class="ratyli" data-rate="<?php echo esc_attr( $book_rating ); ?>" data-post-id="<?php echo esc_attr( $post_id ); ?>" data-rating-id="<?php echo esc_attr( $book_rating_id ); ?>"></span>
         <input class="book-rating" type = "hidden" name = "book_review_rating" value = "0" />
         </li>
      </ul>
      </div>
      </div>
      </div>
   <?php
get_footer();