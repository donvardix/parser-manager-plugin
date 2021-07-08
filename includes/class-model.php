<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Model') ) {


class Model {
	private $wpdb;
	private $wpdb_parser, $wpdb_parser_data;

	function __construct() {
		global $wpdb;

		$this->wpdb = $wpdb;
		$this->wpdb_parser = $this->wpdb->prefix . 'prsrmngr_parser';
		$this->wpdb_parser_data = $this->wpdb->prefix . 'prsrmngr_parser_data';
	}

	function parser_init() {
		$result = $this->wpdb->get_results( "SELECT `id`, `url`, `start`, `end` FROM `{$this->wpdb_parser}`", ARRAY_A );

		$parser = new Substr_Parser();
		$elements = $parser->start( $result );
		foreach ( $elements as $parser_id => $value ) {
			$this->wpdb->insert( $this->wpdb_parser_data,
				array( 'value' => $value, 'parser_id' => $parser_id ),
				array( '%s', '%s' )
			);
		}
	}

	/**
	 * @return array|object|null
	 */
	function get_parser_names() {
		return $this->wpdb->get_results( "SELECT `id`, `name` FROM `{$this->wpdb_parser}`" );
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

new Model();

} // class_exists check