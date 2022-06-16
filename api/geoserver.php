<?php
$url = "http://localhost/geoserver/rest/workspaces/wilayaSIG/layers";
$ch = curl_init();	
$passwordStr = "admin:geoserver"; 
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERPWD, $passwordStr);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Accept: application/json'));
$data = curl_exec($ch);
var_dump($data);
curl_close($ch);
?>