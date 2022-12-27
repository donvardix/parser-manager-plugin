<?php


$item_name = 'Gamma 2 Case';
$url = 'https://steamcommunity.com/market/listings/440/Mann%20Co.%20Supply%20Crate%20Key';

//$steam_parser = new Steam_Parser();
//
//$params = $steam_parser->parse_url( $url );
//$res = $steam_parser->sell_listings( $params['item_name'], $params['app_id'] );
//die( var_dump( $res ) );

$steam_parser = new Parser_Manager_Loader();
$steam_parser->add_to_queue();
$steam_parser->queue_start();


//use SteamApi\SteamApi;
//
//$api = new SteamApi();
//
//$response = $api->detailed()->searchItems(730, [
//    'query' => $item_name,
//    'exact' => false,
//] );
//
//die( '<pre>' . print_r( $response['response'], true ) . '</pre>' );