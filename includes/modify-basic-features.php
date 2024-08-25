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

function restrict_plugin_installation( $response, $hook_extra ) {
	$allowed_plugin_slugs = [ 'wordpress-seo', 'seo-by-rank-math', 'laraword-admin-controller' ];
	if ( isset( $hook_extra['slug'] ) && ! in_array( $hook_extra['slug'], $allowed_plugin_slugs ) ) {
		return new WP_Error( 'plugin_install_blocked', __( 'You do not have permission to install this plugin.' ) );
	}

	return $response;
}

function restrict_plugin_activation( $plugin ) {
	$allowed_plugin_files = [
		'wordpress-seo/wp-seo.php',
		'seo-by-rank-math/rank-math.php',
		'laraword-admin-controller/laraword-admin-controller.php'
	];
	if ( ! in_array( $plugin, $allowed_plugin_files ) ) {
		deactivate_plugins( $plugin );
		wp_die( __( 'You do not have permission to activate this plugin.' ) );
	}
}

function restrict_plugin_page( $plugins ) {
	$allowed_plugin_files = [
		'wordpress-seo/wp-seo.php',
		'seo-by-rank-math/rank-math.php',
		'laraword-admin-controller/laraword-admin-controller.php'
	];
	foreach ( $plugins as $plugin_file => $plugin_data ) {
		if ( ! in_array( $plugin_file, $allowed_plugin_files ) ) {
			unset( $plugins[ $plugin_file ] );
		}
	}

	return $plugins;
}
add_action( 'activate_plugin', 'restrict_plugin_activation' );
add_action( 'admin_menu', 'remove_unnecessary_menu_items', 999 );
add_action( 'admin_init', 'redirect_user_from_restricted_pages' );
add_filter( 'upgrader_pre_install', 'restrict_plugin_installation', 10, 2 );
add_action('upgrader_process_complete', 'remove_all_plugins_after_install', 10, 2);
add_filter( 'all_plugins', 'restrict_plugin_page' );
