<?php

defined( 'ABSPATH' ) || exit;

class PMP_Utils {
    public static function log( $entry, $meta = '', $success = false ) {
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'];

        $data = [
            'success' => $success,
            'data'    => $entry,
            'meta'    => $meta
        ];

        $file = $upload_dir . '/' . 'parser-manager-plugin.log';
        $file = fopen( $file, 'a' );
        fwrite( $file, current_time( 'mysql' ) . "::" . json_encode( $data ) . "\n" );
        fclose( $file );
    }
}