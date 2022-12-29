<?php

defined( 'ABSPATH' ) || exit;

class Parser_Model {
	private $wpdb;
	private $wpdb_parser_data;

    public function __construct() {
        global $wpdb;

        $this->wpdb             = $wpdb;
        $this->wpdb_parser_data = $this->wpdb->prefix . 'pmp_parser_data';
    }

    /**
     * @param $id - parser id
     *
     * @return array|object|null
     */
    function get_parser_by_id( $id ) {
        return $this->wpdb->get_results( $this->wpdb->prepare(
            "SELECT data, created FROM {$this->wpdb_parser_data} WHERE parser_id = %d ORDER BY id DESC LIMIT 10",
            absint( $id )
        ) );
    }

	public function add_parser_data( $parser_id, $data ): void {
		$this->wpdb->insert( $this->wpdb_parser_data,
			[
				'parser_id' => $parser_id,
				'data' => $data
			]
		);
	}

    public function get_parser_data() {
        return $this->wpdb->get_results( "SELECT UNIX_TIMESTAMP(created) as qwe FROM {$this->wpdb_parser_data}" );
    }

}