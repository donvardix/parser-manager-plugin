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
		$parsers_names = [
			'xpatch' => 'Crawler_Parser',
			'selector' => 'Substr_Parser',
			'steam' => 'Steam_Parser',
		];

		$parser_method = get_post_meta( $post->ID, 'parser_method', true );
		if ( array_key_exists( $parser_method, $parsers_names ) ) {
			$parser = new $parsers_names[$parser_method];
			$highcharts_data = $parser->get_highcharts_data( $post->ID );
		}

        $data = [
            'post_id' => $post->ID,
	        'title' => get_the_title( $post->ID ),
	        'highcharts_data' => $highcharts_data ?? []
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
