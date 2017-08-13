<?php

require 'vendor/autoload.php';

use Goutte\Client;

$categoriesTree = scrapeItAll();
var_dump($categoriesTree[0]['subCategories']);


function scrapeItAll() {
    $domain = "https://www.airmatic.lt";
    $url = "$domain/lt/prekiu-katalogas.html";

    $css_selector = "#vmMainPage div.image > a";

    $client = new Client();
    $crawler = $client->request('GET', $url);
    $nodes = $crawler->filter($css_selector);

    $categories = [];
    /** @var DOMElement $node */
    foreach ($nodes as $node) {
        $category = [];
        $dig_url = $domain . $node->getAttribute('href'); // Connect new URL with site domain.

        $category['name'] = cleanTitles($node->parentNode->parentNode->textContent);
        $category['href'] = $node->getAttribute('href');

        $category['subCategories'] = getCategory($dig_url); // Dig deeper to get categories.
        $categories[] = $category;
    }

    return $categories;
}


function getCategory($url) {
    $categories = [];

    $client = new Client();
    $crawler = $client->request('GET', $url);

    $css_selector = 'div.element_bg a';

    $nodes = $crawler->filter($css_selector);

    /** @var DOMElement $node */
    foreach ($nodes as $node) {

        $category = [];
        $category['name'] = cleanTitles($node->textContent);
        $category['href'] = $node->getAttribute('href');

        $categories[] = $category;
    }

    return $categories;
}

function cleanTitles($title) {
    $title = preg_replace('/\t/', '', $title);
    $title = preg_replace('/\n/', '', $title);

    return trim(rtrim(strip_tags($title, " \t"), " \t"));
}
