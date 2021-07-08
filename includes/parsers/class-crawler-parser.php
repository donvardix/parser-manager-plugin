<?php

use Symfony\Component\DomCrawler\Crawler;


class Crawler_Parser extends Parser{

    public function __construct() {
        $this->parser_args['url'] = 'https://neon.ua/product/_AMD_AM4_Ryzen_5_5600X_Tray_6x3_7_GHz_Turbo_Boost_4_6_GHz_L3_32Mb_Zen_3_7_nm_TDP_65W_100100000065__924998/';
    }

    public function start( $data ): array {
        $values = array();

        return $values;
    }

    public function test() {

        $crawler = new Crawler( $this->get_html() );

        $data = $crawler->filterXpath('//*[contains(@class, "price-2")]/span')->text();

        die( var_dump( $data ) );

    }

}