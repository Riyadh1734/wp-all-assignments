<?php
/**
 * Plugin Name: Seo Meta
 * Description: Some seo meta information in site header
 * Plugin URI: http://sajuahmed.epizy.com
 * Author: Riyadh Ahmed
 * Author URI: http://sajuahmed.epizy.com
 * Version: 1.0
 * License: GPL2
 */

/*
    Copyright (C) Year  Author  Email

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if (! defined( 'ABSPATH' ) ) {
	exit;
}

function show_meta_info() {
	?>

	<meta name="description" content="You are going to be part of this meta info">
	<meta name="copyright" content="This info own by bhai bhai group">
    
	<?php
}

add_action( 'wp_head', 'show_meta_info');