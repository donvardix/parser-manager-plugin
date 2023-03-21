<?php

defined( 'ABSPATH' ) || exit;

class Substr_Parser extends Parser {

    public function __construct( $url = '' ) {
        $this->set_url( $url );
    }

    public function run( $start, $end ): string {
        $html = $this->get_html();

        $delete_before = substr( $html, strpos( $html, $start ) + strlen( $start ) );

        return substr( $delete_before, 0, strpos( $delete_before, $end ) );
    }

}