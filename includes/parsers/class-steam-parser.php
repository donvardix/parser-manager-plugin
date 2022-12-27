<?php

defined( 'ABSPATH' ) || exit;

class Steam_Parser extends Parser {

    public function sell_listings( $item_name, $app_id = 730 ) {
        $params = [
            'query' => $item_name,
            'appid' => $app_id,
            'start' => 0,
            'count' => 1,
            'norender' => 1
        ];

        $url = 'https://steamcommunity.com/market/search/render?' . http_build_query( $params, '', null, PHP_QUERY_RFC3986 );

        $this->set_url( $url );

        $response = json_decode( $this->get_html(), true );

        if ( empty( $response['results'] ) ) {
            PM_Utils::log( 'sell_listings() | empty search results' );
            return false;
        }

        foreach ( $response['results'] as $result ) {
            if ( $item_name == $result['name'] ) {
                PM_Utils::log( 'sell_listings() | search success' );
                return $result['sell_listings'];
            }
        }

        PM_Utils::log( 'sell_listings() | no search matches found' );
        return false;
    }

    public function run( $start, $end ): string {
        $html = $this->get_html();

        $delete_before = substr( $html, strpos( $html, $start ) + strlen( $start ) );

        return substr( $delete_before, 0, strpos( $delete_before, $end ) );
    }

}