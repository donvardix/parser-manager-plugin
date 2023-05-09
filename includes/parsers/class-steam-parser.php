<?php

defined( 'ABSPATH' ) || exit;

class Steam_Parser extends Parser {
    private $item_name = '';
    private $app_id = 0;

    public function parse_url( $url ): bool {
        $path = parse_url( $url, PHP_URL_PATH );

        if ( empty( $path ) ) {
            return false;
        }

        $params = array_reverse( explode( '/', $path ) );

        $item_name = ! empty( $params[0] ) ? $params[0] : false;
        $app_id    = ! empty( $params[1] ) ? absint( $params[1] ) : false;

        if ( ! $item_name || ! $app_id ) {
            return false;
        }

        $this->item_name = $item_name;
        $this->app_id    = $app_id;

        return true;
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
            PMP_Utils::log( 'sell_listings() | empty search results' );

            return false;
        }

        foreach ( $response['results'] as $result ) {
            if ( $response['searchdata']['query'] == $result['name'] ) {
                return [
                    'y'  => $result['sell_listings'],
                    'args' => [
                        [
                            'title' => 'Price',
                            'value'=> $result['sell_price_text']
                        ]
                    ],
                ];
            }
        }

        PMP_Utils::log( 'sell_listings() | no search matches found' );

        return false;
    }

    public function run( $method ) {
        switch ( $method ) {
            case 'sell_listings':
                return $this->sell_listings( $this->item_name, $this->app_id );
            case 'sell_listings2':
                return 'test2';
            default:
                PMP_Utils::log( 'Steam_Parser->run() | method not found' );

                return false;
        }
    }

}