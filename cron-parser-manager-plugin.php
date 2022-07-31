<?php

require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
require_once __DIR__ . '/vendor/autoload.php';

use SteamApi\SteamApi;

$post_id = 62;

//$market_hash_name = get_post_meta( $post_id, '_steam_api', true );
$market_hash_name = 'Prisma Case';

$api = new SteamApi();
//$response = $api->getItemPricing( 730, [
//	'market_hash_name' => $market_hash_name,
//	'currency'         => 1
//] );
//$value = $response['lowest_price'];



if ( ! empty( $response['lowest_price'] ) ) {
	$model = new Parser_Model();
	$model->set_parser_data( $post_id, $response['lowest_price'] );
}