<?php

defined( 'ABSPATH' ) || exit;

class Ajax_Scripts {

    public function run() {

        add_action( 'wp_ajax_prsrmngr_xpatch_test', [ $this, 'xpatch_test' ] );

    }

    public function xpatch_test() {
        return 'test';
    }

}
