<?php

defined( 'ABSPATH' ) || exit;

class Parser_Manager_Loader {

    function __construct() {
        add_filter( 'cron_schedules', [ $this, 'cron_schedules' ] );
    }

    public function init() {
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
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style( 'parser-manager', plugins_url( "assets/css/style{$suffix}.css", PMP_PLUGIN_FILE ), '', PMP_VERSION );
        wp_enqueue_script( 'parser-manager', plugins_url( "assets/js/script{$suffix}.js", PMP_PLUGIN_FILE ), [ 'jquery' ], PMP_VERSION, true );

        // Highcharts
        wp_enqueue_script( 'highstock', plugins_url( 'assets/js/highcharts/highstock.js', PMP_PLUGIN_FILE ), [], '10.3.2' );
        wp_enqueue_script( 'highstock-exporting', plugins_url( 'assets/js/highcharts/exporting.js', PMP_PLUGIN_FILE ), [], '10.3.2' );
        wp_enqueue_script( 'highstock-export-data', plugins_url( 'assets/js/highcharts/export-data.js', PMP_PLUGIN_FILE ), [], '10.3.2' );
        wp_enqueue_script( 'highstock-accessibility', plugins_url( 'assets/js/highcharts/accessibility.js', PMP_PLUGIN_FILE ), [], '10.3.2' );
    }

    public function run_parser_by_id( $id ) {
        $method = get_post_meta( $id, 'parser_method', true );
        $link   = get_post_meta( $id, 'parser_link', true );

        switch ( $method ) {
            case 'steam':
                $steam_parser = new Steam_Parser;
                $steam_parser->parse_url( $link );

                return $steam_parser->run( 'sell_listings' );
            case 'selector':
                $parser_start = get_post_meta( $id, 'parser_start', true );
                $parser_end   = get_post_meta( $id, 'parser_end', true );

                $selector_parser = new Substr_Parser( $link );

                return $selector_parser->run( $parser_start, $parser_end );
            default:
                return false;
        }
    }

    public function test_request_parser() {
        switch ( $_POST['parser_method'] ) {
            case 'steam':
                $steam_parser = new Steam_Parser;
                $check_link   = $steam_parser->parse_url( esc_url( $_POST['parser_link'] ) );

                if ( ! $check_link ) {
                    wp_send_json_error( 'link error' );
                }

                $data = $steam_parser->run( 'sell_listings' );

                if ( ! $data ) {
                    wp_send_json_error( 'parser error' );
                }

                // todo move to add parser

//			    $model = new Parser_Model;
//			    $model->add_parser_data( $_POST['post_id'], $data );

                wp_send_json_success( [
                    'html' => "Quantity: {$data['y']}, Price: {$data['a1']}"
                ] );

            default:
                wp_send_json_error( 'method not found' );
        }
    }

    public function activation() {
        $this->settings();
        $this->db_create();
    }

    public function cron_schedules( $schedules ) {
        $schedules['five_minutes'] = [
            'interval' => 300,
            'display'  => 'Every 5 Minutes'
        ];

        return $schedules;
    }

    private function settings() {
        // wp cron
        if ( ! wp_next_scheduled( 'parser_manager_add_to_queue' ) ) {
            wp_schedule_event( time(), 'hourly', 'parser_manager_add_to_queue' );
        }
        if ( ! wp_next_scheduled( 'parser_manager_queue_start' ) ) {
            wp_schedule_event( time(), 'five_minutes', 'parser_manager_queue_start' );
        }
    }

    public function add_to_queue() {
        $unix   = time();
        $passed = $unix - 86400; // day

        $args = [
            'post_type'  => 'parser',
            'meta_query' => [
                [
                    'relation' => 'OR',
                    [
                        'key'         => 'parser_queue_added',
                        'compare_key' => 'NOT EXISTS'
                    ],
                    [
                        'key'     => 'parser_queue_added',
                        'value'   => 1,
                        'compare' => '!='
                    ]
                ],
                [
                    'relation' => 'OR',
                    [
                        'key'         => 'parser_last_run',
                        'compare_key' => 'NOT EXISTS'
                    ],
                    [
                        'key'     => 'parser_last_run',
                        'value'   => $passed,
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
            'post_type'  => 'parser',
            'meta_query' => [
                [
                    'key'   => 'parser_queue_added',
                    'value' => 1
                ]
            ]
        ];

        $parsers = get_posts( $args );

        if ( ! $parsers ) {
            return;
        }

        foreach ( $parsers as $parser ) {
            update_post_meta( $parser->ID, 'parser_queue_added', 0 );
            update_post_meta( $parser->ID, 'parser_last_run', time() );

            $data = $this->run_parser_by_id( $parser->ID );

            if ( $data ) {
                $model = new Parser_Model;
                $model->add_parser_data( $parser->ID, $data );
                PMP_Utils::log( 'add_parser_data() | ' . $data, $parser->ID, true );
            } else {
                PMP_Utils::log( 'queue_start() | empty data', $parser->ID );
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
}