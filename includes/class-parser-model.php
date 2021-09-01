<?php


class Parser_Model {
	private $wpdb;
	private $wpdb_parser, $wpdb_parser_data;

    public function __construct() {
        global $wpdb;

        $this->wpdb             = $wpdb;
        $this->wpdb_parser      = $this->wpdb->prefix . 'prsrmngr_parser';
        $this->wpdb_parser_data = $this->wpdb->prefix . 'prsrmngr_parser_data';
    }

    /**
     * @param $id - parser id
     *
     * @return array|object|null
     */
    function get_parser_by_id( $id ) {
        return $this->wpdb->get_results( $this->wpdb->prepare(
            "SELECT `value`, `updated` FROM `{$this->wpdb_parser_data}` WHERE `parser_id` = %d", absint( $id )
        ) );
    }

    function set_parser( $fields ) {
        $this->wpdb->insert( $this->wpdb_parser,
            $fields,
            array( '%s', '%s', '%s', '%s' )
        );
    }

}