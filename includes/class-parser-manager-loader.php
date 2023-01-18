<?php

defined( 'ABSPATH' ) || exit;

class Parser_Manager_Loader {

    function __construct() {
        add_filter( 'cron_schedules', [ $this, 'cron_schedules' ] );
    }

    public function run() {
        add_action( 'init', [ $this, 'plugin_init' ] );

        // wp cron
        add_action( 'parser_manager_add_to_queue', [ $this, 'add_to_queue' ] );
        add_action( 'parser_manager_queue_start', [ $this, 'queue_start' ] );

        if ( is_admin() ) {
            new Parser_Manager_Meta_Boxes;

            add_action( 'admin_menu', [ $this, 'admin_menu' ] );

            add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

            // ajax
            add_action( 'wp_ajax_test_request_parser', [ $this, 'test_request_parser' ] );
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

	    // Highcharts
	    wp_enqueue_script( 'highstock', plugins_url( 'assets/js/highcharts/highstock.js', PM_PLUGIN_FILE ), [], '10.3.2' );
	    wp_enqueue_script( 'highstock-exporting', plugins_url( 'assets/js/highcharts/exporting.js', PM_PLUGIN_FILE ), [], '10.3.2' );
	    wp_enqueue_script( 'highstock-export-data', plugins_url( 'assets/js/highcharts/export-data.js', PM_PLUGIN_FILE ), [], '10.3.2' );
	    wp_enqueue_script( 'highstock-accessibility', plugins_url( 'assets/js/highcharts/accessibility.js', PM_PLUGIN_FILE ), [], '10.3.2' );
    }

    public function test_request_parser() {
        $steam_parser = new Steam_Parser();

        $check_link = $steam_parser->parse_url( esc_url( $_POST['parser_link'] ) );

        if ( ! $check_link ) {
            wp_send_json_error( 'params error' );
        }

        $result = $steam_parser->run( 'sell_listings' );

        if ( ! $result ) {
            wp_send_json_error( 'result error' );
        }

        wp_send_json_success( [
            'result' => $result
        ] );
    }

    public function activation() {
        $this->settings();
        $this->db_create();
//        register_uninstall_hook( __FILE__, [ $this, 'delete_options' ] );
    }

    public function cron_schedules( $schedules ) {
        $schedules['five_minutes'] = [
            'interval' => 300,
            'display' => 'Every 5 Minutes'
        ];

        return $schedules;
    }

    private function settings() {
        // wp cron
        if( ! wp_next_scheduled( 'parser_manager_add_to_queue' ) ) {
            wp_schedule_event( time(), 'hourly', 'parser_manager_add_to_queue' );
        }
        if( ! wp_next_scheduled( 'parser_manager_queue_start' ) ) {
            wp_schedule_event( time(), 'five_minutes', 'parser_manager_queue_start' );
        }
    }

    public function add_to_queue() {
        PM_Utils::log( 'test parser_manager_queue' );
        $unix = time();
        $passed = $unix - 86400; // day

        $args = [
            'post_type' => 'parser',
            'meta_query' => [
                [
                    'relation' => 'OR',
                    [
                        'key' => 'parser_queue_added',
                        'compare_key' => 'NOT EXISTS'
                    ],
                    [
                        'key' => 'parser_queue_added',
                        'value' => 1,
                        'compare' => '!='
                    ]
                ],
                [
                    'relation' => 'OR',
                    [
                        'key' => 'parser_last_run',
                        'compare_key' => 'NOT EXISTS'
                    ],
                    [
                        'key' => 'parser_last_run',
                        'value' => $passed,
                        'compare' => '<='
                    ]
                ]
            ]
        ];

        $parsers = get_posts( $args );

        if ( $parsers ) {
            foreach ( $parsers as $parser ) {
                update_post_meta( $parser->ID, 'parser_queue_added', 1 );
            }
        }
    }
    public function queue_start() {
        $args = [
            'post_type' => 'parser',
            'meta_query' => [
                [
                    'key' => 'parser_queue_added',
                    'value' => 1
                ]
            ]
        ];

        $parsers = get_posts( $args );

        if ( $parsers ) {
            $steam_parser = new Steam_Parser;

            foreach ( $parsers as $parser ) {
                $unix = time();
                update_post_meta( $parser->ID, 'parser_queue_added', 0 );
                update_post_meta( $parser->ID, 'parser_last_run', $unix );

                $link = get_post_meta( $parser->ID, 'parser_link', true );

                $steam_parser->parse_url( $link );
                $data = $steam_parser->run( 'sell_listings' );

                if ( ! $data ) {
                    PM_Utils::log( 'queue_start() | empty data' );
                    $data = 'empty data';
                }

                $model = new Parser_Model;
                $model->add_parser_data( $parser->ID, $data );
            }
        }
    }

    private function db_create() {
        global $wpdb;

        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pmp_parser_data (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            parser_id BIGINT UNSIGNED NOT NULL,
			data varchar(255) NOT NULL,
            created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
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