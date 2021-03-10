<?php

class Parser {

	private array $data;
	private array $parser_args;

	function __construct( $data ) {
		$this->data = $data;
	}

	private function parser( $html ) {
		if ( 'dom_parser' == $this->parser_args['parser_method'] ) {
			return $this->dom_parser( $html );
		} else {
			return $this->strpos_parser( $html );
		}
	}

	private function get_html(): string {
		if ( 'wp_method' == $this->parser_args['get_html_method'] && function_exists( 'wp_remote_get' ) ) {
			return $this->wp_method();
		} else {
			return $this->curl_method();
		}
	}

	private function strpos_parser( $html ): string {
		$delete_before = substr( $html, strpos( $html, $this->parser_args['start'] ) + strlen( $this->parser_args['start'] ) );

		return substr( $delete_before, 0, strpos( $delete_before, $this->parser_args['end'] ) );
	}

	private function dom_parser( $html ): array {
		$dom = new DOMDocument();
		$dom->loadHTML( $html );

		$elements = $dom->getElementsByTagName( 'span' );
		$value    = array();
		foreach ( $elements as $elem ) {
			if ( $elem->hasAttribute( 'itemprop' ) && 'price' == $elem->getAttribute( 'itemprop' ) ) {
				$value[] = $elem->nodeValue;
			}
		}

		return $value;
	}

	private function wp_method(): string {
		$response = wp_remote_get( $this->parser_args['url'], array( 'sslverify' => false ) );

		return $response['body'];
	}

	private function curl_method(): string {
		$ch = curl_init( $this->parser_args['url'] );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$html = curl_exec( $ch );
		curl_close( $ch );

		return $html;
	}

	function start(): array {
		$values = array();
		foreach ( $this->data as $args ) {
			$this->parser_args = $args;
			$values[] = $this->parser( $this->get_html() );
		}

		return $values;
	}

	function test() {
		$url = 'https://neon.ua/product/_AMD_AM4_Ryzen_5_5600X_Tray_6x3_7_GHz_Turbo_Boost_4_6_GHz_L3_32Mb_Zen_3_7_nm_TDP_65W_100100000065__924998/';
//		$url = 'https://www.google.com/';

		$response = wp_remote_get( $url, array( 'sslverify' => false ) );

		die( '<pre>' . print_r( $response, true ) . '</pre>' );
	}

}