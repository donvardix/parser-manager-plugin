<?php

defined( 'ABSPATH' ) || exit;

abstract class Parser {

    public $wp_method = true;

    public $sslverify = false;

    private $url;

    public function set_url( $url ) {
        $this->url = $url;
    }

    public function get_highcharts_data( $post_id, $multiple = false ) {
        $model       = new Parser_Model;
        $parser_data = $model->get_parser_by_id( $post_id );

        if ( $multiple ) {
            $multiple_parser_data = [];
            foreach ( $parser_data as $parser ) {
                $data = maybe_unserialize( $parser->y );

                if ( is_array( $data ) ) {
                    $hs_data = [
                        'x' => $parser->x,
                        'y' => $data['y']
                    ];

                    if ( ! empty( $data['a1'] ) ) {
                        $hs_data['a1'] = $data['a1'];
                    }

                    if ( ! empty( $data['a2'] ) ) {
                        $hs_data['a2'] = $data['a2'];
                    }
                } else {
                    $hs_data = [
                        'x' => $parser->x,
                        'y' => $parser->y
                    ];
                }

                $multiple_parser_data[] = $hs_data;
            }

            return $this->get_json( $multiple_parser_data );
        }

        return $this->get_json( $parser_data );
    }

    protected function get_html(): string {
        if ( $this->wp_method && function_exists( 'wp_remote_get' ) ) {
            return $this->wp_method();
        }

        return $this->curl_method();
    }

    protected function get_json( $data ) {
        return json_encode( $data, JSON_NUMERIC_CHECK );
    }

    private function wp_method(): string {
        $response = wp_remote_get( $this->url, [ 'sslverify' => $this->sslverify ] );

        return $response['body'];
    }

    private function curl_method(): string {
        $ch = curl_init( $this->url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $html = curl_exec( $ch );
        curl_close( $ch );

        return $html;
    }
}
