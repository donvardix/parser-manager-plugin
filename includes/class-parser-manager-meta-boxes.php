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
            'parser_chart',
            'Parser Chart',
            [ $this, 'chart_box' ],
            'parser',
            'normal',
            'high'
        );
        add_meta_box(
            'parser_settings',
            'Parser Settings',
            [ $this, 'settings_box' ],
            'parser',
            'normal',
            'high'
        );
    }

    public function chart_box( $post ) {
        $data = [
            'post_id' => $post->ID,
	        'title' => get_the_title( $post->ID )
        ];
        require_once __DIR__ . '/views/html-meta-box-chart.php';
    }

    public function settings_box( $post ) {
        $data = [];
        foreach ( self::PARAMS as $param ) {
	        $data[ $param ] = get_post_meta( $post->ID, $param, true );
        }

        require_once __DIR__ . '/views/html-meta-box-settings.php';
    }

    public function save( $post_id ) {
        foreach ( self::PARAMS as $param ) {
            update_post_meta( $post_id, $param, htmlspecialchars( $_POST[ $param ] ) );
        }
    }

}
