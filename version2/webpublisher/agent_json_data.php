<?php
$agent_id = $_GET['agentid'];
# This is the area where the XML is read by PHP. It then outputs a select box, which will be used by jQuery to populate the page data.
# Firstly, the XML feed data.
$xml_client_name = 'raywhitedoublebay';
$xml_client_id = 'rwhdby';
$xml_ca_base = 'http://www.' . $xml_client_name . '.ca.com.au/';
$xml_base_url = $xml_ca_base . 'cgi-bin/clients/' . $xml_client_id . '/';
$xml_staff = $xml_base_url . 'getstaff_xml.cgi?clientid=' . $xml_client_id . '&agentid=' . $agent_id;
# $paul = 'http://www.raywhitedoublebay.ca.com.au/cgi-bin/clients/rwhdby/getstaff_xml.cgi?clientid=rwhdby&agentid=200983';
$simple_staff = simplexml_load_file($xml_staff);

function simplexml2array($xml) {
   if (get_class($xml) == 'SimpleXMLElement') {
       $attributes = $xml->attributes();
       foreach($attributes as $k=>$v) {
           if ($v) $a[$k] = (string) trim(iconv('ISO-8859-1', 'UTF-8', $v));
	   }
	   # Added the "trim" to this line, as there was a lot of crap being carried along with the XML.
	   # Currently unsupported characters are being displayed. These need to be changed into their correct characters.
       $x = trim($xml);
       $xml = get_object_vars($xml);
   }
   if (is_array($xml)) {
       if (count($xml) == 0) return (string) $x; // for CDATA
       foreach($xml as $key=>$value) {
           $r[$key] = simplexml2array($value);
       }
       if (isset($a)) $r['@'] = $a;    // Attributes
       return $r;
   }
   return (string) $xml;
}
    /**
    * Encodes an ISO-8859-1 mixed variable to UTF-8 (PHP 4, PHP 5 compat)
    * @param    mixed    $input An array, associative or simple
    * @param    boolean  $encode_keys optional
    * @return    mixed     ( utf-8 encoded $input)
    */

$array = simplexml2array($simple_staff);
//print_r($array);

// output correct header
$xhr = isset($_SERVER['HTTP_X_REQUESTED_WITH']) and (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
header('Content-Type: ' . ($xhr ? 'application/json' : 'text/plain; charset=utf-8'));
 
$json = json_encode($array);
$search = array('\u0092', '\u0093', '\u0094');
$replace = array('\'', '\"', '\"');
$json = str_replace($search, $replace, $json);

echo $json;



?>
