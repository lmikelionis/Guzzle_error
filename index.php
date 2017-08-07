
<?php
use GuzzleHttp\Client;
 require 'vendor/autoload.php';
/*
use Goutte\Client;

$guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
$client->setHttpClient($guzzleClient);
*/
$url = "https://www.sitepoint.com/feed/";
$client = new GuzzleHttp\Client();
$request = $client->request('GET',$url, ['verify' => false]); //where $url is your http address
require 'vendor/autoload.php';

$css_selector = "a.title.may-blank";
$thing_to_scrape = "_text";
$client = new Client();
$crawler = $client->request('GET', $url);
$output = $crawler->filter($css_selector)->extract($thing_to_scrape);
var_dump($output);
?>