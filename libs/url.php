<?php
function get_parada_id(){
	//Delete the characters beginning by ?, those characters are the GET parameters included in the URI called	
	$server_uri = preg_replace('/\?(.)*/','',$_SERVER['REQUEST_URI'] );
	$url_args = preg_split('/\/+/', $server_uri);
	array_shift($url_args); // The first element is always a "/"	
	//The bus stop id will be in the first element of the array
	if(is_numeric($url_args[0]))
		return (int)$url_args[0];
	else 
		return false;
	
}
function is_home(){
	if ($_SERVER['REQUEST_URI'] == '/')
		return true;
	else
		return false;
}
?>
