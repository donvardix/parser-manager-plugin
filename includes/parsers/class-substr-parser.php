<?php


class Substr_Parser extends Parser {

    public function start( $start, $end ): string {
        $html = $this->get_html();

        $delete_before = substr( $html, strpos( $html, $start ) + strlen( $start ) );

        return substr( $delete_before, 0, strpos( $delete_before, $end ) );
    }

}