<?php

defined( 'ABSPATH' ) || exit;

class Parser_Manager_Utils {
    public function log( $value ) {
        if ( is_array( $value ) || is_object( $value ) ) {
            $value = print_r( $value, true );
        }

        error_log( 'PM Log: ' . $value );
    }
}