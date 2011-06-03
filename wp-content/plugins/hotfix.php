<?php
/*
Plugin Name: Hotfix
Description: Provides "hotfixes" for selected WordPress bugs, so you don't have to wait for the next WordPress core release. Keep the plugin updated!
Version: 0.5
Author: Mark Jaquith
Author URI: http://coveredwebservices.com/
*/

// This bootstraps everything
WP_Hotfix_Controller::init();

class WP_Hotfix_Controller {
	function init() {
		add_action( 'init', 'wp_hotfix_init' );
		register_activation_hook(   __FILE__, array( __CLASS__, 'activate'   ) );
		register_deactivation_hook( __FILE__, array( __CLASS__, 'deactivate' ) );
	}
	function activate() {
		add_option( 'hotfix_version', '1' );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}
	function deactivate() {
		delete_option( 'hotfix_version' );
	}
	function uninstall() {
		self::deactivate(); // The same, for now
	}
}

function wp_hotfix_init() {
	global $wp_version;

	$hotfixes = array();

	switch ( $wp_version ) {
		case '3.1.3' :
			$hotfixes = array( '313_post_status_query_string' );
			break;
		case '3.1' :
			$hotfixes = array( '310_parsed_tax_query' );
			break;
		case '3.0.5' :
			$hotfixes = array( '305_comment_text_kses' );
			break;
	}

	$hotfixes = apply_filters( 'wp_hotfixes', $hotfixes );

	foreach ( (array) $hotfixes as $hotfix ) {
		call_user_func( 'wp_hotfix_' . $hotfix );
	}
}

/* And now, the hotfixes */

function wp_hotfix_305_comment_text_kses() {
	remove_filter( 'comment_text', 'wp_kses_data' );
	if ( is_admin() )
		add_filter( 'comment_text', 'wp_kses_post' );
}

function wp_hotfix_310_parsed_tax_query() {
	add_filter( 'pre_get_posts', 'wp_hotfix_310_parsed_tax_query_pre_get_posts' );
}

	function wp_hotfix_310_parsed_tax_query_pre_get_posts( $q ) {
		@$q->parsed_tax_query = false; // Force it to be re-parsed.
		return $q;
	}

function wp_hotfix_313_post_status_query_string() {
	add_filter( 'request', 'wp_hotfix_313_post_status_query_string_request' );
}

	function wp_hotfix_313_post_status_query_string_request( $qvs ) {
		if ( isset( $qvs['post_status'] ) && is_array( $qvs['post_status'] ) )
			$qvs['post_status'] = implode( ',', $qvs['post_status'] );
		return $qvs;
	}