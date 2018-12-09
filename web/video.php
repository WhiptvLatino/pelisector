<?php
error_reporting(0);
include "drive.php";
$id = $_GET['id'];
$URL = "https://drive.google.com/file/d/".$id."/view?pli=1";
$linkdown = Drive($URL);
	$URL = "https://drive.google.com/get_video_info?docid=$id";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_URL, $URL);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response_data = urldecode(urldecode(curl_exec($curl)));
	curl_close($curl);									
	
	//status
	$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http";
	$shot = "https://drive.google.com/vt?".$_SERVER["QUERY_STRING"];
	$sharing = $protocol."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	if(preg_match("/errorcode=100/", $response_data) && strlen($_SERVER["QUERY_STRING"])!= "28"){
		$title = "Introducir el código de identificación de vídeo correcta.";
	} elseif(preg_match("/errorcode=100/", $response_data)) {
		$title = "Usted no tiene acceso a un video";
	} elseif(preg_match("/errorcode=150/", $response_data)) {
		$title = "Usted no tiene permiso para acceder a este vídeo.";
	} else {
		$title = preg_replace("/&BASE_URL.*/", Null, preg_replace("/.*title=/", Null, $response_data));
	}

$file = '[{file: "'.$linkdown.'",type: "video/mp4"}]';
header ("Location: $linkdown");
?>