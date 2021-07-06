<?php

class Template{

    public static function templateController(){

        include 'views/template.php';

    }

    public static function baseUrl(){

    	$base = dirname($_SERVER["SCRIPT_NAME"]);
        $base = str_replace('\\','/',$base);
        
        if ($base == '/') { 
            $base = NULL; 
        }

        //$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$domain = $_SERVER['HTTP_HOST'];
		$url = $protocol.$domain;

		define('BASE_URL',$url.$base.'/');
    }
}