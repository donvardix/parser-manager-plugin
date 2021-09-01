<?php


abstract class Parser {

    public $wp_method = true;

    public $sslverify = false;

    protected $url;

    public function set_url( $url ) {
        $this->url = $url;
    }

    protected function get_html(): string {
        if ( $this->wp_method && function_exists( 'wp_remote_get' ) ) {
            return $this->wp_method();
        }

        return $this->curl_method();
    }

    private function wp_method(): string {
        $response = wp_remote_get( $this->url, array( 'sslverify' => $this->sslverify ) );

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