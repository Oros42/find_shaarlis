<?php
/**
 * @author Oros <shaarli [ at ] ecirtam.net>
 * @license public domain
 * @link https://github.com/Oros42/find_shaarlis
 * @version 20150516
 */

$debug=true;
if(!is_file("config.php")){
	copy("config.php.dist", "config.php");
}

include "config.php";
include "filter.php";

if(!is_dir($output_folder)){
	mkdir($output_folder);
}

foreach (array('shaarlis_opml', 'shaarlis_json', 'shaarlis_HS_json', 'annuaires_urls') as $var) {
	if(empty($$var)){
		die('$'.$var.' not set in config.php');
	}
}
$shaarlis = array();
$shaarlis_HS = array();
$line_size=0;
libxml_use_internal_errors(true);

/**
* @return array((string) XML_CODE, (string) ERROR_LEVEL, (string) ERROR_MESSAGE, (int) ERROR_LINE, (int) ERROR_COLUMN)
*/
function display_xml_error($error, $xml){
	$code = $xml[$error->line-1]."\n".str_repeat('-', $error->column)."^\n";
	switch ($error->level) {
		case LIBXML_ERR_WARNING:
			$level = "Warning $error->code: ";
			break;
		case LIBXML_ERR_ERROR:
			$level = "Error $error->code: ";
			break;
		case LIBXML_ERR_FATAL:
			$level = "Fatal Error $error->code: ";
			break;
	}
	return array($code, $level, trim($error->message), (int)$error->line, (int)$error->column);
}

function my_file_get_contents($url){
	return @file_get_contents($url, false, stream_context_create(array('http' => array('user_agent' => 'Mozilla/5.0 (Bot from https://github.com/Oros42/find_shaarlis)'))));
}

function print_msg($msg, $new_line=false){
	global $line_size;
	global $debug;
	if($debug){
		if(strlen($msg)>$line_size){
			$line_size=strlen($msg);
		}
		echo "\r".str_pad($msg, $line_size);
		if($new_line){
			echo "\n";
			$line_size=0;
		}
	}
}

function is_HS($xmlUrl){
	print_msg("check $xmlUrl ...");
	$body = my_file_get_contents($xmlUrl);
	if(!empty($body)) {
		$xml = simplexml_load_string($body);
		if(!empty($xml)){
			print_msg("check $xmlUrl OK");
			return "";
		}else{
			print_msg("error XML $xmlUrl", true);

			$errors = libxml_get_errors();
			$xml = explode("\n", $body);
			$e=array();
			foreach ($errors as $error) {
				$e[]=display_xml_error($error, $xml);
			}
			libxml_clear_errors();
			return array("type"=>"XML", "error"=>$e);
		}
	}else{
		print_msg("error URL $xmlUrl", true);
		return array("type"=>"URL", "error"=>array("404"));
	}
}

function clean_xmlUrl($url){
	return preg_replace('/([^:]{1})\/\//', '$1/', str_replace("index.php", "", str_replace("index.php5", "", str_replace("php/?", "php?", $url))));
}

function clean_htmlUrl($url){
	$url=clean_xmlUrl($url);
	$p=strrpos($url, "/");
	if($p > 9){
		// https://www.ecirtam.net/links/?do=rss
		// -> https://www.ecirtam.net/links/
		return substr($url, 0, $p+1);
	}else{
		return $url;
	}
}

/**
 * Add shaarlis in $shaarlis
 * @param URL of json file.
 * Example of file :
 * {"http:\/\/sebsauvage.net\/links\/?do=rss":{"text":"Liens en vrac de sebsauvage","htmlUrl":"http:\/\/sebsauvage.net\/links\/",...},...}
 */
function addViaJson($URL) {
	global $shaarlis;
	global $shaarlis_HS;
	global $filter;
	$body = my_file_get_contents($URL);
	if(!empty($body)) {
		$json = @json_decode($body, true);
		foreach ($json as $url => $data) {
			if(!in_array($url, $filter) && empty($shaarlis[$url]) && empty($shaarlis_HS[$url])){
				if(substr($url, 0,5)=="https"){
					if(isset($shaarlis["http".substr($url,5)])) {
						unset($shaarlis["http".substr($url,5)]);
					}
				}
				if(!(substr($url, 0,5)=="http:" && isset($shaarlis["https:".substr($url,5)]) )){
					$msg=is_HS($url);
					if($msg==""){
						// OK
						$shaarlis[$url] = array('text'=> $data['text'], 'htmlUrl'=> clean_htmlUrl($data['htmlUrl']));
					}else{
						// Error
						$msg['text']=$data['text'];
						$msg['htmlUrl']=clean_htmlUrl($data['htmlUrl']);
						$shaarlis_HS[$url] = $msg;
					}
				}
			}
		}
	}
}

/**
 * Add shaarlis in $shaarlis
 * @param URL of an OPML file
 */
function addViaOpml($URL) {
	global $shaarlis;
	global $shaarlis_HS;
	global $filter;
	$body = my_file_get_contents($URL);
	if(!empty($body)) {
		$xml = @simplexml_load_string($body);
		foreach ($xml->body->outline as $value) {
			$attributes = $value->attributes();
			$xmlUrl = clean_xmlUrl((string)$attributes->xmlUrl);
			if(!in_array($xmlUrl, $filter) && empty($shaarlis[$xmlUrl]) && empty($shaarlis_HS[$xmlUrl])){
				if(substr($xmlUrl, 0,5)=="https"){
					if(isset($shaarlis["http".substr($xmlUrl,5)])) {
						unset($shaarlis["http".substr($xmlUrl,5)]);
					}
				}
				if(!(substr($xmlUrl, 0,5)=="http:" && isset($shaarlis["https:".substr($xmlUrl,5)]) )){
					$msg=is_HS($xmlUrl);
					if($msg==""){
						// OK
						$shaarlis[$xmlUrl] = array('text'=> (string)$attributes->text, 'htmlUrl'=> clean_htmlUrl((string)$attributes->htmlUrl));
					}else{
						// Error
						$msg['text']=(string)$attributes->text;
						$msg['htmlUrl']=clean_htmlUrl((string)$attributes->htmlUrl);
						$shaarlis_HS[$xmlUrl] = $msg;
					}
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
function outputOPML($shaarlis, $shaarlis_opml) {
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
function outputJSON($shaarlis, $shaarlis_json) {
	file_put_contents($shaarlis_json, json_encode($shaarlis));
}

if(is_file($shaarlis_opml)){
	// add shaarlis of previous ./out/shaarlis.opml
	addViaOpml($shaarlis_opml);
}
if(is_file($shaarlis_HS_json)){
	// check if an HS shaarli is back
	// add shaarlis of previous ./out/shaarlis_HS.json
	addViaJson($shaarlis_HS_json);
}

$annuaires = array();
foreach ($annuaires_urls as $annuaires_url) {
	$f = my_file_get_contents($annuaires_url);
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
		outputOPML($shaarlis, $shaarlis_opml);
		outputJSON($shaarlis, $shaarlis_json);
		echo "\nNb shaarlis : ".count($shaarlis)."\n$shaarlis_opml\n$shaarlis_json\n";
	}
	if(!empty($shaarlis_HS)){
		outputJSON($shaarlis_HS, $shaarlis_HS_json);
		echo "\nNb shaarlis HS : ".count($shaarlis_HS)."\n$shaarlis_HS_json\n";
	}
}
?>