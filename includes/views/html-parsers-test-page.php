<?php


$item_name = 'Gamma 2 Case';

$steam_parser = new Steam_Parser();

$res = $steam_parser->sell_listings( $item_name );
//die( var_dump( $res ) );



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