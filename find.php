<?php
/**
 * @author Oros <shaarli [ at ] ecirtam.net>
 * @license public domain
 */

if(!is_file("config.php")){
	copy("config.php.dist", "config.php");
}

include "config.php";
include "filter.php";

if(!is_dir($output_folder)){
	mkdir($output_folder);
}

$shaarlis = array();

function clean_xmlUrl($url){
	return preg_replace('/([^:]{1})\/\//', '$1/', str_replace("index.php", "", str_replace("index.php5", "", str_replace("php/?", "php?", $url))));
}

function clean_htmlUrl($url){
	$url=clean_xmlUrl($url);
	$p=strrpos($url, "/");
	if($p > 9){
		// https:/www.ecirtam.net/links/?do=rss
		// -> https:/www.ecirtam.net/links/
		return substr($url, 0, $p+1);
	}else{
		return $url;
	}
}

/**
 * Add shaarlis in $shaarlis
 * @param URL of an OPML file
 */
function addViaOpml($URL) {
	global $shaarlis;
	global $filter;
	$body = @file_get_contents($URL);
	if(!empty($body)) {
		$xml = @simplexml_load_string($body);
		foreach ($xml->body->outline as $value) {
			$attributes = $value->attributes();
			$xmlUrl = clean_xmlUrl((string)$attributes->xmlUrl);
			if(!in_array($xmlUrl, $filter)){
				if(substr($xmlUrl, 0,5)=="https"){
					if(isset($shaarlis["http".substr($xmlUrl,5)])) {
						unset($shaarlis["http".substr($xmlUrl,5)]);
					}
				}
				if(!(substr($xmlUrl, 0,5)=="http:" && isset($shaarlis["https:".substr($xmlUrl,5)]) )){
					$shaarlis[$xmlUrl] = array('text'=> (string)$attributes->text, 'htmlUrl'=> clean_htmlUrl((string)$attributes->htmlUrl));
				}
			}
		}
	}
}

/**
 * Create OPML file with all shaarlis
 * Code from: https://github.com/mknexen/shaarli-api/blob/master/class/AbstractApiController.php
 * and https://github.com/pfeff/opml.php
 */
function outputOPML() {
	global $shaarlis_opml;
	global $shaarlis;
	$xml = new XMLWriter();
	$xml->openURI($shaarlis_opml);
	$xml->startDocument('1.0', 'UTF-8');
		$xml->startElement('opml');
			$xml->writeAttribute('version', '2.0');
			$xml->startElement('head');
			$xml->writeElement('title', 'Shaarli API OPML');
			$xml->writeElement('dateModified', date("D, d M Y H:i:s T"));
			$xml->endElement();
			$xml->startElement('body');
				foreach ($shaarlis as $xmlUrl =>$feed) {
					$xml->startElement('outline');
					$xml->writeAttribute('text', $feed['text']);
					$xml->writeAttribute('htmlUrl', $feed['htmlUrl']);
					$xml->writeAttribute('xmlUrl', $xmlUrl);
					$xml->endElement();
				}
			$xml->endElement();
		$xml->endElement();
	$xml->endDocument();
	$xml->flush();
}

/**
 * Create JSON file with all shaarlis
 */
function outputJSON() {
	global $shaarlis_json;
	global $shaarlis;
	file_put_contents($shaarlis_json, json_encode($shaarlis));
}

if(is_file($shaarlis_opml)){
	// add shaarlis of previous ./out/shaarlis.opml
	addViaOpml($shaarlis_opml);
}

$annuaires = array();
foreach ($annuaires_urls as $annuaires_url) {
	$f = @file_get_contents($annuaires_url);
	if(!empty($f)){
		$json = @json_decode($f, true);
		if($json){
			$annuaires = array_merge($annuaires, $json);
		}
	}
}
if(!empty($annuaires)){
	foreach ($annuaires as $url => $infos) {
		if($infos['is_active'] == 1){
			switch ($infos['type']) {
				case 'river' :
					break;

				case 'river-api' :
					addViaOpml($url."feeds?format=opml");
					break;

				case 'shaarlo' :
					addViaOpml($url."opml.php?mod=opml");
					break;

				case 'shaarlimages' :
					break;

				case 'shaarli-tv' :
					break;

				case 'annuaire' :
					break;
				
				default:
					break;
			}
		}
	}
	if(!empty($shaarlis)){
		outputOPML();
		outputJSON();
		echo "Nb shaarlis : ".count($shaarlis)."\n";
	}
}
?>