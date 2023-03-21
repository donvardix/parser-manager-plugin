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
            "SELECT CONCAT(UNIX_TIMESTAMP(created), '000') as x, data as y FROM {$this->wpdb_parser_data} WHERE parser_id = %d",
            absint( $id )
        ) );
    }

    public function add_parser_data( $parser_id, $data ): void {
        $this->wpdb->insert( $this->wpdb_parser_data,
            [
                'parser_id' => $parser_id,
                'data'      => maybe_serialize( $data )
            ]
        );
    }

}