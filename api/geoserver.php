<?php
//$url = "http://localhost/geoserver/rest/workspaces/wilayaSIG/layers";
$projet='Routes_Region';
$url ="http://localhost/geoserver/ows?request=GetFeature&service=WFS&version=2.0.0&typename=wilayaSIG:$projet&outputformat=JSON";

$ch = curl_init();	
$passwordStr = "admin:geoserver"; 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERPWD, $passwordStr);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json'));
$data = curl_exec($ch);
//echo $data.features;
var_dump($data.features);
curl_close($ch);
?>

http://localhost/geoserver/ows?request=GetFeature&service=WFS&version=2.0.0&typename=wilayaSIG:places&outputformat=CSV
http://localhost/geoserver/ows?request=GetFeature&service=WFS&version=2.0.0&typename=wilayaSIG:Routes_Region&outputformat=JSON