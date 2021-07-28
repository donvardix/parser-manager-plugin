<?php


class Parser_Manager_Settings {

	public function meta_box_data() {
		require_once __DIR__ . '/views/html-meta-box-data.php';
	}

	public function meta_box_param( $post ) {
		wp_nonce_field( 'meta_box_param', 'prsrmngr_nonce' );

		$link = get_post_meta( $post->ID, '_prsrmngr_link', true );

		require_once __DIR__ . '/views/html-meta-box-param.php';
	}

	public function settings_page() {
        if ( isset( $_POST['submit'] ) ) {
            echo 'submit';
        }

        require_once __DIR__ . '/views/html-settings-page.php';
    }

	public function parsers_test_page() {
		require_once __DIR__ . '/views/html-parsers-test-page.php';
	}

}