<?php
namespace Riyadh1734\BooksReview;

class Customptype {

    /**
     * Initialize the class
     * 
     * @since 1.0
     */
    public function __construct() {
        add_action( 'init', [ $this, 'ra_custom_post_book' ] );
        add_filter( 'single_template', [ $this, 'load_book_template' ] );
    }

    public function load_book_template( $template ) {
        global $post;

        if ( 'book' === $post->post_type && locate_template( [ 'single-book.php' ] ) !== $template ) {
            return Ra_Books_Review_PATH . '/templates/single-book.php';
        }

        return $template;
    }

    /**
     * Custom post type for books
     * 
     * @since 1.0
     *
     * @return void
     */
    public function ra_custom_post_book() {

    $labels = array(
        'name'                  => _x( 'Books', 'Book General Name', 'Ra_Books_Review' ),
        'singular_name'         => _x( 'Book', 'Book Singular Name', 'Ra_Books_Review' ),
        'menu_name'             => __( 'Books', 'Ra_Books_Review' ),
        'name_admin_bar'        => __( 'Book', 'Ra_Books_Review' ),
        'archives'              => __( 'Item Archives', 'Ra_Books_Review' ),
        'attributes'            => __( 'Item Attributes', 'Ra_Books_Review' ),
        'parent_item_colon'     => __( 'Parent Item:', 'Ra_Books_Review' ),
        'all_items'             => __( 'All Items', 'Ra_Books_Review' ),
        'add_new_item'          => __( 'Add New Item', 'Ra_Books_Review' ),
        'add_new'               => __( 'Add New', 'Ra_Books_Review' ),
        'new_item'              => __( 'New Item', 'Ra_Books_Review' ),
        'edit_item'             => __( 'Edit Item', 'Ra_Books_Review' ),
        'update_item'           => __( 'Update Item', 'Ra_Books_Review' ),
        'view_item'             => __( 'View Item', 'Ra_Books_Review' ),
        'view_items'            => __( 'View Items', 'Ra_Books_Review' ),
        'search_items'          => __( 'Search Item', 'Ra_Books_Review' ),
        'not_found'             => __( 'Not found', 'Ra_Books_Review' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'Ra_Books_Review' ),
        'featured_image'        => __( 'Featured Image', 'Ra_Books_Review' ),
        'set_featured_image'    => __( 'Set featured image', 'Ra_Books_Review' ),
        'remove_featured_image' => __( 'Remove featured image', 'Ra_Books_Review' ),
        'use_featured_image'    => __( 'Use as featured image', 'Ra_Books_Review' ),
        'insert_into_item'      => __( 'Insert into item', 'Ra_Books_Review' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'Ra_Books_Review' ),
        'items_list'            => __( 'Items list', 'Ra_Books_Review' ),
        'items_list_navigation' => __( 'Items list navigation', 'Ra_Books_Review' ),
        'filter_items_list'     => __( 'Filter items list', 'Ra_Books_Review' ),
    );
    $args = array(
        'label'                 => __( 'Book', 'Ra_Books_Review' ),
        'description'           => __( 'Book Description', 'Ra_Books_Review' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies'            => array( 'category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 11,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'menu_icon'             => 'dashicons-book'
    );
    register_post_type( 'book', $args );
    }
}