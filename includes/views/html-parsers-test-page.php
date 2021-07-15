<?php

$demo = Demo_Data::get( 'neon' );

$crawler = new Crawler_Parser;
$crawler->set_url( $demo['url'] );
$crawler_result = $crawler->start( $demo['xpath'] );
echo 'Crawler - ' . $crawler_result . '<br />';


$substr = new Substr_Parser;
$substr->set_url( $demo['url'] );
$substr_result = $substr->start( $demo['substr_start'], $demo['substr_end'] );
echo 'Crawler - ' . $substr_result;