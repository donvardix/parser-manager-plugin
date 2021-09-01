<?php


class Ajax_Scripts {

    public function run() {

        add_action( 'wp_ajax_prsrmngr_xpatch_test', array( $this, 'xpatch_test' ) );

    }

    public function xpatch_test() {
        return 'test';
    }

}
