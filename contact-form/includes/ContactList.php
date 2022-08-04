<?php
namespace Riyadh1734\ContactForm;

/**
 * Include WP_List_Table class
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
/**
 * The contact list table handler class
 */
class ContactList extends \WP_List_Table {
    /**
     * Initialize the class
     *
     * @since  1.0
     */
    public function __construct() {
        parent::__construct( [
            'singular' => __( 'Contact', 'self' ),
            'plural'   => __( 'Contacts', 'self' ),
            'ajax'     => false,
        ] );
    }

    /**
     * Prepare the contact enqueries
     *
     * @since 1.0
     *
     * @return void
     */
    public function prepare_items() {
        $columns  = $this->get_columns();
        $hidden   = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $columns, $hidden, $sortable ];

        $per_page     = 10;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $args = [
            'number' => $per_page,
            'offset' => $offset,

        ];

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'];
        }

        // Create instance of Contact Response Object
        $contact_response = new ContactResponse();

        $this->items = $contact_response->get_contact_responses( $args );

        $this->set_pagination_args( [
            'total_items' => $contact_response->contact_response_count(),
            'per_page'    => $per_page,
        ] );
    }

    /**
     * Message to show if no enquery found
     *
     * @since 1.0
     *
     * @return void
     */
    public function no_items() {
        echo __( 'No contact response found', 'self' );
    }

    /**
     * Get the column names
     *
     * @since 1.0
     *
     * @return array
     */
    public function get_columns() {
        $columns = [
            'cb'         => '<input type= "checkbox">',
            'first_name' => __( 'First Name', 'self' ),
            'last_name'  => __( 'Last Name', 'self' ),
            'email'      => __( 'Email', 'self' ),
            'message'    => __( 'Message', 'self' ),
            'ip'         => __( 'User IP', 'self' ),
            'created_at' => __( 'Date', 'self' )
        ];

        return $columns;
    }

    /**
     * Get the hidden columns
     *
     * @since 1.0
     *
     * @return array
     */
    public function get_hidden_columns() {
        return [];
    }

    /**
     * Get the sortable columns
     *
     * @since 1.0
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = [
            'first_name' => [ 'first_name', true ],
            'last_name'  => [ 'last_name', true ],
            'email'      => [ 'email', true ],
            'created_at' => [ 'created_at', true ],
        ];

        return $sortable_columns;
    }

    /**
     * Default column values
     *
     * @since 1.0
     *
     * @param object $item
     * @param string $column_name
     *
     * @return string
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {

            case 'created_at':
            return wp_date( get_option( 'date_format' ), strtotime( $item->created_at ) );

            default:
            return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Render the checkbox column
     *
     * @since 1.0
     *
     * @param object $item
     *
     * @return string
     */
    protected function column_cb( $item ) {
        return sprintf(
        '<input type="checkbox" name="address_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the bulk actions
     *
     * @since 1.0
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = [
            'trash' => __( 'Move to trash', 'self' ),
        ];

        return $actions;
    }
}
