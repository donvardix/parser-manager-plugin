<?php

defined( 'ABSPATH' ) || exit;

class PM_Utils {
    public static function log( $value ) {
        if ( is_array( $value ) || is_object( $value ) ) {
            $value = print_r( $value, true );
        }

        error_log( 'PM Log: ' . $value );
    }
}