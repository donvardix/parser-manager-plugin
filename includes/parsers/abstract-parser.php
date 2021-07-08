<?php


abstract class Parser {

    public $wp_method = true;
    protected $parser_args;

    protected function get_html(): string {
        if ( $this->wp_method && function_exists( 'wp_remote_get' ) ) {
            return $this->wp_method();
        } else {
            return $this->curl_method();
        }
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

}