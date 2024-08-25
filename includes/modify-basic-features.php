<?php

/**
 * Remove Unnecessary Menu Items
 * @return void
 */
function remove_unnecessary_menu_items() {
	remove_menu_page( 'themes.php' );
}

/**
 * Restricted Users to go [ Appearance ]
 * @return void
 */
function redirect_user_from_restricted_pages() {
	$current_page     = basename( $_SERVER['PHP_SELF'] );
	$restricted_pages = array(
		'themes.php',
		'site-editor.php',
	);
	if ( in_array( $current_page, $restricted_pages ) ) {
		wp_redirect( admin_url() );
		exit;
	}
}

add_action( 'admin_menu', 'remove_unnecessary_menu_items', 999 );
add_action( 'admin_init', 'redirect_user_from_restricted_pages' );
