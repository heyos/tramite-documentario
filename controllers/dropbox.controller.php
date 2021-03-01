<?php

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

class DropboxController {

	private static function config(){
		$AppKey = 'dfyr3dqu888zl3d';
		$AppSecret = '9iuj2hpbf6bwki5';
		$token = 'sahez_5j3hcAAAAAAAAAAXIrqYjDc9y6TUYl56WbXBQMCy5B013-oyRx8OuqvSso';

		$config = array(
			'key' => $AppKey,
			'secret' => $AppSecret,
			'token' => $token
		);

		return $config;
	}

	public static function upload($file,$path){

		try {

			$config = self::config();

			$app = new DropboxApp($config['key'],$config['secret'],$config['token']);
			$dropbox = new Dropbox($app);

			$file = $dropbox->simpleUpload($file, $path, ['autorename' => true]);

			//Uploaded File
			$response = $file->getName();

			print_r($response);

			return true;
			
		} catch (Exception $e) {

			print_r($e);
			return false;
		}
	}
}