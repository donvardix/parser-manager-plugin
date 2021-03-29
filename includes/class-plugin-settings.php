<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Plugin_Settings') ) {

class Plugin_Settings {

	function __construct() {
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	function admin_menu() {
	    $frontend_settings = new Frontend_Settings();

		add_menu_page(
			__( 'Parser Manager', 'plugin-name' ),
			__( 'Parser Manager', 'plugin-name' ),
			'manage_options',
			'parser-manager-plugin.php',
			array( $frontend_settings, 'parsers_page' ),
			'dashicons-shortcode'
		);
		add_submenu_page(
			'parser-manager-plugin.php',
			__( 'Parser Manager', 'plugin-name' ),
			__( 'Parser Manager', 'plugin-name' ),
			'manage_options',
			'parser-manager-plugin.php',
			array( $frontend_settings, 'parsers_page' )
		);
		add_submenu_page(
			'parser-manager-plugin.php',
			__( 'Add New Parser', 'plugin-name' ),
			__( 'Add New', 'plugin-name' ),
			'manage_options',
			'parser-manager-add-new.php',
			array( $frontend_settings, 'add_new_parser' )
		);
		add_submenu_page(
			'parser-manager-plugin.php',
			__( 'Parser Manager Settings', 'plugin-name' ),
			__( 'Settings', 'plugin-name' ),
			'manage_options',
			'parser-manager-plugin-settings.php',
			array( $frontend_settings, 'settings_page' ),
		);
	}

	function db_create() {
		global $wpdb;

		$sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "parser` (
			id bigint NOT NULL AUTO_INCREMENT,
			name varchar(55) NOT NULL,
            url text NOT NULL,
            start text NOT NULL,
            end text NOT NULL,
            updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id),
			UNIQUE KEY name (name),
		);";
		$wpdb->query( $sql );

		$sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "parser_data` (
			id bigint NOT NULL AUTO_INCREMENT,
			value text NOT NULL,
            parser_id bigint NOT NULL,
            updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id)
		);";
		$wpdb->query( $sql );
	}

	function delete_options() {
		global $wpdb;

//        delete_option( 'wp_simyz_chat_username' );
//        $wpdb->query( "DROP TABLE IF EXISTS `" . $wpdb->prefix . "simyzchat_questions`;" );
	}

	function settings() {

	}

	function activation() {
		$this->settings();
		$this->db_create();
		register_uninstall_hook( __FILE__, array( $this, 'delete_options' ) );
	}

}

new Plugin_Settings();

} // class_exists check