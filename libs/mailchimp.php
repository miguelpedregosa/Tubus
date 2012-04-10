<?php
require_once "CURL.php";
$url_endpoint = "http://us2.api.mailchimp.com/1.3/";
$api_key = "@@@@@@@@@@@@@"; #API Key para MailChimp
$list_id = "@@@@@@@@@@@@@"; #ID de la lista de correo

function suscribir_email($email)
{
	global $url_endpoint, $api_key, $list_id;
	
	$cc = new CURL();
	$url = $url_endpoint."?method=listSubscribe&apikey=".$api_key."&id=".$list_id."&email_address=".urlencode($email)."&double_optin=false";
	
	$data = $cc->get($url);
	$res = json_decode($data);
	if($res != "true")
		return false;
	return true;
	
}


