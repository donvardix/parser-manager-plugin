<?php

use Symfony\Component\DomCrawler\Crawler;


class Crawler_Parser extends Parser {

    public function start( $xpath ): string {
        $crawler = new Crawler( $this->get_html() );

        return $crawler->filterXpath( $xpath )->text();
    }

}