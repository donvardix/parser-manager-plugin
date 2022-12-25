<?php

//$demo = Demo_Data::get( 'neon' );
//
//$crawler = new Crawler_Parser;
//$crawler->set_url( $demo['url'] );
//$crawler_result = $crawler->start( $demo['xpath'] );
//echo 'Crawler - ' . $crawler_result . '<br />';
//
//
//$substr = new Substr_Parser;
//$substr->set_url( $demo['url'] );
//$substr_result = $substr->start( $demo['substr_start'], $demo['substr_end'] );
//echo 'Crawler - ' . $substr_result;

use SteamApi\SteamApi;


$api = new SteamApi();

$post_id = 62;

//$market_hash_name = get_post_meta( $post_id, '_steam_api', true );
$market_hash_name = 'Prisma 2 Case';

$url = 'https://steamcommunity.com/market/search/render?appid=730&start=0&count=1&query=Prisma%20Case&norender=1';
$response = wp_remote_get( $url );

$res = json_decode( $response['body'] );
var_dump($res);
die( '<pre>' . print_r( $res, true ) . '</pre>' );

//$response = $api->SearchItems( 730, [
//    'start' => 0,
//    'count' => 100,
//    'query' => $market_hash_name,
//    'exact' => true
//] );

//$response = $api->detailed()->searchItems(730, [
//    'query' => $market_hash_name,
//    'exact' => false,
//] );
//
//die( '<pre>' . print_r( $response['response'], true ) . '</pre>' );
//
//$value = $response['lowest_price'];



//if ( ! empty( $response['lowest_price'] ) ) {
//    $model = new Parser_Model();
//    $model->set_parser_data( $post_id, $response['lowest_price'] );
//}