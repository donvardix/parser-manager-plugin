<?php

defined( 'ABSPATH' ) || exit;
class Parser_Manager_Meta_Boxes {

    private const PARAMS = [
        'parser_link',
        'parser_method',
        'parser_xpatch',
        'parser_start',
        'parser_end'
    ];

    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'meta_boxes' ] );
        add_action( 'save_post_parser', [ $this, 'save' ] );
    }

    public function meta_boxes() {
        add_meta_box(
            'parser_data',
            'Parser Data',
            [ $this, 'data_box' ],
            'parser',
            'normal',
            'high'
        );
        add_meta_box(
            'parser_param',
            'Parser Parameters',
            [ $this, 'param_box' ],
            'parser',
            'normal',
            'high'
        );
    }

    public function data_box( $post ) {
        $data = [
            'post_id' => $post->ID
        ];
        require_once __DIR__ . '/views/html-meta-box-data.php';
    }

    public function param_box( $post ) {
        wp_nonce_field( 'meta_box_param', 'parser_nonce' );

        $data = [];
        foreach ( self::PARAMS as $param ) {
	        $data[ $param ] = get_post_meta( $post->ID, $param, true );
        }

        require_once __DIR__ . '/views/html-meta-box-param.php';
    }

    public function save( $post_id ) {
        if ( ! isset( $_POST['parser_nonce'] ) || ! wp_verify_nonce( $_POST['parser_nonce'], 'meta_box_param' ) )
            return;

        foreach ( self::PARAMS as $param ) {
            update_post_meta( $post_id, $param, htmlspecialchars( $_POST[ $param ] ) );
        }
    }

}
