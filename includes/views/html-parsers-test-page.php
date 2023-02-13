<?php


$item_name = 'Gamma 2 Case';
$url = 'https://steamcommunity.com/market/listings/440/Mann%20Co.%20Supply%20Crate%20Key';

$steam_parser = new Steam_Parser;
$data = $steam_parser->get_highcharts_data( 8440, true );

die( '<pre>' . print_r( $data, true ) . '</pre>' );