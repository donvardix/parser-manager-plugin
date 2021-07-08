<?php


class Substr_Parser extends Parser{

    public function start( $data ): array {
        $values = array();
        foreach ( $data as $args ) {
            $this->parser_args = $args;
            $values[ $this->parser_args['id'] ] = $this->parser( $this->get_html() );
        }

        return $values;
    }

    private function parser( $html ): string {
        $delete_before = substr( $html, strpos( $html, $this->parser_args['start'] ) + strlen( $this->parser_args['start'] ) );

        return substr( $delete_before, 0, strpos( $delete_before, $this->parser_args['end'] ) );
    }

}