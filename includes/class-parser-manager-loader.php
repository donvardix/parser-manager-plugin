<?php


class Parser_Manager_Loader {

	public function run() {

        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu() {
	    $frontend_settings = new Parser_Manager_Settings;

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
			array( $frontend_settings, 'settings_page' )
		);


        add_submenu_page(
            'parser-manager-plugin.php',
            __( 'Parsers Test', 'plugin-name' ),
            __( 'Parsers Test', 'plugin-name' ),
            'manage_options',
            'parsers-test.php',
            array( $frontend_settings, 'parsers_test_page' )
        );
	}

    public function activation() {
        $this->settings();
        $this->db_create();
        register_uninstall_hook( __FILE__, array( $this, 'delete_options' ) );
    }

    private function settings() {}

    private function db_create() {
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

    public function delete_options() {
//		global $wpdb;
//
//        delete_option( 'wp_simyz_chat_username' );
//        $wpdb->query( "DROP TABLE IF EXISTS `" . $wpdb->prefix . "simyzchat_questions`;" );
	}

}