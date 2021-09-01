<?php


class Parser_Manager_Meta_Boxes {

    private const PARAMS = array(
        'prsrmngr_link',
        'prsrmngr_method',
        'prsrmngr_xpatch',
        'prsrmngr_start',
        'prsrmngr_end'
    );

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ) );
        add_action( 'save_post_parser', array( $this, 'save' ) );
    }

    public function meta_boxes() {
        add_meta_box(
            'parser_data',
            'Parser Data',
            array( $this, 'data_box' ),
            'parser',
            'normal',
            'high'
        );
        add_meta_box(
            'parser_param',
            'Parser Parameters',
            array( $this, 'param_box' ),
            'parser',
            'normal',
            'high'
        );
    }

    public function data_box() {
        require_once __DIR__ . '/views/html-meta-box-data.php';
    }

    public function param_box( $post ) {
        wp_nonce_field( 'meta_box_param', 'prsrmngr_nonce' );

        $values = array();
        $params = self::PARAMS;
        foreach ( $params as $param ) {
            $values[ $param ] = get_post_meta( $post->ID, '_' . $param, true );
        }

        require_once __DIR__ . '/views/html-meta-box-param.php';
    }

	public function save( $post_id ) {
		if ( ! wp_verify_nonce( $_POST['prsrmngr_nonce'], 'meta_box_param' ) )
			return;

        $params = self::PARAMS;
        foreach ( $params as $param ) {
            update_post_meta( $post_id, '_' . $param, $_POST[ $param ] );
        }
    }

}
