<?php


$url = 'https://steamcommunity.com/market/listings/730/Prisma%20Case';

$steam_parser = new Steam_Parser;
$steam_parser->parse_url( $url );

//die( '<pre>' . print_r( $data, true ) . '</pre>' );

$count = 0;
$total = 1000;
for ( $i = 0; $i < $total; $i++ ) {
    $res = $steam_parser->run( 'sell_listings' );
    $count++;

    if ( ! $res ) {
        PMP_Utils::log( 'TEST -- END --', $count );
        break;
    }

    PMP_Utils::log( 'TEST', [ 'Count: ' . $count . ' || ', $res ], true );
}