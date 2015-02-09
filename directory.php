<?php


$docId = "1W3S_j9vi58Y5BMTPLdWptTQwScMWv5KrkU-r9R2_dvU";
$url = "https://spreadsheets.google.com/feeds/list/" . $docId . "/od6/public/values?alt=json";

$json = file_get_contents($url);
//echo $json;
$json_data = json_decode($json);

var_dump($json_data);
?>