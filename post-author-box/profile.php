<?php

function solids_user_contact_methods( $methods ) {

	$methods ['twitter']  = __('Twitter', 'solids');
	$methods ['facebook'] = __('Facebook', 'solids');
    $methods ['github']   = __('Github', 'solids');

	return $methods;
}
add_filter( 'user_contactmethods', 'solids_user_contact_methods');