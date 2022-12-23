<?php

defined( 'ABSPATH' ) || exit;

class Parser_Manager_Loader {

    private $utils;

    function __construct() {
        $this->utils = new Parser_Manager_Utils();
    }

    public function run() {
        add_action( 'init', [ $this, 'plugin_init' ] );

        if ( is_admin() ) {
            new Parser_Manager_Meta_Boxes;

            add_action( 'admin_menu', [ $this, 'admin_menu' ] );

            add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
        }
    }

    public function plugin_init() {
        register_post_type(
            'parser',
            [
                'labels'        => [
                    'name'               => __( 'Parsers', 'wcpv-returns' ),
                    'singular_name'      => __( 'Parser', 'wcpv-returns' ),
                    'all_items'          => __( 'All Parsers', 'wcpv-returns' ),
                    'search_items'       => __( 'Search Parsers', 'wcpv-returns' ),
                    'not_found'          => __( 'No parsers found.', 'wcpv-returns' ),
                    'not_found_in_trash' => __( 'No parsers found in Trash.', 'wcpv-returns' ),
                    'menu_name'          => __( 'Parsers Manager', 'wcpv-returns' )
                ],
                'public'        => true,
                'show_ui'       => true,
                'has_archive'   => true,
                'menu_icon'     => 'dashicons-feedback',
                'menu_position' => 21,
                'supports'      => [ 'title', 'author' ],
            ]
        );
    }

    public function admin_menu() {
        $frontend_settings = new Parser_Manager_Settings;

        add_submenu_page(
            'edit.php?post_type=parser',
            __( 'Parser Manager Settings', 'plugin-name' ),
            __( 'Settings', 'plugin-name' ),
            'manage_options',
            'parser-manager-settings.php',
            [ $frontend_settings, 'settings_page' ]
        );
        add_submenu_page(
            'edit.php?post_type=parser',
            __( 'Parsers Test', 'plugin-name' ),
            __( 'Parsers Test', 'plugin-name' ),
            'manage_options',
            'parsers-test.php',
            [ $frontend_settings, 'parsers_test_page' ]
        );
    }

    public function admin_enqueue_scripts() {
        $suffix  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style( 'parser-manager', plugins_url( "assets/css/style{$suffix}.css", PM_PLUGIN_FILE ), '', PM_VERSION );
        wp_enqueue_script( 'parser-manager', plugins_url( "assets/js/script{$suffix}.js", PM_PLUGIN_FILE ), [ 'jquery' ], PM_VERSION, true );
    }

    public function activation() {
        $this->settings();
        $this->db_create();
//        register_uninstall_hook( __FILE__, [ $this, 'delete_options' ] );
    }

    private function settings() {}

    private function db_create() {
        global $wpdb;

        $sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "prsrmngr_parser_data` (
			id bigint NOT NULL AUTO_INCREMENT,
			value text NOT NULL,
            parser_id bigint NOT NULL,
            updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id)
		);";
        $wpdb->query( $sql );
    }

    public function delete_options() {
        $this->utils->log( 'plugin_uninstall_hook' );
//		global $wpdb;
//
//        delete_option( 'wp_simyz_chat_username' );
//        $wpdb->query( "DROP TABLE IF EXISTS `" . $wpdb->prefix . "simyzchat_questions`;" );
    }

}