<?php

namespace BBCNewsClassifier\Stages;

use Goutte\Client;
use League\Pipeline\StageInterface;
use Symfony\Component\DomCrawler\Crawler;

class Extract implements StageInterface
{
    public function __invoke($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $title = $crawler->filter('h1.story-body__h1')->each(function (Crawler $node) {
            return $node->text();
        });
        $title = implode("", $title);

        $body = $crawler->filter('div.story-body__inner > p')->each(function (Crawler $node) {
            return $node->text();
        });

        $body = implode("",$body);

        return $title.$body;
    }
}