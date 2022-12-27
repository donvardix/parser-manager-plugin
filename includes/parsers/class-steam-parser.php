<?php

defined( 'ABSPATH' ) || exit;

class Steam_Parser extends Parser {

    public function parse_url( $url ) {
        $path = parse_url( $url, PHP_URL_PATH );

        if ( empty( $path ) ) {
            return false;
        }

        $params = array_reverse( explode( '/', $path ) );

        $item_name = ! empty( $params[0] ) ? $params[0] : false;
        $app_id = ! empty( $params[1] ) ? absint( $params[1] ) : false;

        if ( ! $item_name || !$app_id ) {
            return false;
        }

        return [
            'item_name' => $item_name,
            'app_id' => $app_id
        ];
    }

    public function sell_listings( $item_name, $app_id = 730, $start = 0, $count = 100 ) {

        $url = sprintf( 'https://steamcommunity.com/market/search/render?query=%s&appid=%s&start=%s&count=%s&norender=1',
            $item_name,
            $app_id,
            $start,
            $count
        );

        $this->set_url( $url );

        $response = json_decode( $this->get_html(), true );

        if ( empty( $response['results'] ) ) {
            PM_Utils::log( 'sell_listings() | empty search results' );
            return false;
        }

        foreach ( $response['results'] as $result ) {
            if ( $response['searchdata']['query'] == $result['name'] ) {
                PM_Utils::log( 'sell_listings() | search success' );
                return $result['sell_listings'];
            }
        }

        PM_Utils::log( 'sell_listings() | no search matches found' );
        return false;
    }

}