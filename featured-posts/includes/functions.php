<?php
/**
 * Featured posts trasient remover function
 *
 * @since 1.0
 *
 * @return boolean
 */
function ra_delete_transient_fp() {
    
    delete_transient( 'featured_posts_query' );
}