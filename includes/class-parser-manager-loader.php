<?php


class Parser_Manager_Loader {

	private $frontend_settings;

	public function run() {

		add_action( 'init', array( $this, 'plugin_init' ) );

		if ( is_admin() ) {
			$this->frontend_settings = new Parser_Manager_Settings;

			add_action( 'admin_menu', array( $this, 'admin_menu' ) );

			add_action( 'add_meta_boxes', array( $this, 'add_custom_box' ) );
			add_action( 'save_post_parser', array( $this, 'save_meta_boxes' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

    }

	public function plugin_init() {
		register_post_type(
			'parser',
			array(
				'labels' => array(
					'name'                  => __( 'Parsers', 'wcpv-returns' ),
					'singular_name'         => __( 'Parser', 'wcpv-returns' ),
					'all_items'             => __( 'All Parsers', 'wcpv-returns' ),
					'search_items'          => __( 'Search Parsers', 'wcpv-returns' ),
					'not_found'             => __( 'No parsers found.', 'wcpv-returns' ),
					'not_found_in_trash'    => __( 'No parsers found in Trash.', 'wcpv-returns' ),
					'menu_name'             => __( 'Parsers Manager', 'wcpv-returns' )
				),
				'public' => true,
				'show_ui' => true,
				'has_archive' => true,
				'menu_icon' => 'dashicons-feedback',
				'menu_position' => 21,
				'supports' => array( 'title', 'author' ),
			)
		);
	}

    public function admin_menu() {
	    add_submenu_page(
			'edit.php?post_type=parser',
			__( 'Parser Manager Settings', 'plugin-name' ),
			__( 'Settings', 'plugin-name' ),
			'manage_options',
			'parser-manager-settings.php',
			array( $this->frontend_settings, 'settings_page' )
		);
        add_submenu_page(
            'edit.php?post_type=parser',
            __( 'Parsers Test', 'plugin-name' ),
            __( 'Parsers Test', 'plugin-name' ),
            'manage_options',
            'parsers-test.php',
            array( $this->frontend_settings, 'parsers_test_page' )
        );
	}

	public function add_custom_box() {
		add_meta_box(
			'parser_data',
			'Parser Data',
			array( $this->frontend_settings, 'meta_box_data' ),
			'parser',
			'normal',
			'high'
		);
		add_meta_box(
			'parser_param',
			'Parser Parameters',
			array( $this->frontend_settings, 'meta_box_param' ),
			'parser',
			'normal',
			'high'
		);
	}

	public function save_meta_boxes( $post_id ) {
		if ( ! wp_verify_nonce( $_POST['prsrmngr_nonce'], 'meta_box_param' ) )
			return;

		$link = $_POST['prsrmngr_link'];

		update_post_meta( $post_id, '_prsrmngr_link', $link );
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'settings-style', plugins_url( 'assets/css/style.css', dirname( __FILE__ ) ) );
		wp_enqueue_script( 'settings-script', plugins_url( 'assets/js/script.js', dirname( __FILE__ ) ), array( 'jquery' ), '', true );
	}

    public function activation() {
        $this->settings();
        $this->db_create();
        register_uninstall_hook( __FILE__, array( $this, 'delete_options' ) );
    }

    private function settings() {}

    private function db_create() {
		global $wpdb;

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