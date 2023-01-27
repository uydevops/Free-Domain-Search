<?php
require 'vendor/autoload.php';

function getDomain($keyword){

$client = new GuzzleHttp\Client();


$response = $client->request('GET', 'http://search.com.tr/ozel-domain/'.$keyword.'-tr.html');
$html = $response->getBody();
$dom = new DOMDocument();
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
foreach ($xpath->query('//k') as $node) {
    $node->parentNode->removeChild($node);
}
$div_tags = $dom->getElementsByTagName('div');
foreach ($div_tags as $tag) {
    if ($tag->getattribute('class') === 'domain_ic_sag_son') {
        $tag->parentNode->removeChild($tag);
    }
}
$xpath = new DOMXPath($dom);
$elements = $xpath->query("//div[@class='domain']//a");
$results = array();
foreach ($elements as $element) {
    $results[] = $element->nodeValue;
}
$date = date("d");
$months = array("Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık");
$month = $months[date('m', strtotime(date("d F Y"))) - 1];
$year = date("Y");
$days = array("Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar");
$day = $days[date('N', strtotime(date("d F Y"))) - 1];
require_once 'result.php';
}


$keyword = $_GET['q'];
getDomain($keyword);