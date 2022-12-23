<?php

defined( 'ABSPATH' ) || exit;

class Parser_Manager_Settings {

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