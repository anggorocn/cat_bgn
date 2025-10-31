<?php
$hp= "085748554844";
$isi= "sss";

$data= [
	"to" => $hp,
	"body" => $isi,
	"instance" => "1",
	"appname" => "xxxx"
];

$env= $_ENV;
$url= $env["wa_text"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');

// curl_setopt($ch, CURLOPT_TIMEOUT, 500);
// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// execute post
$result = curl_exec($ch);
// close connection
curl_close($ch);
// print_r($result);exit();

$rs= json_decode($result);
?>