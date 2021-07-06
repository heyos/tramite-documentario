<?php

function listDomainAccess($origin){

	$return = false;

	$domains = array(
		'localhost'
	);

	if(in_array($origin, $domains)){
		$return = true;
	}

	return $return;
}

function assets($ruta){

	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$domain = $_SERVER['HTTP_HOST'];
	$url = $protocol.$domain;

	echo BASE_URL.$ruta;
}

function assetsR($ruta){

	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$domain = $_SERVER['HTTP_HOST'];
	$url = $protocol.$domain;

	return BASE_URL.$ruta;
}