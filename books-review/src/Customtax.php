<?php
namespace Riyadh1734\BooksReview;

class Customtax {

    /**
     * Initialize the class
     * 
     * @since 1.1
     */
    public function __construct() {
        add_action( 'init',[ $this, 'book_register_taxo' ] );
    }


    function book_register_taxo() {
        $labels = array(
            'name'              => _x( 'Topics', 'taxonomy general name' ),
            'singular_name'     => _x( 'Topic', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Topics' ),
            'all_items'         => __( 'All Topics' ),
            'parent_item'       => __( 'Parent Topic' ),
            'parent_item_colon' => __( 'Parent Topic:' ),
            'edit_item'         => __( 'Edit Topic' ),
            'update_item'       => __( 'Update Topic' ),
            'add_new_item'      => __( 'Add New Topic' ),
            'new_item_name'     => __( 'New Topic Name' ),
            'menu_name'         => __( 'Topic' ),
        );
        $args   = array(
            'hierarchical'      => true, // make it hierarchical (like categories)
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'Topic' ],
        );
        register_taxonomy( 'Topic', [ 'book' ], $args );
   }
}